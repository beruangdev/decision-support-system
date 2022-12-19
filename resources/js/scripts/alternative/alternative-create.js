window.storeAltenative = storeAltenative
function storeAltenative(element) {
    return {
        body: {},
        element,
        taxonomies: [
            { key: "Provinsi", value: "Aceh" },
            { key: "Kabupaten", value: "Aceh Barat" },
            { key: "Salary", value: "1000000" },
        ],
        target_dom: "input#alternative-name, textarea#alternative-description",
        async submitStoreAltenative(e) {
            e.preventDefault()
            e.stopPropagation()
            let inputs = element.querySelectorAll(this.target_dom)
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

            let request = {}
            Object.keys(this.body).forEach(key => {
                request[key] = this.body[key].value
            })
            request["taxonomies"] = this.taxonomies.map(tax => {
                return {
                    key: tax.key,
                    value: tax.value,
                }
            })
            request = [request]
            if (values.every(value => value != "")) {
                // element.submit()
                let res = await fetch(routes["alternative.store"].uri, {
                    method: 'POST',
                    body: JSON.stringify(request),
                    headers: {
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        'Content-Type': 'application/json',
                        'url': routes["alternative.store"].uri,
                        "X-CSRF-Token": csrf
                    },
                })

                res = await res.json()
                Object.keys(this.body).forEach(key => {
                    this.body[key] = {...this.body[key], value: "" }
                })

                this.taxonomies = []
                element.querySelector(".close-alternative-modal").click()
                element.querySelector("#alternative-description").innerHtml = ""

                if(window.table_alternative){
                    window.table_alternative.ajax.reload(null, false)
                }
            }
        },
        initStoreAltenative() {
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
        },
        addTaxonomy() {
            const key = element.querySelector("#alternative-key").value
            const value = element.querySelector("#alternative-value").value
            if (key && value) {
                this.taxonomies.push({ key, value })
            }
        },
        updateTaxonomy(index, field, value) {
            this.taxonomies[index][field] = value
        },
        deleteTaxonomy(index) {
            this.taxonomies.splice(index, 1)
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
