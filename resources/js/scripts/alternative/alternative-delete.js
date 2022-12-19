on(".button-delete-alternative", "click", async (e, _this) => {
    e.preventDefault()
    e.stopPropagation()

    await fetch(_this.href, {
        method: 'DELETE',
        headers: {
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            'Content-Type': 'application/json',
            'url': routes["alternative.store"].uri,
            "X-CSRF-Token": csrf
        },
    })

    if (window.table_alternative) {
        window.table_alternative.ajax.reload(null, false)
    }
})
