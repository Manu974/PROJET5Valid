'use strict';

(function () {
    let menuBurger = new MenuSlider('.icon.icon--burger', '.navbar-mobile-content', '305px');

    new HeaderShrink('.header', 200, '88px', menuBurger);
    let loginPage = new loadAjaxPage('#login-page', '/login', 'header .icon--connection, .home-container .icon--connection', '.login-content');
    let contactPage = new loadAjaxPage('#contact-page', '/programmes/contact', 'header .icon--contact', '.contact-content');
})();

