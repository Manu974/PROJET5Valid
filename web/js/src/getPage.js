class loadLoginPage {
    /**
     *
     * @param element
     * @param page
     */
    constructor (element, page, clickEvent) {
        this.element = document.querySelector(element);
        this.loginContent = null;
        this.page = page;
        this.getPage();

        let links = document.querySelectorAll(clickEvent);
        links.forEach((link) => {
            link.addEventListener('click', e => {
                e.stopPropagation();
                this.element.style.display = 'block';
                setTimeout(() => {
                    this.loginContent.style.left = 0;
                }, 100);
            });
        });
        document.body.addEventListener('click', e => {
            e.stopPropagation();
            this.loginContent.style.left = '-1400px';
            setTimeout(() => {
                this.element.style.display = 'block';
            }, 200);
        });
    }

    getPage() {
        axios.get(this.page)
            .then(res => {
                this.element.innerHTML = res.data;
                this.loginContent = document.querySelector('.login-content');
                this.loginContent.addEventListener('click', e => e.stopPropagation());
            })
    }
}