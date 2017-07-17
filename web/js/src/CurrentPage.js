class CurrentPage {
    constructor (role) {
        this.currentPath = window.location.pathname;
        this.iconsHeader = {
            '/': 'header .icon--home',
            '/login': 'header .icon--connection',
            '/observation/carte': 'header .icon--maps',
            '/observation': 'header .icon--obs',
            '/programmes': 'header .icon--prog',
            '/user/': 'header .icon--account',
            '/faq': 'header .icon--faq',
            '/contact': 'header .icon--contact'
        };

        for (let props in this.iconsHeader) {
            if (props === this.currentPath) {
                if (role) {
                    document.querySelector(this.iconsHeader[props]).classList.add('is_pro');
                } else {
                    document.querySelector(this.iconsHeader[props]).classList.add('is_active');
                }
            }
        }
    }
}