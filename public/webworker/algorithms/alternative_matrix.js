'use strict';
class AlternativeMatrix {
    constructor(self, { url, csrf }) {
        this.self = self

        this.url = url
        this.csrf = csrf

        // this.paginate = 15
        this.paginate = 10000
        this.alternative_progress = {
            queues: [],
            percent: 0,
        }

        this.alternatives = []
        this.alternative_array = [] // diurutkan berdasarkan ID user
        this.alternative_array_rotate = [] // diurutkan berdasarkan Criteria user
        this.chunk_decision_matrix = []
        this.decision_matrix = []

        this.calculate = {}
        this.project_method = {}
        this.criterias = []
    }

    async get_alternative_data() {
        const start = performance.now()
        let records = await fetch(this.url, {
            method: "POST",
            body: JSON.stringify({
                event: "metadata"
            }),
            headers: {
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                'Content-Type': 'application/json',
                'url': this.url,
                "X-CSRF-Token": this.csrf
            },
        })
        records = await records.json()
        this.self.postMessage({
            event: "metadata",
            data: records
        })
        this.calculate = records.calculate
        this.project_method = this.calculate.project_method
        this.criterias = records.criterias.filter(c => c.checked == 1)

        this.alternative_progress.queues = []
        this.alternative_progress.percent = 0

        for (let page = 1; true; page++) {
            let request = {
                event: "alternative"
            }
            this.alternative_progress.queues.push(false)
            this.alternatives.push(null)
            this.fetch_alternative({ start, page, request })
            if (page == (parseInt(records.alternative_count / this.paginate) + 1)) break
            // if (page == parseInt(records.alternative_count / this.paginate)) break
        }
    }
    async fetch_alternative({ start, page, request }) {
        const searchParams = new URLSearchParams({})
        searchParams.set("page", page)
        searchParams.set("paginate", this.paginate)
        const url = `${this.url}?${searchParams}`
        let records = await fetch(url, {
            method: "POST",
            body: JSON.stringify(request),
            headers: {
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                'Content-Type': 'application/json',
                'url': url,
                "X-CSRF-Token": this.csrf
            },
        })
        records = await records.json()
        this.alternatives[page - 1] = records.alternatives
        this.alternatives_finish_item(start, page - 1)
    }
    alternatives_finish_item(start, index) {
        this.alternative_progress.queues[index] = true
        let queues = this.alternative_progress.queues
        this.alternative_progress.percent = queues.filter(q => q == true).length / queues.length * 100
        this.self.postMessage({
            event: "decision_matrix_progress",
            data: this.alternative_progress.percent
        })
        if (queues.length > 0 && queues.every(data => data == true)) {
            this.alternatives_finish_fetch_all(start)
        }
    }
    alternatives_finish_fetch_all(start) {
        console.log("Get all ALTERNATIVES", `${performance.now() - start} ms`)
        this.alternatives = this.alternatives.flat()
        this.Decision_matrix()
    }
    Decision_matrix() {
        const name = "decision_matrix"
        const start = performance.now()
        // let dt_alternatives = []
        for (let index = 0; index < this.alternatives.length; index++) {
            const alt = this.alternatives[index];
            let name = `[${alt.uuid}] ${alt.name}`
            // let name = alt.name
            let newalt = [index + 1, name]
            for (let index_c = 0; index_c < this.criterias.length; index_c++) {
                newalt.push(alt.details[this.criterias[index_c].name])

                // buat array baru didalam array rotate untuk menampung data
                if (!this.alternative_array_rotate[index_c]) this.alternative_array_rotate[index_c] = []
                // Push data ke array rotate
                this.alternative_array_rotate[index_c].push(alt.details[this.criterias[index_c].name])
            }
            this.decision_matrix.push(newalt)
        }
        this.alternative_array = this.rotate_array(this.alternative_array_rotate)

        let data =
            this.self.postMessage({
                event: "decision_matrix",
                data: {
                    decision_matrix: this.display(this.chunk(this.decision_matrix, 10)[0] ?? []),
                    criterias: this.criterias,
                },
                recordsTotal: this.decision_matrix.length,

                name,
                event: `update_data`,
                page: 1,
            })

        console.log("Decision_matrix", `${performance.now() - start} ms`)
        this.Average_solution()
    }
    get_data({ name, length, page, order, search }) {
        const start = performance.now()
        console.log("GET DATA", name, length, page, order, search);
        let datas = [...this[name]]

        if (search && search != "") {
            let searched = []
            for (let index = 0; index < datas.length; index++) {
                let row = datas[index];
                if (Array.isArray(row)) row = row.join(" ").toLocaleLowerCase()
                if (row.includes(search.toLocaleLowerCase())) {
                    searched.push(datas[index])
                }
            }
            datas = searched
        }

        if (order[1] == "asc") {
            datas.sort((b, a) => a[order[0]] == b[order[0]] ? 0 : (b[order[0]] < a[order[0]] ? -1 : 1))
        } else {
            datas.sort((a, b) => a[order[0]] == b[order[0]] ? 0 : (b[order[0]] < a[order[0]] ? -1 : 1))
        }
        const recordsDisplay = datas.length

        // Loop sampai menemukan page yang ada isi
        let chunk = []
        for (page; chunk.length == 0; page--) {
            chunk = this.chunk(datas, parseInt(length))[page - 1] ?? []
            if (page == 1 || chunk.length > 0) break
        }

        this.self.postMessage({
            name,
            event: `update_data`,
            data: this.display(chunk),
            recordsDisplay,
            page,
        })
        console.log(`GET DATA`, name, `${performance.now() - start} ms`);
    }
    rotate_array(array) {
        let new_array = []
        for (let index1 = 0; index1 < array[0].length; index1++) {
            const data1 = array[index1];
            new_array.push([])
            for (let index2 = 0; index2 < array.length; index2++) {
                const data2 = array[index2];
                new_array[index1].push(data2[index1])
            }
        }
        return new_array
    }
    display(records) {
        const float_limit = 3
        let className = ["table-td"]
        if (!Array.isArray(records)) {
            if (!isNaN(parseFloat(records))) {
                if (!Number.isInteger(parseFloat(records))) records = parseFloat(records).toFixed(float_limit)
                records = parseFloat(records)
            } else {
                className.push("text-xs")
            }
            return `<span class="${className.join(" ")}">${records}</span>`
        }

        let new_arrays = []
        for (let index = 0; index < records.length; index++) {
            let element = records[index]
            new_arrays.push(this.display(element))
        }
        return new_arrays
    }
    chunk(array, per_page) {
        let result = [];
        for (let i = 0; i < array.length; i += per_page) {
            result.push(array.slice(i, i + per_page));
        }
        return result;
    }
    sort(array, direction) {
        if (direction && direction == "desc") {
            for (let i = 0; i < array.length; i++) {
                for (let j = i; j < array.length; j++) {
                    if (array[i] < array[j]) {
                        let temp = array[i];
                        array[i] = array[j];
                        array[j] = temp;
                    };
                };
            };
            return array;
        } else {
            for (let i = array.length - 1; i >= 0; i--) {
                for (let j = i; j >= 0; j--) {
                    if (array[i] < array[j]) {
                        let temp = array[i];
                        array[i] = array[j];
                        array[j] = temp;
                    };
                };
            };
            return array;
        }
    }
}


var alternativeMatrix
self.onmessage = async (evt) => {
    evt = evt.data
    if (evt.event == "start") {
        alternativeMatrix = new AlternativeMatrix(self, evt.data)
        await alternativeMatrix.get_alternative_data()
    }
    else if (evt.event == "get_data") {
        alternativeMatrix.get_data(evt)
    }
};
