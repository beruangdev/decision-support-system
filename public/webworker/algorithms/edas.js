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

        this.calculate = {}
        this.project_method = {}
        this.criterias = []

        this.averages = []
        this.score_rating = []
        this.pda = [] // Horizontal
        this.nda = [] // Horizontal
        this.sp = [] // Horizontal
        this.sn = [] // Horizontal
        this.spi = [] // Vertical
        this.sni = [] // Vertical
        this.nspi = [] // Vertical
        this.nsni = [] // Vertical
        this.as = [] // Horizontal
        this.data = [] // Horizontal
    }

    async get_alternative_data() {
        console.time("Get all ALTERNATIVES")
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
            this.fetch_alternative({ page, request })
            if (page == (parseInt(records.alternative_count / this.paginate) + 1)) break
            // if (page == parseInt(records.alternative_count / this.paginate)) break
        }
    }
    async fetch_alternative({ page, request }) {
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
        this.alternatives_finish_item(page - 1)
    }
    alternatives_finish_item(index) {
        this.alternative_progress.queues[index] = true
        let queues = this.alternative_progress.queues
        this.alternative_progress.percent = queues.filter(q => q == true).length / queues.length * 100
        this.self.postMessage({
            event: "decision_matrix_progress",
            data: this.alternative_progress.percent
        })
        if (queues.length > 0 && queues.every(data => data == true)) {
            this.alternatives_finish_fetch_all()
        }
    }
    alternatives_finish_fetch_all() {
        console.timeEnd("Get all ALTERNATIVES")
        this.alternatives = this.alternatives.flat()
        this.Decision_matrix()
    }
    Decision_matrix() {
        console.time("Decision_matrix");
        let dt_alternatives = []
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
            dt_alternatives.push(newalt)
        }
        this.alternative_array = this.rotate_array(this.alternative_array_rotate)
        // this.self.postMessage({
        //     event: "decision_matrix",
        //     data: {
        //         alternatives: this.display(this.chunk(dt_alternatives)[0] ?? []),
        //         criterias: this.criterias,
        //     }
        // })
        console.timeEnd("Decision_matrix");
        this.Average_solution()
    }
    Average_solution() {
        console.time("Average_solution");
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

        // this.self.postMessage({
        //     event: "average_solution",
        //     data: this.display(this.chunk(average_solution)[0] ?? [])
        // })
        console.timeEnd("Average_solution");
        this.Positive_negative_distance()
    }
    Positive_negative_distance() {
        console.time("Positive_negative_distance");
        let pda_nda = []

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
            pda_nda.push([])
            for (let index2 = 0; index2 < alternative.length; index2++) {
                const data = alternative[index2];
                this.pda[index1].push(calculate("pda", this, data, index2))
                this.nda[index1].push(calculate("nda", this, data, index2))
            }
            let name = `[${this.alternatives[index1].uuid}] ${this.alternatives[index1].name}`
            pda_nda[index1].push(name, ...this.pda[index1], ...this.nda[index1])
        }
        // this.self.postMessage({
        //     event: "positive_negative_distance",
        //     data: this.display(this.chunk(pda_nda)[0] ?? []),
        // })
        console.timeEnd("Positive_negative_distance");
        this.Sum_weight()
    }
    Sum_weight() {
        console.time("sum_weight");
        let sum_weight = []

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
            sum_weight.push([name, ...this.sp[index1], spi, ...this.sn[index1], sni])
        }
        // this.self.postMessage({
        //     event: "sum_weight",
        //     data: this.display(this.chunk(sum_weight)[0] ?? [])
        // })
        console.timeEnd("sum_weight");
        this.Normalization()
    }
    Normalization() {
        console.time("normalization");
        let spi_max = Math.max(...this.spi)
        let sni_max = Math.max(...this.sni)
        let normalization = []
        for (let index = 0; index < this.spi.length; index++) {
            const spi_element = this.spi[index];
            const sni_element = this.sni[index];
            let nspi = spi_element / spi_max
            let nsni = 1 - (sni_element / sni_max)
            this.nspi.push(nspi)
            this.nsni.push(nsni)
            let name = `[${this.alternatives[index].uuid}] ${this.alternatives[index].name}`
            normalization.push([name, nspi, nsni])
        }
        // this.self.postMessage({
        //     event: "normalization",
        //     data: this.display(this.chunk(normalization)[0] ?? [])
        // })
        console.timeEnd("normalization");
        this.Score_rating()
    }
    Score_rating() {
        console.time("score_rating");
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

        this.self.postMessage({
            event: "score_rating",
            data: this.display(this.chunk(this.score_rating, 10)[0] ?? []),
            recordsTotal: this.score_rating.length
        })

        console.timeEnd("score_rating");
    }

    get_data({ name, length, page, order, search }) {
        console.time("GET DATA")
        let datas = [...this[name]]

        if (search && search != "") {
            let searched = []
            for (let index = 0; index < datas.length; index++) {
                let row = datas[index];
                if (Array.isArray(row)) row = row.join(" ").toLocaleLowerCase()
                if (row.includes(search.toLocaleLowerCase())) {
                    searched.push(row)
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
        console.timeEnd("GET DATA")
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
