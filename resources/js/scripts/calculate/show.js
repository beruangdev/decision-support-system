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
                const data = response.data.data
                const event = response.data.event
                if (event == "decision_matrix") this.decision_matrix(data);
                else if (event == "decision_matrix_progress") this.decision_matrix_progress = data;
                else if (event == "average_solution") this.average_solution(data);
                else if (event == "positive_negative_distance") this.positive_negative_distance(data);
                else if (event == "sum_weight") this.sum_weight(data);
                else if (event == "normalization") this.normalization(data);
                else if (event == "score_rating") this.score_rating(data);
            };
        },
        decision_matrix({ alternatives, criterias }) {
            this.criterias = criterias
            this.alternatives = alternatives
            let selector = "#table-decision_matrix"
            this.dom_table(selector, alternatives)
        },
        average_solution(data) {
            let selector = "#table-average_solution"
            this.dom_table(selector, data, this.datatable_default_config)
        },
        positive_negative_distance(data) {
            let selector = "#table-positive_negative_distance"
            this.dom_table(selector, data)
        },
        sum_weight(data) {
            let selector = "#table-sum_weight"
            this.dom_table(selector, data)
        },
        normalization(data) {
            let selector = "#table-normalization"
            this.dom_table(selector, data)
        },
        score_rating(data) {
            let selector = "#table-score_rating"

            let table = this.dom_table(selector, data)
            window.table = table

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


        dom_table(selector, data, options = {}) {
            return $(selector).DataTable({
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
