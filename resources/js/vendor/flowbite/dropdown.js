on(".flowbite-dropdown", "click", (e, _this) => {
    e.preventDefault()
    e.stopPropagation()
    let placement = "bottom"
    let targetEl = document.getElementById(_this.getAttribute("data-dropdown-toggle"))
    if (!targetEl) return false

    let data_placement = _this.getAttribute("data-dropdown-placement")
    if (data_placement) placement = data_placement
    console.log({ placement });
    const dropdown = new Dropdown(targetEl, _this, {
        placement: "left-start"
    });
    dropdown.show();
})
