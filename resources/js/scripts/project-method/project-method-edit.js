window.editProjectMethod = function (element) {
    return {
        element,
        alternative_taxonomy_keys: [],
        old_value: [],
        body: {},
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

        async init() {
            console.log("init");

            this.old_value = JSON.parse(element.getAttribute("data-old_value"))
            this.old_value = this.old_value;

            this.alternative_taxonomy_keys = JSON.parse(element.getAttribute("data-alternative_taxonomy_keys"))
            this.alternative_taxonomy_keys = this.alternative_taxonomy_keys.sort((a, b) => a.key_slug.localeCompare(b.key_slug))


            this.alternative_taxonomy_keys = this.alternative_taxonomy_keys
                .map(atk => {
                    let checked = false;
                    let type = "cost";

                    let criterias = this.old_value.criterias.filter(criteria => criteria.slug == atk.key_slug)
                    if (criterias.length > 0) {
                        let criteria = criterias[0]
                        checked = true
                        type = criteria.type
                    }
                    return {
                        ...atk,
                        checked,
                        type
                    }
                })

            console.log("old_value", this.get(this.old_value));
            console.log("alternative_taxonomy_keys", this.get(this.alternative_taxonomy_keys));
            // await new Promise((r) => setTimeout(r, 100))
            window.onload = () => {
                this.pull_input_values()
                this.updateAlternativeTaxonomyKeys()
                console.log("body", this.get(this.body));
                console.log("inputs", this.get(this.inputs));
                console.log("criterias", this.get(this.criterias));
            }
        },
        submit() {
            console.log("submit");
            this.pull_input_values()
            if (!this.validate()) return false
            let body = this.get(this.body)
            // get rasio
            body.criteria_rasios = this.pull_input_criteria_rasio_values()

            delete body.type

            console.log("body", body);
            // element.submit()
            this.ajax(body)
            // location.reload()
            // this.resetForm()

            console.log("submit done");

        },
        pull_input_criteria_rasio_values() {
            let criteria_rasios = []
            element.querySelectorAll(`.container-weight input[type="range"]`).forEach(el => {
                let rasio = this.weights[parseInt(el.value)].label
                if (typeof rasio == "string" && rasio.includes("/")) {
                    let rr = rasio.split("/")
                    rasio = parseInt(rr[0]) / parseInt(rr[1])
                }
                console.log("typeof rasio", typeof rasio);

                criteria_rasios.push({
                    slugs: el.name.split("+"),
                    rasio
                })
            })
            return criteria_rasios
        },
        pull_input_values() {
            this.inputs = {}
            this.body = {}
            element.querySelectorAll(this.input_selector).forEach(input => {
                const default_inputs_value = {
                    value: input.value,
                    element: input,
                    error: false,
                    message: "",
                    min_length: 1
                }

                // console.log("default_inputs_value", input.name, input.getAttribute("data-value") ?? "");
                if (input.name != "criterias" && input.name != "type") {
                    this.inputs[input.name] = default_inputs_value
                    this.body[input.name] = input.getAttribute("data-value") ?? ""
                } else if (input.name == "criterias") {
                    let default_value = {
                        name: input.value,
                        checked: input.checked,
                        type: input.closest(".container-criteria-item").querySelector(`[name="type"]`).value
                    }
                    if (!this.inputs[input.name]) {
                        this.inputs[input.name] = {
                            ...default_inputs_value,
                            value: [default_value],
                            element: [input],
                            min_length: 3
                        }
                    } else {
                        this.inputs[input.name].value.push(default_value)
                        this.inputs[input.name].element.push(input)
                    }

                    if (input.checked) {
                        function get_criteria_value(input) {
                            return {
                                name: input.parentElement.querySelector("label").innerText,
                                slug: input.value,
                                type: input.closest(".container-criteria-item").querySelector(`[name="type"]`).value
                            }
                        }
                        if (!this.body[input.name]) this.body[input.name] = [get_criteria_value(input)]
                        else this.body[input.name].push(get_criteria_value(input))
                    }
                }
            });
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
                console.log("response", data);
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
        get_criteria_by_slug(slug) {
            let criterias = this.old_value.criterias.filter(criteria => {
                return criteria.slug == slug
            })

            if (criterias.length == 0) return null
            return criterias[0]
        },
        updateAlternativeTaxonomyKeys() {
            console.log("CHANGE");

            this.criterias = []
            // INIT Criteria
            let actives = []
            let selector = `.container-criterias input[type='checkbox'][name="criterias"]:checked`
            this.element.querySelectorAll(selector).forEach((el) => {
                actives.push({
                    slug: el.value,
                    label: el.parentElement.querySelector("label").innerText
                })
            })

            actives.forEach(({ slug: slug1, label: label1 }, index1) => {
                actives.forEach(({ slug: slug2, label: label2 }, index2) => {
                    if (index1 < index2) {
                        if (this.criteria_values[`${slug1}+${slug2}`] == undefined) {
                            let criteria_value = 0

                            let id1 = this.get_criteria_by_slug(slug1)
                            let id2 = this.get_criteria_by_slug(slug2)

                            if (id1 && id2) {
                                let old_criteria_values = JSON.parse(this.old_value.criteria_rasio_json).filter(crj => {
                                    return crj.criteria_id_1 == id1.id && crj.criteria_id_2 == id2.id
                                })
                                if (old_criteria_values.length > 0) {
                                    let old_criteria_value = old_criteria_values[0]
                                    criteria_value = old_criteria_value.rasio
                                    criteria_value = this.weights.findIndex(weight => {
                                        return weight.value == criteria_value
                                    });
                                }
                            }

                            this.criteria_values[`${slug1}+${slug2}`] = criteria_value
                        }
                        let filter = this.criterias.filter(criteria => criteria.slug1 == slug1 && criteria.slug1 == slug2).length == 0;
                        if (filter) {
                            this.criterias.push({
                                value: this.criteria_values[`${slug1}+${slug2}`],
                                label1,
                                label2,
                                slug1,
                                slug2,
                                status: true,
                            })
                        }
                    }
                });
            });

            console.log("this.criteria_values", this.get(this.criteria_values));
            console.log("this.criterias", this.get(this.criterias));
        },
        updateCriteriaValue(index, input_name) {
            console.log("updateCriteriaValue");
            let el = element.querySelector(`input[name='${input_name}']`)
            if (!el) {
                console.log("ELEMENT TIDAK ADA", el, input_name);
                return false
            }

            let value = parseInt(el.value)
            this.criterias[index].value = value
            this.criteria_values[input_name] = value


            console.log("this.criteria_values", this.get(this.criteria_values));
            console.log("this.criterias", this.get(this.criterias));
        },
    }
}
