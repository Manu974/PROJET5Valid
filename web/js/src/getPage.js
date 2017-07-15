class loadAjaxPage {
    /**
     *
     * @param element
     * @param page
     * @param clickEvent
     * @param elementOfTheloadedPage
     */
    constructor (element, page, clickEvent, elementOfTheloadedPage ) {
        this.element = document.querySelector(element);
        this.pageContent = null;
        this.page = page;
        this.getPage(elementOfTheloadedPage);
        let links = document.querySelectorAll(clickEvent);
        links.forEach((link) => {
            link.parentNode.addEventListener('click', e => {
                e.stopPropagation();
                this.pageContent.style.display = 'block';
                this.element.style.display = 'block';
                setTimeout(() => {
                    this.pageContent.style.left = 0;
                }, 90);
            });
        });
        document.body.addEventListener('click', e => {
            e.stopPropagation();
            this.pageContent.style.left = '-1500px';
            setTimeout(() => {
                this.element.style.display = 'none';
            }, 700);
            setTimeout(() => {
                this.pageContent.style.display = 'none';
            }, 700)
        });
    }

    getPage(elementOfTheloadedPage) {
        let instance = axios.create({
            headers:{'X-Requested-With': 'XMLHttpRequest'}
        });
        instance.get(this.page)
            .then(res => {
                this.element.innerHTML = res.data;
                this.pageContent = document.querySelector(elementOfTheloadedPage);
                this.pageContent.addEventListener('click', e => e.stopPropagation());
            })
    }
}