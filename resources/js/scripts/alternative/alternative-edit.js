window.editAltenative = editAltenative
function editAltenative(element) {
    return {
        body: {},
        element,
        url: "",
        old_alternative: null,
        attributes: [],
        target_dom: "input#alternative-edit-name, input#alternative-edit-uuid, textarea#alternative-edit-description",
        target_dom_validate: "input#alternative-edit-name",
        async submitEditAltenative(e) {
            e.preventDefault()
            e.stopPropagation()
            let inputs = element.querySelectorAll(this.target_dom_validate)
            let values = []
            inputs.forEach(input => {
                values.push(input.value)
                this.body[input.name].value = input.value
                let str_class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                if (input.value.length > 0) {
                    this.body[input.name].error = false
                } else {
                    str_class = "border-red-500 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm w-full"
                    this.body[input.name].error = true
                }
                input.setAttribute("class", str_class)
            });

            log("this.body", this.body)
            let request = {}
            Object.keys(this.body).forEach(key => {
                request[key] = this.body[key].value
            })
            request["attributes"] = this.attributes.map(tax => {
                return {
                    key: tax.key,
                    value: tax.value,
                }
            })
            log("request", request)

            if (values.every(value => value != "")) {
                element.querySelector(".close-alternative-edit-modal").click()
                let url = this.url;
                let res = await fetch(url, {
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

                res = await res.json()
                log("res", res)
                
                Object.keys(this.body).forEach(key => {
                    this.body[key] = { ...this.body[key], value: "" }
                })
                this.attributes = []
                // element.querySelector("#alternative-description").innerHtml = ""

                if (window.table_alternative) {
                    window.table_alternative.ajax.reload(null, false)
                }
            }
        },
        init() {
            // let old_value = element.querySelector()
            let str_class = "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
            element.querySelectorAll(this.target_dom).forEach(input => {
                input.setAttribute("class", str_class)
                this.body[input.name] = {
                    value: "",
                    error: false,
                    message: `The ${input.name} field is required.`,
                    el: input
                }
            });

            on(".button-edit-alternative", "click", (e, _this) => {
                let old_alternative = JSON.parse(_this.getAttribute("data-alternative"))
                this.url = _this.getAttribute("action")
                this.old_alternative = old_alternative
                this.body.name.value = old_alternative.name
                this.body.uuid.value = old_alternative.uuid
                this.body.description.value = old_alternative.description
                old_alternative.attributes = JSON.parse(old_alternative.attributes)
                this.attributes = Object.keys(old_alternative.attributes).map(key => {
                    return { key: key, value: old_alternative.attributes[key] }
                })
            })
        },
        addDetail() {
            const key = element.querySelector("#alternative-edit-key").value
            const value = element.querySelector("#alternative-edit-value").value
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
