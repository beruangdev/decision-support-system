on(".button-delete-project_method", "click", async (e, _this) => {
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

    if (window.table_project_method) {
        window.table_project_method.ajax.reload(null, false)
    }
    if (window.table_project_show) {
        window.table_project_show.ajax.reload(null, false)
    }
})
