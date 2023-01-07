window.showCalculate = showCalculate
function showCalculate(element) {
    return {
        weights: [
            {
                "label": 1,
                "value": 1
            },
            {
                "label": 2,
                "value": 2
            },
            {
                "label": 3,
                "value": 3
            },
            {
                "label": 4,
                "value": 4
            },
            {
                "label": 5,
                "value": 5
            },
            {
                "label": 6,
                "value": 6
            },
            {
                "label": 7,
                "value": 7
            },
            {
                "label": 8,
                "value": 8
            },
            {
                "label": 9,
                "value": 9
            },
            {
                "label": "1/2",
                "value": 0.5
            },
            {
                "label": "1/3",
                "value": 0.3333333333333333
            },
            {
                "label": "1/4",
                "value": 0.25
            },
            {
                "label": "1/5",
                "value": 0.2
            },
            {
                "label": "1/6",
                "value": 0.16666666666666666
            },
            {
                "label": "1/7",
                "value": 0.14285714285714285
            },
            {
                "label": "1/8",
                "value": 0.125
            },
            {
                "label": "1/9",
                "value": 0.1111111111111111
            }
        ],
        element,
        calculate: {
            algorithm: {},
            project_method: {
                criteria_rasio_json: "",
                criterias: []
            }
        },
        decision_matrix_progress: 0,
        criterias: [],
        alternatives: [],
        alternative_count: 0,
        datatable_default_config: {
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            stateSave: true,
            bDestroy: true,
            destroy: true,
            retrieve: true,
            processing: true,
        },
        recordsDisplay: 0,
        total_page: 0,
        worker: null,
        async init() {
            this.calculate = JSON.parse(element.getAttribute("data-calculate"))
            this.calculate.project_method.criteria_rasio_json = JSON.parse(this.calculate.project_method.criteria_rasio_json)

            if (this.calculate.algorithm.slug == "evaluation-based-on-distance-from-average-solution-edas") {
                this.init_edas()
            }
        },
        init_edas() {
            let worker_url = `${ASEET_PATH}/webworker/algorithms/edas.js`
            // TODO: Pisahkan worker untuk fetch data alternative
            this.worker = new Worker(worker_url);
            this.worker.postMessage({
                event: "start",
                data: {
                    url: element.getAttribute("url-alternative-list"),
                    csrf: csrf
                }
            });
            this.worker.onmessage = (response) => {
                const data = response.data
                const event = response.data.event
                if (event == "metadata") this.metadata(data);
                else if (event == "decision_matrix") this.decision_matrix(data);
                else if (event == "decision_matrix_progress") this.decision_matrix_progress = data;
                else if (event == "average_solution") this.average_solution(data);
                else if (event == "positive_negative_distance") this.positive_negative_distance(data);
                else if (event == "sum_weight") this.sum_weight(data);
                else if (event == "normalization") this.normalization(data);
                else if (event == "score_rating") this.score_rating(data);
                // else if (event == "update_score_rating") this.update_score_rating(data);
                else if (event == "update_data") this.update_data(data);
            };
        },
        metadata({ alternative_count, calculate, criterias }) {
            this.alternative_count = alternative_count
        },
        decision_matrix({ alternatives, criterias }) {
            this.criterias = criterias
            this.alternatives = alternatives
            let selector = "decision_matrix"
            const options = {}
            let table = this.dom_table(selector, alternatives, options)
        },
        average_solution(data) {
            let selector = "average_solution"
            this.dom_table(selector, data, this.datatable_default_config)
        },
        positive_negative_distance(data) {
            let selector = "positive_negative_distance"
            this.dom_table(selector, data)
        },
        sum_weight(data) {
            let selector = "sum_weight"
            this.dom_table(selector, data)
        },
        normalization(data) {
            let selector = "normalization"
            this.dom_table(selector, data)
        },
        score_rating({ data, recordsTotal }) {
            let selector = "score_rating"
            const options = {
                // paging: false,
                info: false,
                // lengthMenu: [10, 25, 50, 75, 100],
                // dom: `Blfrtip`,
                // buttons: {
                //     dom: {
                //         container: {
                //             className: 'dt-export-buttons'
                //         }
                //     },
                //     buttons: ['excel', 'pdf', 'print']
                // }
            }
            let table = this.dom_table(selector, data, options)

            this.recordsDisplay = recordsTotal
            this.draw_pagination(selector, table, 1)
            this.listen_pagination(selector, table)

            // Select which score rating want to show
            let value = element.querySelector(`[name="score-rating"]`).value
            value = ((parseInt(value) + 1) * 2)
            table.column(value).visible(true);
            table.column(value + 1).visible(true);

            on(`[name="score-rating"]`, "change", (e, _this) => {
                let value = ((parseInt(_this.value) + 1) * 2) + 1
                for (let index = 2; index < (table.columns()[0].length - 1); index++) {
                    if (value == index || value == index + 1) {
                        table.column(index).visible(true);
                        table.column(index + 1).visible(true);
                    } else {
                        table.column(index).visible(false);
                        table.column(index + 1).visible(false);
                    }
                }
            })

        },
        draw_pagination(name, table, page) {
            let target_selector = `[table-target="#table-${name}"]`
            let html = ``

            let total_page = Math.max(1, parseInt(this.recordsDisplay / table.page.info().length))
            if ((this.recordsDisplay / table.page.info().length) > total_page) total_page++
            this.total_page = total_page

            for (let index = 1; index <= total_page; index++) {
                let selected = page == index ? "selected" : ""
                html += `<option value="${index}" ${selected}>${index}</option>`
            }

            $(`${target_selector} .dtc-pagination`).html(html)
            this.updateDisabled(name, page)
        },
        listen_pagination(name, table) {
            let target_selector = `[table-target="#table-${name}"]`
            let elps = `${target_selector} select.dtc-pagination`
            on(elps, "change", (e, _this) => {
                let page = parseInt(_this.value)
                this.updateDisabled(name, page)
                this.worker.postMessage({
                    event: `get_data`,
                    name,
                    length: table.page.info().length,
                    page,
                    order: table.order()[0],
                    search: table.search(),
                })
                table.off("search.dt")
                table.off("order.dt")
            })

            let elpb = `${target_selector} [pagination-target="back"], ${target_selector} [pagination-target="next"]`
            on(elpb, "click", (e, _this) => {
                if (_this.classList.contains("disabled")) return false
                let page = parseInt($(elps).val())
                if (_this.getAttribute("pagination-target") == "next") {
                    if (page + 1 <= this.total_page) page++
                } else {
                    if (page - 1 >= 1) page--
                }
                this.updateDisabled(name, page)
                this.worker.postMessage({
                    event: `get_data`,
                    name,
                    length: table.page.info().length,
                    page,
                    order: table.order()[0],
                    search: table.search(),
                })
                table.off("search.dt")
                table.off("order.dt")
            })

            this.listen({ name })
        },
        updateDisabled(name, page) {
            let target_selector = `[table-target="#table-${name}"]`
            const elpb_back = `${target_selector} [pagination-target="back"]`
            const elpb_next = `${target_selector} [pagination-target="next"]`

            $(elpb_next).removeClass("disabled")
            $(elpb_back).removeClass("disabled", true)

            if (page == 1) $(elpb_back).addClass("disabled", true)
            else if (page == this.total_page) $(elpb_next).addClass("disabled")
        },

        update_data({ event, name, data, recordsDisplay, page }) {
            this.recordsDisplay = recordsDisplay
            let table = $(`#table-${name}`).DataTable()
            // table.clear().draw();
            table.clear();
            table.rows.add(data);
            table.columns.adjust().draw();
            this.draw_pagination(name, table, page)

            this.listen({ name })
        },

        listen({ name }) {
            let target_selector = `[table-target="#table-${name}"]`
            let elps = `${target_selector} select.dtc-pagination`
            let table = $(`#table-${name}`).DataTable()
            table.off("search.dt")
            table.off("order.dt")
            table.off("length.dt")

            table.one("search.dt", (evt) => {
                this.worker.postMessage({
                    event: `get_data`,
                    name,
                    length: table.page.info().length,
                    page: parseInt($(elps).val()),
                    order: table.order()[0],
                    search: table.search()
                })

                table.off("order.dt")
            })

            table.one("order.dt", (evt) => {
                this.worker.postMessage({
                    event: `get_data`,
                    name,
                    length: table.page.info().length,
                    page: parseInt($(elps).val()),
                    order: table.order()[0],
                    search: table.search()
                })
                table.off("search.dt")
            })

            table.one("length.dt", (evt, settings, new_length) => {
                this.worker.postMessage({
                    event: `get_data`,
                    name,
                    length: new_length,
                    page: parseInt($(elps).val()),
                    order: table.order()[0],
                    search: table.search()
                })

                table.off("search.dt")
                table.off("order.dt")
            })
        },


        dom_table(selector, data, options = {}) {
            selector = `#table-${selector}`
            return $(selector).DataTable({
                ...window.dt_options,
                ...options,
                data,
            });
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
        getCircularArray(arr, diff, current = 0) {
            let newIndex = (current + diff) % arr.length;
            if (newIndex < 0) newIndex = arr.length + newIndex;
            return arr[newIndex];
        },
    }
}
