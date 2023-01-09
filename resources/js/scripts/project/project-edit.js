window.editProject = function (element) {

    return {
        element,
        input_selector: "input, textarea",
        project: null,
        body: {},
        init() {
            element.querySelectorAll("input, textarea").forEach(el_input => {
                this.body[el_input.name] = {
                    name: el_input.name,
                    value: el_input.value,
                    error: false,
                    message: `Input ${el_input.name} is required`
                }
            });
            on(".button-edit-project", "click", (e, _this) => {
                this.project = JSON.parse(_this.getAttribute("data-project"))
                Object.keys(this.body).forEach(key => {
                    this.body[key].value = this.project[key]
                })
            })
        },
        async submit() {
            console.log("SUBMIT");
            if (!this.validate()) return false
            var request = {}
            Object.keys(this.body).forEach(key => {
                request[key] = this.body[key].value
                this.body[key].value = ""
            })

            element.querySelector(".modal-close").click()
            console.log({ request });
            // let url = `${routes["project.store"].uri}/${this.project.id}`
            // let url = `${routes["project.store"].uri}/${this.project.id}`
            let url = this.url(this.project.id)
            let response = await fetch(url, {
                method: 'PUT',
                body: JSON.stringify(request),
                headers: {
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'Content-Type': 'application/json',
                    'url': url,
                    "X-CSRF-Token": csrf
                },
            })
            response = await response.json()
            console.log("response", response);
            console.log(this.body);

            if (window.table_project) {
                window.table_project.ajax.reload(null, false)
            }
        },
        url(id) {
            return `${element.getAttribute("action")}/${id}`
        },
        validate() {
            let result = true
            element.querySelectorAll(this.input_selector).forEach(el => {
                let classList = el.closest(".wrapper-input-floating-label")?.classList
                if (classList) {
                    if (el.getAttribute("data-required") != undefined && el.value == "") {
                        if (!classList.contains("error")) classList.add("error")
                        result = false
                    } else {
                        if (classList.contains("error")) classList.remove("error")
                    }
                }
            })
            return result
        }
    }
}
