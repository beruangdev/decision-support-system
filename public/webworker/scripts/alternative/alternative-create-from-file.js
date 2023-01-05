importScripts("https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.core.min.js")

var altclass
self.onmessage = async (e) => {
    let message = e.data;
    let data = e.data.data

    if (message.event == "init") {
        altclass = new AlternativeCreate(self, {
            url: data.url,
            csrf: data.csrf,
        })
    }

    if (message.event == "onChangeInputFile") {
        altclass.read_file(data)
    }

    // self.postMessage(data);
};

class AlternativeCreate {
    per_page = 500
    #queues = []
    progress_read_exel = 15
    constructor(self, { url, csrf }) {
        this._self = self
        this.url = url
        this.csrf = csrf
    }
    get queues() {
        return this.#queues;
    }
    update_queues() {
        console.log("update_queues");
        console.log(this.#queues);
        this._self.postMessage({
            action: "update_queues",
            data: this.#queues
        })
    }
    push_queues(new_queue) {
        this.#queues.push(new_queue)
        this.update_queues()
        return this.#queues
    }
    update_queue(index, new_data = {}) {
        this.#queues[index] = { ...this.#queues[index], ...new_data }
        this.update_queues()
        return this.#queues
    }
    update_progress() {
        this.#queues = this.#queues.map((queue, index) => {
            let is_done = queue.progress_chunks.filter(pc => pc == true)
            // let total_progres = 100 - this.progress_read_exel
            let progress = (is_done.length / queue.progress_chunks.length) * 100
            progress = Math.min(100, progress)
            if (progress >= 100) {
                // this._self.postMessage({
                //     action: "push_alerts",
                //     data: {
                //         text: `${queue.total_row} Alternative already created successfully`,
                //         status: true,
                //     }
                // })
                this._self.postMessage({
                    action: "finish",
                    data: null
                })
            }

            // progress += this.progress_read_exel
            return { ...queue, progress }
        })
        this.update_queues()
        return this.#queues
    }
    read_file(file) {
        let _this = this

        let regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.csv)$/;
        if (!regex.test(file.name.toLowerCase())) {
            this._self.postMessage({
                action: "push_alerts",
                data: {
                    text: "Please upload a valid Excel file. (xls, xlsx, csv)",
                    status: false,
                }
            })
            return false
        }
        let reader = new FileReader();
        reader.onload = function (e) {
            let data = e.target.result;
            let workbook = XLSX.read(data, {
                type: 'binary'
            });
            console.log("file", file);
            console.log("workbook", workbook);
            workbook.SheetNames.forEach(function (sheet_name) {
                let queue = {
                    name: _this.slug(`${file.name} ${sheet_name}`),
                    total_row: 0,
                    progress: 0,
                    progress_chunks: []
                }
                _this.push_queues(queue)
                let sheet_data = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet_name]);
                sheet_data = JSON.parse(JSON.stringify(sheet_data));

                function chunk(arr, size) {
                    return Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
                        arr.slice(i * size, i * size + size)
                    );
                }

                let sheet_data_chunks = chunk(sheet_data, _this.per_page)
                const index_queue = _this.queues.length - 1
                _this.update_queue(index_queue, {
                    total_row: sheet_data.length,
                    progress_chunks: sheet_data_chunks.map(joc => false)
                })
                // let queue = {
                //     name: _this.slug(`${file.name} ${sheet_name}`),
                //     total_row: sheet_data.length,
                //     progress: 0,
                //     progress_chunks: sheet_data_chunks.map(joc => false)
                // }
                // _this.push_queues(queue)

                // new ProcessData(_this.queues.length - 1, sheet_data_chunks, {
                //     csrf: _this.csrf,
                //     url: _this.url,
                // })
                _this.process_data(index_queue, sheet_data_chunks)
            })
        };

        reader.onerror = function (ex) {
            console.log("reader error", ex);
            _this._self.postMessage({
                action: "push_alerts",
                data: {
                    text: "File is error to read",
                    status: false,
                }
            })
        };

        reader.readAsBinaryString(file);
    }
    process_data(index_queue, sheet_data_chunks) {
        // console.log(index_queue, sheet_data_chunks);

        let is_has_name_header = false
        let alternative_keys = {
            name: "",
            description: "",
            uuid: "",
        }

        Object.keys(sheet_data_chunks[0][0]).forEach(key => {
            let slug = this.slug(key)
            if (slug == "name") {
                is_has_name_header = true
                alternative_keys.name = key

            } else if (slug == "uuid") {
                alternative_keys.uuid = key

            }
            else if (slug == "description") {
                alternative_keys.description = key

            }
        })

        // Validate file has header name
        if (!is_has_name_header) {
            this._self.postMessage({
                action: "push_alerts",
                data: {
                    text: "Need header 'name'. Header 'name' is required",
                    status: false,
                }
            })
            return false
        }

        for (let index_chunk = 0; index_chunk < sheet_data_chunks.length; index_chunk++) {
            const sheet_data_chunk = sheet_data_chunks[index_chunk];
            // split perpage
            const body = this.make_body(sheet_data_chunk, alternative_keys)
            this.ajax(index_queue, index_chunk, body)

            console.log("body", body);
        }

    }
    make_body(sheet_data_chunk, alternative_keys) {
        let body = {
            alternatives: [],
            details: [],
        }

        for (let index = 0; index < sheet_data_chunk.length; index++) {
            const json_object = sheet_data_chunk[index];
            let alternative = {}
            alternative.name = json_object[alternative_keys.name]
            if (json_object[alternative_keys.uuid]) {
                alternative.uuid = json_object[alternative_keys.uuid]
            }
            if (json_object[alternative_keys.description]) {
                alternative.description = json_object[alternative_keys.description]
            }
            body.alternatives.push(alternative)

            let detail = []
            Object.keys(json_object).forEach(key => {
                const slug = this.slug(key)
                if (!["name", "description","id", "uuid", "no", "number", "nomor"].includes(slug)) {
                    detail.push({
                        key: key,
                        value: json_object[key]
                    })
                }
            })
            body.details.push(detail)
        }
        return body
    }
    ajax(index_queue, index_chunk, body) {
        fetch(this.url, {
            method: 'POST',
            body: JSON.stringify(body),
            headers: {
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                'Content-Type': 'application/json',
                'url': this.url,
                "X-CSRF-Token": this.csrf
            },
        }).then(async (response) => {
            if (response.ok) {
                return {
                    data: await response.json(),
                    status: true,
                };
            } else {
                return {
                    data: await response.text(),
                    status: false,
                };
            }
        }).then(({ data, status }) => {
            // This is the JSON from our response
            console.log("status", status);
            console.log("response", data);
        }).catch((err) => {
            // There was an error
            console.warn('Something went wrong.', err);
        }).finally(() => {
            console.log("this.queues[this.index_queue]", index_queue);
            // this.update_queue(index_queue, { progress: 100 })
            this.queues[index_queue].progress_chunks[index_chunk] = true
            this.update_progress()
        })
    }
    slug(text) {
        return text.toString().toLowerCase().trim()
            .normalize('NFD') 				 // separate accent from letter
            .replace(/[\u0300-\u036f]/g, '') // remove all separated accents
            .replace(/\s+/g, '-')            // replace spaces with -
            .replace(/&/g, '-and-')          // replace & with 'and'
            .replace(/[^\w\-]+/g, '')        // remove all non-word chars
            .replace(/\-\-+/g, '-')          // replace multiple '-' with single '-'
    }
}
