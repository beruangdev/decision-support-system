window.layoutApp = () => {
    return {
        color_theme: "light",
        init(){
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                // document.documentElement.classList.add('dark');
                this.color_theme = "dark"
            } else {
                this.color_theme = "light"
                // document.documentElement.classList.remove('dark')
            }
        },
        onClickMode(){
            document.documentElement.classList.remove('dark')
            document.documentElement.classList.remove('light')
            
            this.color_theme = this.color_theme == "dark" ? "light" : "dark"
            localStorage.setItem('color-theme', this.color_theme)
        },
    }
}
