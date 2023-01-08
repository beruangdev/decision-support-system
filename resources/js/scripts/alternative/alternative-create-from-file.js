window.createAlternativeFromFile = createAlternativeFromFile
function createAlternativeFromFile(element) {
    return {
        element,
        can_update_table: true,
        queues: [
            {
                name: "",
                total_row: 0,
                progress: 0,
                progress_chunks: []
            }
        ],

        progress_read_exel: 15,
        per_page: 500,

        progress: 0,
        progress_arr: [],
        progress_display: 0,
        length: 0,
        alerts: [
            // {
            //     text: "1000 Alternative already upload successfully",
            //     status: true,
            // },
            // {
            //     text: "Alternative not uploaded",
            //     status: false,
            // },
            // {
            //     text: "1000 Alternative already upload successfully",
            //     status: true,
            // },
        ],


        interval: null,
        worker: new Worker(`${ASEET_PATH}/webworker/scripts/alternative/alternative-create-from-file.js?version=${version}`),
        init() {
            this.queues = []
            this.worker.postMessage({
                event: "init", data: {
                    csrf,
                    url: this.url(),
                }
            });
            this.worker.onmessage = (event) => {
                const action = event.data.action
                const data = event.data.data
                console.log("  ");
                console.log('====================================');
                console.log("action", action);
                console.log("data", data);
                console.log('====================================');
                console.log("  ");
                // console.log("this", this);

                if (action == "update") this.update(data)
                if (action == "add_queue") this.add_queue(data)
                if (action == "update_queues") this.queues = data
                if (action == "push_alerts") this.alerts.push(data)
                if (action == "finish") {
                    this.update_table()
                }

                this.log("queues", this.queues);

            };

        },
        limit_progress(progress) {
            if (Number.isInteger(progress)) return progress
            return parseFloat(progress.toFixed(2))

        },
        add_queue(data) {
            this.queues.push(data)
        },
        update(data) {
            Object.keys(data).forEach(key => {
                console.log("type", typeof this[key], " = is array: ", Array.isArray(this[key]));
                if (typeof this[key] == "object") {
                    // if data is Object merge data
                    if (Array.isArray(this[key])) {
                        console.log("is_rray");
                        this[key] = [...this[key], ...data[key]]
                    }
                    else {
                        console.log("is_obj");
                        this[key] = { ...this[key], ...data[key] }
                    }
                } else {
                    // if data is not Object replace data
                    console.log("not obj");
                    this[key] = data[key]
                }
            })
        },
        onChangeInputFile(evt) {
            this.progress = 1
            this.progress_display = 1
            let files = evt.target.files;
            for (let i = 0; i < files.length; i++) {
                // this.read_exel(files[i])
                this.worker.postMessage({ event: "onChangeInputFile", data: files[i] });
            }
            evt.target.value = []
        },
        update_table() {
            if (this.can_update_table) {
                this.can_update_table = false
                if (window.table_alternative) {
                    window.table_alternative.ajax.reload(() => {
                        this.can_update_table = true
                    }, false)
                }
            }
        },
        deleteAlert(index) {
            this.alerts.splice(index, 1)
        },
        set_progress() {
            console.log("set_progress");
            let _this = this

            let total_progres = 100 - this.progress_read_exel

            let is_done = _this.progress_arr.filter(pa => pa == true)
            _this.progress = Math.min(_this.progress_read_exel + (is_done.length / _this.progress_arr.length) * total_progres, 100)
            console.log("_this.progress", _this.progress, `( ${is_done.length} / ${_this.progress_arr.length} ) * ${total_progres}`);
            _this.progress_display = Number.isInteger(_this.progress) ? _this.progress : _this.progress.toFixed(2)
            _this.progress = Number.isInteger(_this.progress) ? _this.progress : _this.progress.toFixed(4)
            console.log("_this.progress", _this.progress);

            if (_this.progress >= 100) {
                _this.messages.push({
                    text: `${_this.length} Alternative already upload successfully`,
                    status: true,
                })
                _this.done()
            }
        },
        url() {
            return element.getAttribute("action")
        },
        slugify(text) {
            return text.toString().toLowerCase().trim()
                .normalize('NFD') 				 // separate accent from letter
                .replace(/[\u0300-\u036f]/g, '') // remove all separated accents
                .replace(/\s+/g, '-')            // replace spaces with -
                .replace(/&/g, '-and-')          // replace & with 'and'
                .replace(/[^\w\-]+/g, '')        // remove all non-word chars
                .replace(/\-\-+/g, '-')          // replace multiple '-' with single '-'
        },
        log() {
            let datas = []
            for (let index = 0; index < arguments.length; index++) {
                let argument = arguments[index];
                if (typeof argument == "object") argument = this.get(argument)
                datas.push(argument)
            }
            console.log(...datas);
        },
        get(data) {
            return JSON.parse(JSON.stringify(data))
        },
    }
}
