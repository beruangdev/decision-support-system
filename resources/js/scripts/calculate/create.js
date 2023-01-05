window.createCalculate = createCalculate
function createCalculate(element) {
    return {
        element,
        body: {
            algorithm: ""
        },
        init() {

        },
        submit() {
            this.ajax(this.body)
        },
        async ajax(request) {
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

        },
        url() {
            return this.element.getAttribute("action")
        },
    }
}
