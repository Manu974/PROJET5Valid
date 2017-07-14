(function () {
    let adminColor = '#00A99D';

    let navbarMobile = document.querySelector('.navbar-mobile-content');
    let links = document.querySelectorAll('section a:not(.btn), .article-footer a');
    let buttons = document.querySelectorAll('section .btn:not(.btn--large), button[type=submit]');
    let icons = document.querySelectorAll('.navbar-mobile-content .icon, section .icon, section:not(.carte-container) .icon--large, .comments .icon, .blog-title .icon, .observation-container .icon, .observation-container .icon--large');
    let titles = document.querySelectorAll('h1:not(.home-title), h2, h3, h3 span, h4, h5');
    let labels = document.querySelectorAll('label');

    navbarMobile.classList.add('is_pro');
    labels.forEach(label => {
        label.style.color = adminColor;
    })
    titles.forEach(title => {
        title.style.color = adminColor;
    })
    icons.forEach(icon => {
        icon.classList.remove('is_active');
        icon.classList.add('is_pro')
    })
    buttons.forEach(button => {
        button.style.backgroundColor = adminColor;
    })
    links.forEach(link => {
        link.style.color = adminColor;
    })

})();
