
const links = document.querySelectorAll(".nav-link");
window.addEventListener("scroll", () => {
    let fromTop = window.scrollY + 100;
    links.forEach(link => {
        let section = document.querySelector(link.getAttribute("href"));
        if (section.offsetTop <= fromTop && section.offsetTop + section.offsetHeight > fromTop) {
            links.forEach(l => l.classList.remove("active"));
            link.classList.add("active");
        }
    });
});

// Off-canvas toggle with jQuery
$(document).ready(function() {
    $('.toggle-menu').click(function() {
        $('.sidebar').toggleClass('show');
        $('.overlay').toggleClass('show');
    });

    $('.overlay, .nav-link').click(function() {
        $('.sidebar').removeClass('show');
        $('.overlay').removeClass('show');
    });
    $('.nav-link').click(function () {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });
    $('.nav-link-toggle').click(function() {
        $(this).next('.submenu').toggleClass('show');
    });
});
