window.createProjectMethod = function (element) {
    return {
        element,
        alternative_taxonomy_keys: [],
        body: {},
        inputs: {},
        criterias: [],
        criteria_values: {},
        weights: [
            1, 2, 3, 4, 5, 6, 7, 8, 9, "1/2", "1/3", "1/4", "1/5", "1/6", "1/7", "1/8", "1/9", "1/9"
        ],
        // input_selector: `.container-input-project-method input, .container-input-project-method textarea, .container-input-project-method select`,
        input_selector: `.container-input-project-method input[type="text"], .container-input-project-method textarea, .container-input-project-method select, .container-input-project-method input[type="checkbox"]`,

        async init() {
            console.log("init");
            this.alternative_taxonomy_keys = JSON.parse(element.getAttribute("data-alternative_taxonomy_keys"))

            this.alternative_taxonomy_keys = this.alternative_taxonomy_keys.sort((a, b) => a.key_slug.localeCompare(b.key_slug));

            console.log("alternative_taxonomy_keys", this.get(this.alternative_taxonomy_keys));
            // await new Promise((r) => setTimeout(r, 10))
            window.onload = () => {
                this.pull_input_values()
                console.log("body", this.get(this.body));
                console.log("inputs", this.get(this.inputs));
            }
        },
        submit() {
            console.log("submit");
            this.pull_input_values()


            // if (!this.validate()) return false
            this.validate()
            let body = this.get(this.body)
            body.weights = this.pull_input_weight_values()
            // get weight

            console.log("body", body);
            // console.log("inputs", this.get(this.inputs));

            console.log("submit done");

        },
        pull_input_weight_values() {
            let weights = []
            element.querySelectorAll(`.container-weight input[type="range"]`).forEach(el => {
                weights.push({
                    name: el.name,
                    value: this.weights[parseInt(el.value)]
                })
            })
            return weights
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
                if (input.name != "criterias") {
                    this.inputs[input.name] = default_inputs_value
                    this.body[input.name] = input.value
                } else if (input.name == "criterias") {
                    if (!this.inputs[input.name]) {
                        this.inputs[input.name] = {
                            ...default_inputs_value,
                            value: [{ name: input.value, checked: input.checked }],
                            element: [input],
                            min_length: 3
                        }
                    } else {
                        this.inputs[input.name].value.push({
                            name: input.value,
                            checked: input.checked
                        })
                        this.inputs[input.name].element.push(input)
                    }

                    if (input.checked) {

                        function get_criteria_value(input) {
                            return {
                                label: input.parentElement.querySelector("label").innerText,
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
        ajax() { },
        updateAlternativeTaxonomyKeys(atk, index) {
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
                            this.criteria_values[`${slug1}+${slug2}`] = 0
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
