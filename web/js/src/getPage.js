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
            link.parentNode.addEventListener('click', e => {
                e.stopPropagation();
                this.loginContent.style.display = 'block';
                this.element.style.display = 'block';
                setTimeout(() => {
                    this.loginContent.style.left = 0;
                }, 90);
            });
        });
        document.body.addEventListener('click', e => {
            e.stopPropagation();
            this.loginContent.style.left = '-1500px';
            setTimeout(() => {
                this.element.style.display = 'none';
            }, 700);
            setTimeout(() => {
                this.loginContent.style.display = 'none';
            }, 700)
        });
    }

    getPage() {
        let instance = axios.create({
            headers:{'X-Requested-With': 'XMLHttpRequest'}
        });
        instance.get(this.page)
            .then(res => {
                this.element.innerHTML = res.data;
                this.loginContent = document.querySelector('.login-content');
                this.loginContent.addEventListener('click', e => e.stopPropagation());
            })
    }
}