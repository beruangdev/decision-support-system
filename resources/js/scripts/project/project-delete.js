on(".button-delete-project", "click", async (e, _this) => {
    e.preventDefault()
    e.stopPropagation()

    await fetch(_this.href, {
        method: 'DELETE',
        headers: {
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            'Content-Type': 'application/json',
            'url': _this.href,
            "X-CSRF-Token": csrf
        },
    })

    if (window.table_project) {
        window.table_project.ajax.reload(null, false)
    }
})
