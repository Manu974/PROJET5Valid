export default class MenuSlider {
    constructor (menu, navbar, width) {
        this.navbarMobile = document.querySelector(navbar);
        this.menuBurger   = document.querySelector(menu);
        this.className    = this.menuBurger.className;
        this.isOpen       = false;
        this.width        = width;

        document.body.addEventListener('click', e => { this.slideMenu(e, 'body') });
        this.menuBurger.addEventListener('click', e => { this.slideMenu(e) });
        this.navbarMobile.addEventListener('click', e => { e.stopPropagation(); });
    }

    slideMenu (event = null, element = null) {
        if (event) { event.stopPropagation(); }

        if (!this.isOpen && element !== 'body') {
            this.menuBurger.className = this.className + ' is_active';
            this.navbarMobile.style.display = 'block';
            this.isOpen = true;

            setTimeout(() => {
                this.navbarMobile.style.right = '0px';
            }, 200);
        } else {
            this.navbarMobile.style.right = '-' + this.width;
            this.menuBurger.className = this.className;
            this.isOpen = false;


            setTimeout(() => {
                this.navbarMobile.style.display = 'none';
            }, 400);
        }
    }
}
