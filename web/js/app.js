'use strict';

(function () {
    let menuBurger = new MenuSlider('.icon.icon--burger', '.navbar-mobile-content', '305px');

    new HeaderShrink('.header', 200, '88px', menuBurger);
    new loadLoginPage('#login-page', '/login', 'header .icon--connection, .home-container .icon--connection');
})();

