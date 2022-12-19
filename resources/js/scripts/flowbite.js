on("[data-popover-target], .popover-wrapper", "mouseover", (e, _this) => {
    let classList = document.querySelector(`#${_this.getAttribute("data-popover-target")}`)
    if (!classList) classList = _this.querySelector("[data-popover]")
    classList = classList.classList

    if (classList.contains("opacity-0")) {
        classList.remove("opacity-0")
    }

    if (classList.contains("invisible")) {
        classList.add("visible")
        classList.remove("invisible")
    }
})

on("[data-popover-target], .popover-wrapper", "mouseout", (e, _this) => {
    let classList = document.querySelector(`#${_this.getAttribute("data-popover-target")}`)
    if (!classList) classList = _this.querySelector("[data-popover]")
    classList = classList.classList

    if (!classList.contains("opacity-0")) {
        classList.add("opacity-0")
    }

    if (classList.contains("visible")) {
        classList.remove("visible")
        classList.add("invisible")
    }
})

on("[data-popover-target]", "click", (e, _this) => {
    let classList = document.querySelector(`#${_this.getAttribute("data-popover-target")}`).classList

    let on_hide = classList.contains("opacity-0")

    classList.remove("invisible")
    classList.remove("visible")

    if (on_hide) {
        classList.remove("opacity-0")
        classList.remove("invisible")
        classList.add("visible")
    } else {
        classList.add("opacity-0")
        classList.add("invisible")
        classList.remove("visible")
    }
})
