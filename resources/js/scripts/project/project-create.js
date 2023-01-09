window.createProject = function (element) {

    return {
        body: {},
        element,
        input_selector: "input, textarea",
        init() {
            element.querySelectorAll("input, textarea").forEach(el_input => {
                this.body[el_input.name] = {
                    name: el_input.name,
                    value: el_input.value,
                    error: false,
                    message: `The ${el_input.name} is required`
                }
            });
        },
        async submit() {
            if (!this.validate()) return false
            const request = this.make_request_data()
            this.ajax(request)
        },
        make_request_data(){
            let request = {}
            Object.keys(this.body).forEach(key => {
                request[key] = this.body[key].value
                this.body[key].value = ""
            })
            return request
        },
        async ajax(request) {
            element.querySelector(".modal-close").click()
            let response = await fetch(this.url(), {
                method: 'POST',
                body: JSON.stringify(request),
                headers: {
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'Content-Type': 'application/json',
                    'url': this.url(),
                    "X-CSRF-Token": csrf
                },
            })
            response = await response.json()
            console.log(response);
            if (window.table_project) {
                window.table_project.ajax.reload(null, false)
            }
        },
        url() {
            return element.getAttribute("action")
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
