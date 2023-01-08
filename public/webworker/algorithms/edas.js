'use strict';
class Edas {
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

        this.averages = []
        this.score_rating = []
        this.pda = [] // Horizontal
        this.nda = [] // Horizontal
        this.positive_negative_distance = [] // Horizontal
        this.sp = [] // Horizontal
        this.sn = [] // Horizontal
        this.spi = [] // Vertical
        this.sni = [] // Vertical
        this.sum_weight = [] // Horizontal
        this.nspi = [] // Vertical
        this.nsni = [] // Vertical
        this.normalization = []
        this.as = [] // Horizontal
        this.data = [] // Horizontal
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
        // this.self.postMessage({
        //     event: "metadata",
        //     data: records
        // })
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
        // console.log("this.alternative_progress.percent", this.alternative_progress.percent);
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
        const start = performance.now()
        const fn_name = "decision_matrix"
        for (let index = 0; index < this.alternatives.length; index++) {
            const alt = this.alternatives[index];
            let alt_name = `[${alt.uuid}] ${alt.name}`
            let newalt = [index + 1, alt_name]
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

        this.self.postMessage({
            name: fn_name,
            event: `set_data`,
            data: this.display(this.chunk(this[fn_name], 10)[0] ?? []),
            recordsDisplay: this[fn_name].length,
            page: 1,
        })
        console.log("Decision_matrix", `${performance.now() - start} ms`)
        this.Average_solution()
    }
    Average_solution() {
        const fn_name = "average_solution"
        const start = performance.now()
        let average_solution = [
            ["AVJ"],
            ["Total"]
        ]
        for (let index = 0; index < this.alternative_array_rotate.length; index++) {
            let sum = this.alternative_array_rotate[index];
            sum = sum.reduce((a, b) => a + b, 0)
            average_solution[1].push(sum)
        }
        const length = this.alternative_array.length
        for (let index = 0; index < this.alternative_array_rotate.length; index++) {
            let avj = average_solution[1][index + 1] / length
            average_solution[0].push(avj)
            this.averages.push(avj)
        }
        console.log("Average_solution", `${performance.now() - start} ms`)
        this.Positive_negative_distance()
    }
    Positive_negative_distance() {
        const fn_name = "positive_negative_distance"
        const start = performance.now()
        function calculate(cal_type, _this, data, index) {
            let result
            if ((cal_type == "pda" && _this.criterias[index].type == "cost") || (cal_type == "nda" && _this.criterias[index].type == "benefit")) {
                result = Math.max((_this.averages[index] - data), 0) / _this.averages[index]
            } else {
                result = Math.max((data - _this.averages[index]), 0) / _this.averages[index]
            }
            return result
        }

        for (let index1 = 0; index1 < this.alternative_array.length; index1++) {
            const alternative = this.alternative_array[index1];
            this.pda.push([])
            this.nda.push([])
            this.positive_negative_distance.push([])
            for (let index2 = 0; index2 < alternative.length; index2++) {
                const data = alternative[index2];
                this.pda[index1].push(calculate("pda", this, data, index2))
                this.nda[index1].push(calculate("nda", this, data, index2))
            }
            let name = `[${this.alternatives[index1].uuid}] ${this.alternatives[index1].name}`
            this.positive_negative_distance[index1].push(name, ...this.pda[index1], ...this.nda[index1])
        }

        this.self.postMessage({
            name: fn_name,
            event: `set_data`,
            data: this.display(this.chunk(this[fn_name], 10)[0] ?? []),
            recordsDisplay: this[fn_name].length,
            page: 1,
        })
        console.log("Positive_negative_distance", `${performance.now() - start} ms`)
        this.Sum_weight()
    }
    Sum_weight() {
        const fn_name = "sum_weight"
        const start = performance.now()
        console.log("this.criterias", this.criterias);
        for (let index1 = 0; index1 < this.pda.length; index1++) {
            this.sp.push([])
            this.sn.push([])
            for (let index2 = 0; index2 < this.pda[index1].length; index2++) {
                let pda_element = this.pda[index1][index2];
                let nda_element = this.nda[index1][index2];
                this.sp[index1].push(parseFloat(this.criterias[index2].weight) * parseFloat(pda_element))
                this.sn[index1].push(parseFloat(this.criterias[index2].weight) * parseFloat(nda_element))
            }
            let spi = this.sp[index1].reduce((a, b) => a + b, 0)
            let sni = this.sn[index1].reduce((a, b) => a + b, 0)
            this.spi.push(spi)
            this.sni.push(sni)
            let name = `[${this.alternatives[index1].uuid}] ${this.alternatives[index1].name}`
            this.sum_weight.push([name, ...this.sp[index1], spi, ...this.sn[index1], sni])
        }

        this.self.postMessage({
            name: fn_name,
            event: `set_data`,
            data: this.display(this.chunk(this[fn_name], 10)[0] ?? []),
            recordsDisplay: this[fn_name].length,
            page: 1,
        })
        console.log("Sum_weight", `${performance.now() - start} ms`)
        this.Normalization()
    }
    Normalization() {
        const fn_name = "normalization"
        const start = performance.now()
        let spi_max = Math.max(...this.spi)
        let sni_max = Math.max(...this.sni)
        for (let index = 0; index < this.spi.length; index++) {
            const spi_element = this.spi[index];
            const sni_element = this.sni[index];
            let nspi = spi_element / spi_max
            let nsni = 1 - (sni_element / sni_max)
            this.nspi.push(nspi)
            this.nsni.push(nsni)
            let name = `[${this.alternatives[index].uuid}] ${this.alternatives[index].name}`
            this.normalization.push([name, nspi, nsni])
        }
        this.self.postMessage({
            name: fn_name,
            event: `set_data`,
            data: this.display(this.chunk(this[fn_name], 10)[0] ?? []),
            recordsDisplay: this[fn_name].length,
            page: 1,
        })
        console.log("Normalization", `${performance.now() - start} ms`)
        this.Score_rating()
    }
    Score_rating() {
        const fn_name = "score_rating"
        const start = performance.now()
        let scores = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9]

