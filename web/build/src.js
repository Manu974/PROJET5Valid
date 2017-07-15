/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/build/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./web/js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./web/js/app.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_MenuSlider__ = __webpack_require__("./web/js/src/MenuSlider.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_HeaderShrink__ = __webpack_require__("./web/js/src/HeaderShrink.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_getPage__ = __webpack_require__("./web/js/src/getPage.js");






(function () {

    var menuBurger = new __WEBPACK_IMPORTED_MODULE_0__src_MenuSlider__["a" /* default */]('.icon.icon--burger', '.navbar-mobile-content', '305px');

    new __WEBPACK_IMPORTED_MODULE_1__src_HeaderShrink__["a" /* default */]('.header', 200, '88px', menuBurger);
    var loginPage = new __WEBPACK_IMPORTED_MODULE_2__src_getPage__["a" /* default */]('#login-page', '/login', 'header .icon--connection, .home-container .icon--connection', '.login-content');
    var contactPage = new __WEBPACK_IMPORTED_MODULE_2__src_getPage__["a" /* default */]('#contact-page', '/programmes/contact', 'header .icon--contact, #footer-contact', '.contact-content');

    var messageFlash = document.querySelector('.flash-message');
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
        }, 5200);
    }
})();

/***/ }),

/***/ "./web/js/src/HeaderShrink.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var HeaderShrink =
/**
 *
 * @param header, The element for le listening
 * @param shrink, The moment when the shrink begin
 * @param newHeight, This new height of the element
 * @param menuSlider|null, The menu slider if we have one to listen at the same time of the header element.
 */
function HeaderShrink(header, shrink, newHeight) {
    var _this = this;

    var menuSlider = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

    _classCallCheck(this, HeaderShrink);

    this.header = document.querySelector(header);
    this.shrink = shrink;
    this.newHeight = newHeight;
    this.oldHeight = window.getComputedStyle(this.header).getPropertyValue('height');
    // The difference for the calcul of the new and old height for the scroll.
    this.differenceOfHeight = this.oldHeight.replace('px', '') - this.newHeight.replace('px', '');

    // Init the menu slider if we have one
    if (menuSlider !== null) {
        this.menuSlider = menuSlider;
        this.menuPositionTop = window.getComputedStyle(menuSlider.navbarMobile).getPropertyValue('top').replace('px', '');
    }

    document.addEventListener('scroll', function () {
        if (document.body.scrollTop > _this.shrink) {
            _this.header.style.height = _this.newHeight;
            _this.menuSlider.navbarMobile.style.top = _this.menuPositionTop - _this.differenceOfHeight + 'px';
        } else if (document.body.scrollTop <= 0) {
            _this.header.style.height = _this.oldHeight;
            _this.menuSlider.navbarMobile.style.top = _this.oldHeight;
        }
    });
};

/* harmony default export */ __webpack_exports__["a"] = (HeaderShrink);

/***/ }),

/***/ "./web/js/src/MenuSlider.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var MenuSlider = function () {
    /**
     *
     * @param menu, Element to listen on the click
     * @param navbar, This navigation bar
     * @param width, The new width for the display of the navigation bar
     */
    function MenuSlider(menu, navbar, width) {
        var _this = this;

        _classCallCheck(this, MenuSlider);

        this.navbarMobile = document.querySelector(navbar);
        this.menuBurger = document.querySelector(menu);
        this.className = this.menuBurger.className;
        this.isOpen = false;
        this.width = width;

        document.body.addEventListener('click', function (e) {
            _this.slideMenu(e, 'body');
        });
        this.menuBurger.addEventListener('click', function (e) {
            _this.slideMenu(e);
        });
        this.navbarMobile.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    /**
     * @param event
     * @param element
     *
     * Display the menu of when he is visible or not.
     */


    _createClass(MenuSlider, [{
        key: 'slideMenu',
        value: function slideMenu() {
            var _this2 = this;

            var event = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
            var element = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

            if (event) {
                event.stopPropagation();
            }

            if (!this.isOpen && element !== 'body') {
                this.menuBurger.classList.add('is_active');
                this.navbarMobile.style.display = 'block';
                this.isOpen = true;

                setTimeout(function () {
                    _this2.navbarMobile.style.right = '0px';
                }, 200);
            } else {
                this.navbarMobile.style.right = '-' + this.width;
                this.menuBurger.className = this.className;
                this.isOpen = false;

                setTimeout(function () {
                    _this2.navbarMobile.style.display = 'none';
                }, 400);
            }
        }
    }]);

    return MenuSlider;
}();

/* harmony default export */ __webpack_exports__["a"] = (MenuSlider);

/***/ }),

/***/ "./web/js/src/getPage.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var getPage = function () {
    /**
     *
     * @param element
     * @param page
     * @param clickEvent
     * @param elementOfTheloadedPage
     */
    function getPage(element, page, clickEvent, elementOfTheloadedPage) {
        var _this = this;

        _classCallCheck(this, getPage);

        this.element = document.querySelector(element);
        this.pageContent = null;
        this.page = page;
        this.getPage(elementOfTheloadedPage);
        var links = document.querySelectorAll(clickEvent);
        links.forEach(function (link) {
            if (link.id !== null) {
                link.addEventListener('click', function (e) {
                    e.stopPropagation();
                    _this.pageContent.style.display = 'block';
                    _this.element.style.display = 'block';
                    setTimeout(function () {
                        _this.pageContent.style.left = 0;
                    }, 90);
                });
            } else {
                link.parentNode.addEventListener('click', function (e) {
                    e.stopPropagation();
                    _this.pageContent.style.display = 'block';
                    _this.element.style.display = 'block';
                    setTimeout(function () {
                        _this.pageContent.style.left = 0;
                    }, 90);
                });
            }
        });
        document.body.addEventListener('click', function (e) {
            e.stopPropagation();
            _this.pageContent.style.left = '-1500px';
            setTimeout(function () {
                _this.element.style.display = 'none';
            }, 700);
            setTimeout(function () {
                _this.pageContent.style.display = 'none';
            }, 700);
        });
    }

    _createClass(getPage, [{
        key: 'getPage',
        value: function getPage(elementOfTheloadedPage) {
            var _this2 = this;

            var instance = axios.create({
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            instance.get(this.page).then(function (res) {
                _this2.element.innerHTML = res.data;
                _this2.pageContent = document.querySelector(elementOfTheloadedPage);
                _this2.pageContent.addEventListener('click', function (e) {
                    return e.stopPropagation();
                });
            });
        }
    }]);

    return getPage;
}();

/* harmony default export */ __webpack_exports__["a"] = (getPage);

/***/ })

/******/ });