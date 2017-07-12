(function () {

    let headerLogo  = document.querySelector('.header-logo');
    headerLogo.attributes.src.value = '/logo-icones/logo-admin.svg';

    let headerItems = document.querySelectorAll('.header-navbar-item');
    let colorAdmin = '#00A99D';

    headerItems.forEach(item => {
        item.classList.add('is_pro');
        let link = item.childNodes[3];
        let icon = item.childNodes[1];
        let colorLink = window.getComputedStyle(link).getPropertyValue('color');

        item.addEventListener('mouseover', function () {
            link.style.color = colorAdmin;
        });
        item.addEventListener('mouseout', function () {
            icon.classList.remove('is_pro');
            link.style.color = colorLink;
        });
    });
    let menuBurger = document.querySelector('.icon.icon--burger');
    menuBurger.classList.add('is_pro');

    let footerItems = document.querySelectorAll('.footer-item:not(.footer-item--center)');
    footerItems.forEach(item => {
        item.classList.add('is_pro');
        let link = item.childNodes[3];
        let colorLink = window.getComputedStyle(item).getPropertyValue('color');

        item.addEventListener('mouseover', function () {
            link.style.color = colorAdmin;
        });
        item.addEventListener('mouseout', function () {
            link.style.color = colorLink;
        });
    })
})();
