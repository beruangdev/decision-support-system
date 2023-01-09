window.createAltenative = function (element) {
    return {
        body: {},
        input_selector: ".alternative-input input, .alternative-input textarea",
        element,
        attributes: [
            { key: "Provinsi", value: "Aceh" },
            { key: "Kabupaten", value: "Aceh Barat" },
            { key: "Salary", value: "1000000" },
        ],
        init() {
            element.querySelectorAll(this.input_selector).forEach(input => {
                this.body[input.name] = {
                    value: "",
                    error: false,
                    message: `The ${input.name} field is required.`,
                    el: input
                }
            });
        },
        async submit() {
            if (!this.validate()) return false
            const request = this.make_request_data()
            console.log("request", request);
            this.ajax(request)
        },
        make_request_data() {
            let request = {
                alternatives: [],
                attributes: [],
            }
            let alternative = {}
            Object.keys(this.body).forEach(key => {
                alternative[key] = this.body[key].value
                this.body[key].value = ""
            })
            request.alternatives.push(alternative)

            let attribute = this.attributes.map(tax => {
                return {
                    key: tax.key,
                    value: tax.value,
                }
            })
            request.attributes.push(attribute)
            this.attributes = []
            return request
        },
        async ajax(request) {
            element.querySelector(".modal-close").click()
            fetch(this.url(), {
                method: 'POST',
                body: JSON.stringify(request),
                headers: {
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'Content-Type': 'application/json',
                    'url': this.url(),
                    "X-CSRF-Token": csrf
                },
            }).then(async (response) => {
                if (window.table_alternative) {
                    window.table_alternative.ajax.reload(null, false)
                }
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
                console.log("status", status);
                console.log("response", data);
            }).catch((err) => {
                // There was an error
                console.warn('Something went wrong.', err);
            });

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
        },
        addDetail() {
            const key = element.querySelector("#alternative-key").value
            const value = element.querySelector("#alternative-value").value
            if (key && value) {
                this.attributes.push({ key, value })
            }
        },
        updateDetail(index, field, value) {
            this.attributes[index][field] = value
        },
        deleteDetail(index) {
            this.attributes.splice(index, 1)
        }

    }
}

// async function fetch_daerah(url) {
//     const base_url = `https://dev.farizdotid.com/api/daerahindonesia`
//     let res = await fetch(`${base_url}/${url}`)
//     res = await res.json()
//     return res
// }

// init_daerah()
// async function init_daerah() {
//     let provinces = await fetch_daerah("provinsi")
//     let optionEL = ""
//     provinces.provinsi.forEach(province => {
//         optionEL += `<option value="${province.nama}" data-id="${province.id}">${province.nama}</option>`
//     });
//     document.querySelector("#project-province").removeAttribute("disabled")
//     document.querySelector("#project-province").innerHTML = optionEL

//     listen_daerah("province", "kota?id_provinsi", "kabupaten", "kota_kabupaten")
//     listen_daerah("kabupaten", "kecamatan?id_kota", "kecamatan", "kecamatan")
//     listen_daerah("kecamatan", "kelurahan?id_kecamatan", "village", "kelurahan")
// }

// function listen_daerah(name_parent, url, target_name, target_label) {
//     document.querySelector(`#project-${name_parent}`).addEventListener("change", async (e) => {
//         let ell = [
//             "province",
//             "kabupaten",
//             "kecamatan",
//             "village",
//         ]
//         ell.forEach((el, index) => {
//             if (index >= ell.indexOf(target_name)) {
//                 document.querySelector(`#project-${el}`).setAttribute("disabled", "")
//                 document.querySelector(`#project-${el}`).innerHTML = `<option value="">-</option>`
//             }
//         });


//         let areas = await fetch_daerah(`${url}=${e.target.options[e.target.selectedIndex].getAttribute("data-id")}`)
//         let optionEL = ""
//         areas[target_label].forEach(area => {
//             optionEL += `<option value="${area.nama}" data-id="${area.id}">${area.nama}</option>`
//         });
//         document.querySelector(`#project-${target_name}`).removeAttribute("disabled")
//         document.querySelector(`#project-${target_name}`).innerHTML = optionEL
//     })
// }