        for (let index1 = 0; index1 < this.nspi.length; index1++) {
            const nspi_el = this.nspi[index1];
            const nsni_el = this.nsni[index1];
            this.score_rating.push([])
            for (let index2 = 0; index2 < scores.length; index2++) {
                const score = scores[index2];
                this.score_rating[index1].push(score * (nspi_el + nsni_el), "-")
            }

            let name = `[${this.alternatives[index1].uuid}] ${this.alternatives[index1].name}`
            this.score_rating[index1].unshift(index1 + 1, name)
        }

        function my_sort(b, a, index) {
            return a[index] == b[index] ? 0 : (b[index] < a[index] ? -1 : 1)
        }

        // Buat perangkingan
        for (let index1 = 2; index1 < this.score_rating[0].length; index1 = index1 + 2) {
            this.score_rating.sort((a, b) => {
                return my_sort(a, b, index1)
            })
            for (let index2 = 0; index2 < this.score_rating.length; index2++) {
                this.score_rating[index2][index1 + 1] = index2 + 1
            }
        }
        this.score_rating.sort((a, b) => my_sort(a, b, 0))

        // this.self.postMessage({
        //     event: "score_rating",
        //     data: this.display(this.chunk(this.score_rating, 10)[0] ?? []),
        //     recordsTotal: this.score_rating.length
        // })

        this.self.postMessage({
            name: fn_name,
            event: `set_data`,
            data: this.display(this.chunk(this[fn_name], 10)[0] ?? []),
            recordsDisplay: this[fn_name].length,
            page: 1,
        })

        console.log("Score_rating", `${performance.now() - start} ms`)
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


var edas
self.onmessage = async (evt) => {
    // let message = e.data;
    evt = evt.data
    // const event = e.data.event
    // console.log(evt);
    if (evt.event == "start") {
        edas = new Edas(self, evt.data)
        await edas.get_alternative_data()
    }
    else if (evt.event == "get_data") {
        edas.get_data(evt)
    }

    // self.postMessage(data);
};
