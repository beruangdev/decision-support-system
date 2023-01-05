window.alphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
window.editProjectMethod = function (element) {
    return {
        element,
        detail_keys: [],
        old_value: [],
        body: {
            name: "",
            description: "",
            method_id: "",
            criterias: [],
            criteria_rasios: [],
        },
        inputs: {},
        criterias: [],
        criteria_values: {},
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
        // input_selector: `.container-input-project-method input, .container-input-project-method textarea, .container-input-project-method select`,
        input_selector: `.container-input-project-method input[type="text"], .container-input-project-method textarea, .container-input-project-method select, .container-input-project-method input[type="checkbox"]`,
        resetCriteriaRasio() {
            let check_criteria = ['jumlah-anggota-keluarga', 'luas-lantai', 'rata-rata-listrik', 'rata-rata-pemasukan', 'rata-rata-pengeluaran']

            this.body.criterias.forEach(c => {
                if (check_criteria.includes(c.slug)) c.checked = true
                else c.checked = false
            })
            let old_values = [
                [1, 1, 1, 3, 9],
                [1, 1, 1, 3, 7],
                [1, 1, 1, 5, 7],
                [0.3333333333333333, 0.3333333333333333, 0.2, 1, 3],
                [0.1111111111111111, 0.14285714285714285, 0.14285714285714285, 0.3333333333333333, 1]
            ]

            if (this.body.criterias.filter(c => c.checked).length != check_criteria.length) {
                alert("Gak bisa reset ada criteria yang kurang")
                return false
            }

            // update criteria rasio checked
            this.updateCriteriaRasioChecked()

            // update criteria rasio value
            let values = []
            old_values.forEach((value, index1) => {
                value.forEach((val, index2) => {
                    if (index2 > index1) {
                        // log(index1, index2, val)
                        values.push(val)
                    }
                });
            });
            this.body.criteria_rasios.filter(r => r.checked).forEach((rasio, index) => {
                let index_weight = this.weights.findIndex(w => w.value == values[index])
                rasio.value = index_weight
            })
            // recalculate method
            this.calculateMethod()
        },
        updateCriteriaRasioChecked() {
            this.body.criteria_rasios.forEach((cr, index) => {
                let is_checked = this.body.criterias.filter(c => cr.slugs.includes(c.slug))
                is_checked = is_checked.every((c) => c.checked == true)
                cr.checked = is_checked
            });
        },
        async init() {
            console.log("INITIALIZE: editProjectMethod()");

            this.old_value = JSON.parse(element.getAttribute("data-old_value"))
            this.old_value = this.old_value;

            // await new Promise((r) => setTimeout(r, 100))
            window.onload = () => {
                this.init_body_values()
                this.calculateMethod()
                // element.querySelector(".reset-criteria-rasio").click()
            }
        },
        init_body_values() {
            this.body.name = this.old_value.name
            this.body.description = this.old_value.description
            this.body.method_id = this.old_value.method_id

            // Init Criterias
            this.body.criterias = this.old_value.criterias.map(({ name, slug, type, checked }, index) => {
                return {
                    name, slug, type, checked: checked == 0 ? false : true
                }
            })
            const old_detail_keys = JSON.parse(element.getAttribute("data-detail_keys"))
            old_detail_keys.forEach(({ name, slug }, index) => {
                let has_criteria = this.body.criterias.filter(criteria => criteria.slug == slug).length
                has_criteria = has_criteria > 0 ? true : false
                if (!has_criteria) {
                    this.body.criterias.push({
                        name,
                        slug,
                        checked: false,
                        type: "cost"
                    })
                }
            })

            this.body.criterias = this.body.criterias.sort((a, b) => a.slug.localeCompare(b.slug))

            let initial_index = 0
            this.body.criterias = this.body.criterias.map((criteria) => {
                let initial = ""
                if (criteria.checked) {
                    initial = alphabet[initial_index]
                    initial_index++
                }
                return {
                    ...criteria, initial
                }
            })

            // draw criteria initial
            let criteria_initial_html = ""
            this.body.criterias.filter(c => c.checked).forEach(c => {
                criteria_initial_html += `<li class="text-sm">${c.initial} &nbsp; = &nbsp; ${c.name}</li>`
            })
            document.querySelector(".criteria-initial").innerHTML = criteria_initial_html

            // Init Criteria Rasios
            // this.body.criteria_rasios
            let criteria_rasio_json = JSON.parse(this.old_value.criteria_rasio_json)
            this.body.criterias.forEach((criteria1, index1) => {
                this.body.criterias.forEach((criteria2, index2) => {
                    if (index1 < index2) {
                        let cr = {
                            names: [criteria1.name, criteria2.name],
                            slugs: [criteria1.slug, criteria2.slug],
                            value: 0,
                            checked: criteria1.checked && criteria2.checked,
                        }
                        let value = criteria_rasio_json.filter(({ slugs }) => slugs[0] == cr.slugs[0] && slugs[1] == cr.slugs[1])[0]

                        if (value) {
                            cr.value = this.weights.findIndex((val, index) => {
                                return val.value == value.rasio
                            })
                        }
                        this.body.criteria_rasios.push(cr)
                    }
                })
            })
        },
        submit() {
            // this.pull_input_values()
            // if (!this.validate()) return false
            let body = this.get(this.body)
            // body.criterias = body.criterias.filter(c => c.checked)
            body.criteria_rasios = body.criteria_rasios.filter(c => c.checked)
            body.criteria_rasios = body.criteria_rasios.map(cr => {
                return {
                    ...cr,
                    rasio: this.weights[cr.value].value
                }
            })
            // element.submit()
            this.ajax(body)
            // location.reload()
            // this.resetForm()
        },
        get(obj) {
            return JSON.parse(JSON.stringify(obj))
        },
        url() {
            return element.getAttribute("action")
        },
        validate() {
            let is_validate = true
            Object.keys(this.inputs).forEach(key => {
                let length = this.inputs[key].value.length
                if (key == "criterias") length = this.inputs[key].value.filter(v => v.checked).length

                if (length < this.inputs[key].min_length) {
                    is_validate = false
                    this.inputs[key].error = true
                    this.inputs[key].message = `The ${key} is required`
                }
            })

            let error_header = "Ups, some input error"
            const elce = this.element.querySelector(".container-error")
            if (!is_validate) {
                elce.querySelector(".error-header").innerText = error_header
                let li = ""
                Object.keys(this.inputs).forEach(key => {
                    if (this.inputs[key].error) {
                        li += `<li>${this.inputs[key].message}</li>`
                    }
                })
                elce.querySelector("ul").innerHTML = li
            } else {
                elce.querySelector(".error-header").innerHTML = `&nbsp;`
                elce.querySelector("ul").innerHTML = ""
            }

            return is_validate
        },
        ajax(body) {
            fetch(this.url(), {
                method: 'PUT',
                body: JSON.stringify(body),
                headers: {
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'Content-Type': 'application/json',
                    'url': this.url(),
                    "X-CSRF-Token": csrf
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
                log("response", data);
            }).catch((err) => {
                // There was an error
                console.warn('Something went wrong.', err);
            });

        },
        resetForm() {
            this.body = {}
            this.inputs = {}
            this.criterias = []
            this.criteria_values = {}

            element.querySelectorAll(`.container-criterias input[type="checkbox"][name="criterias"]`).forEach(input => input.checked = false)
        },
        onCriteriaUpdate(index, criteria1) {
            let initial_index = 0
            // update criteria initial
            this.body.criterias = this.body.criterias.map((criteria) => {
                let initial = ""
                if (criteria.checked) {
                    initial = alphabet[initial_index]
                    initial_index++
                }
                return {
                    ...criteria, initial
                }
            })

            this.body.criteria_rasios.forEach((cr, index) => {
                if (cr.slugs.includes(criteria1.slug)) {
                    let criteria2_slug = cr.slugs[cr.slugs.indexOf(criteria1.slug) == 0 ? 1 : 0]
                    let criteria2 = this.body.criterias.filter(criteria => {
                        return criteria.slug == criteria2_slug
                    })[0]
                    this.body.criteria_rasios[index].checked = criteria1.checked && criteria2.checked
                }
            });

            this.calculateMethod()
        },
        getRasioWeightLabel(index, criteria) {
            let result = ""
            if (index == 0) {
                result = this.weights[criteria.value].label
            } else {
                if (criteria.value == 0) {
                    result = 1
                } else {
                    let seek = 8
                    if (parseInt(criteria.value) > 8) seek = 9
                    result = this.getCircularArray(this.weights, parseInt(criteria.value) + seek).label
                }
            }
            return result
        },
        getCircularArray(arr, diff, current = 0) {
            let newIndex = (current + diff) % arr.length;
            if (newIndex < 0) newIndex = arr.length + newIndex;
            return arr[newIndex];
        },
        onChangeRasio() {
            this.calculateMethod()
        },
        calculateMethod() {
            console.log("calculateMethod");
            let table_values = []
            let rasios = this.get(this.body.criteria_rasios.filter(r => r.checked))
            let criterias = this.get(this.body.criterias.filter(r => r.checked))

            criterias.forEach((criteria1, index1) => {
                table_values[index1] = []
                criterias.forEach((criteria2, index2) => {
                    if (criteria1.slug == criteria2.slug) {
                        table_values[index1].push(1)
                    } else {
                        let rasio = rasios.filter(r => r.slugs[0] == criteria1.slug && r.slugs[1] == criteria2.slug)
                        if (rasio.length > 0) {
                            let value = this.getCircularArray(this.weights, parseInt(rasio[0].value)).value
                            table_values[index1].push(value)
                        } else {
                            let rasio = rasios.filter(r => r.slugs[0] == criteria2.slug && r.slugs[1] == criteria1.slug)
                            let seek = Math.floor(this.weights.length / 2)
                            if (parseInt(rasio[0].value) > Math.floor(this.weights.length / 2)) {
                                seek = Math.floor(this.weights.length / 2) + 1
                            }
                            let value = this.getCircularArray(this.weights, parseInt(rasio[0].value) + seek).value
                            if (parseInt(rasio[0].value) == 0) value = 1
                            table_values[index1].push(value)
                        }
                    }
                })
            })

            // draw criteria initial
            let criteria_initial_html = ""
            criterias.forEach(c => {
                criteria_initial_html += `<li>${c.initial} = ${c.name}</li>`
            })
            document.querySelector(".criteria-initial").innerHTML = criteria_initial_html

            // draw table_values
            let ahp_result = ahp({
                values: table_values
            })
            ahp_result.init()

            function isFloat(n) {
                return Number(n) === n && n % 1 !== 0;
            }

            function cleanFloatAndInt(values) {
                function parse(value) {
                    if (isFloat(value)) {
                        let limit_decimal = 3
                        let decimal_length = value.toString().split(".")[1].length
                        if (decimal_length <= limit_decimal) {
                            return value
                        }
                        return value.toFixed(limit_decimal)
                    }
                    return value
                }

                return values.map(value => {
                    if (Array.isArray(value)) {
                        return value.map(value => {
                            return parse(value)
                        })
                    }

                    return parse(value)
                })
            }

            function injectCriteriaHeaders(arrays, body_criterias) {
                if (Array.isArray(arrays[0])) {
                    arrays.forEach((array, index) => {
                        arrays[index] = [body_criterias[index].initial, ...array]
                    })
                } else {

                }
                return arrays
            }

            let datatable_default_config = {
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                stateSave: true,
                bDestroy: true,
                destroy: true,
                retrieve: true,
                processing: true,
            }

            // table-comparison-matrix
            let selector = ""
            let data = ""
            let columns = ""

            selector = "#table-comparison-matrix"
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().clear().destroy();
                $(selector).html("")
            }
            columns = [{ title: "Criteria" }, ...criterias.map(c => {
                return {
                    title: c.initial
                }
            })]

            data = [...injectCriteriaHeaders(cleanFloatAndInt(table_values), criterias), ...[["", ...cleanFloatAndInt(ahp_result.eigen_vektor_normalisasi.results)]]]

            $(selector).DataTable({
                ...datatable_default_config,
                data,
                columns,
                initComplete: function () {
                    this.api().tables().header().to$().addClass('bg-gray-200 text-sm dark:bg-gray-900')

                    this.api().columns(':first').nodes().flatten().to$().addClass('bg-gray-200 dark:bg-gray-900')

                    $(this.api().row(':last').node()).addClass("!bg-gray-200 dark:!bg-gray-900")
                },
            });


            // table-weight
            selector = "#table-weight"
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().clear().destroy();
                $(selector).html("")
            }
            columns = [{ title: "Criteria" }, ...criterias.map(c => {
                return {
                    title: c.initial
                }
            }), { title: "Weight" }]

            data = ahp_result.normalisasi.values

            ahp_result.normalisasi.weight.forEach((weight, index) => {
                data[index].unshift(criterias[index].initial)
                data[index].push(weight)
            })
            this.updateCriteriaWeight(ahp_result.normalisasi.weight)
            data = cleanFloatAndInt(data)

            $(selector).DataTable({
                ...datatable_default_config,
                data,
                columns,
                initComplete: function () {
                    this.api().tables().header().to$().addClass('bg-gray-200 text-sm dark:bg-gray-900')

                    this.api().columns(':first, :last').nodes().flatten().to$().addClass('bg-gray-200 dark:bg-gray-900')

                    $(this.api().row(':last').node()).addClass("!bg-gray-200 dark:!bg-gray-900")
                },
            });

            // table-lambda
            selector = "#table-lambda"
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().clear().destroy();
                $(selector).html("")
            }
            columns = [{ title: "Criteria" }, ...criterias.map(c => {
                return {
                    title: c.initial
                }
            }), { title: "Lambda Maxs" }]

            data = ahp_result.values_normal_weight.values

            ahp_result.values_normal_weight.totals.forEach((weight, index) => {
                data[index].unshift(criterias[index].initial)
                data[index].push(weight)
            })

            data = cleanFloatAndInt(data)

            $(selector).DataTable({
                ...datatable_default_config,
                data,
                columns,
                initComplete: function () {
                    this.api().tables().header().to$().addClass('bg-gray-200 text-sm dark:bg-gray-900')

                    this.api().columns(':first, :last').nodes().flatten().to$().addClass('bg-gray-200 dark:bg-gray-900')

                    $(this.api().row(':last').node()).addClass("!bg-gray-200 dark:!bg-gray-900")
                },
            });

            // table-check-consistency
            selector = "#table-check-consistency"
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().clear().destroy();
                $(selector).html("")
            }
            columns = [{ title: "Lambda Maxs" }, { title: "CI" }, { title: "CR" }]

            // data = ahp_result.values_normal_weight.values
            data = [
                cleanFloatAndInt([ahp_result.lambda, ahp_result.ci, ahp_result.cr])
            ]

            $(selector).DataTable({
                ...datatable_default_config,
                data,
                columns,
                initComplete: function () {
                    this.api().tables().header().to$().addClass('bg-gray-200 text-sm dark:bg-gray-900')

                    // this.api().columns(':first, :last').nodes().flatten().to$().addClass('bg-gray-200 dark:bg-gray-900')

                    // $(this.api().row(':last').node()).addClass("!bg-gray-200 dark:!bg-gray-900")
                },
            });


            console.log("ahp_result", ahp_result);
        },
        async updateCriteriaWeight(weights) {
            let request = []
            this.body.criterias.filter(c => c.checked).forEach((criteria, index) => {
                request.push({
                    name: criteria.name,
                    slug: criteria.slug,
                    type: criteria.type,
                    checked: criteria.checked,
                    weight: weights[index],
                })
            })
            fetch(element.getAttribute("action-update_weight"), {
                method: 'PUT',
                body: JSON.stringify(request),
                headers: {
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'Content-Type': 'application/json',
                    'url': element.getAttribute("action-update_weight"),
                    "X-CSRF-Token": csrf
                },
            }).then(async (response) => {
                if (response.ok) {
                    console.log("UPDATE WEIGHT");
                    response = await response.json()
                } else {
                    console.log("UPDATE WEIGHT ERROR");
                    response = await response.text()
                }
                console.log("response:", response);
                return response
            }).then(({ data, status }) => {
                // This is the JSON from our response
                // console.log("response", data);
            }).catch((err) => {
                // There was an error
                console.warn('Something went wrong.', err);
            });
        }
    }
}
