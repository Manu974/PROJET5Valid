'use strict';

let menuBurger = new MenuSlider('.icon.icon--burger', '.navbar-mobile-content', '305px');

new HeaderShrink('.header', 200, '88px', menuBurger);


new loadPage('#app', '/login');
//let loginSlider = new MenuSlider('.icon--connexion', '.');

