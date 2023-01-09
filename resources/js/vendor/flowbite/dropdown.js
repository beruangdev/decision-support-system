on(".flowbite-dropdown", "click", (e, _this) => {
    e.preventDefault()
    e.stopPropagation()
    // document.querySelectorAll(".flowbite-dropdown").forEach(element => {
    //     let targetEl = document.getElementById(element.getAttribute("data-dropdown-toggle"))
    //     if (targetEl) {
    //         const dropdown = new Dropdown(targetEl, element);
    //         dropdown.hide(true);
    //     }
    // })
    let placement = "bottom"
    let targetEl = document.getElementById(_this.getAttribute("data-dropdown-toggle"))
    if (!targetEl) return false

    let data_placement = _this.getAttribute("data-dropdown-placement")
    if (data_placement) placement = data_placement

    const dropdown = new Dropdown(targetEl, _this, {
        placement: placement
    });
    dropdown.show(true);
})
