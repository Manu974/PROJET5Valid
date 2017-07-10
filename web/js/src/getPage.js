class loadPage {
    /**
     *
     * @param element
     * @param page
     */
    constructor (element, page) {
        this.element = document.querySelector(element);
        this.page = page;
        this.getPage();
    }

    getPage() {
        axios.get(this.page)
            .then(res => {
                this.element.innerHTML = res.data;
            })
    }
}