'use strict';

(function () {
    let menuBurger = new MenuSlider('.icon.icon--burger', '.navbar-mobile-content', '305px');

    new HeaderShrink('.header', 200, '88px', menuBurger);
    let loginPage = new loadAjaxPage('#login-page', '/login', 'header .icon--connection, .home-container .icon--connection', '.login-content');
    let contactPage = new loadAjaxPage('#contact-page', '/programmes/contact', 'header .icon--contact, #footer-contact', '.contact-content');

    let messageFlash = document.querySelector('.flash-message');
    if (messageFlash) {
        setTimeout(function () {
            messageFlash.style.top = '200px';
            messageFlash.style.opacity = 1;
        }, 300);
        setTimeout(function () {
            messageFlash.style.opacity = 0;
            messageFlash.style.top = '500px';
        }, 3000);
        setTimeout(function () {
            messageFlash.style.display = 'none';
        }, 5200)
    }
})();

