
const html = document.querySelector('html');
const body = document.querySelector('body');
const headerNavbar = document.querySelector('.header-navbar');
const mainMenu = document.querySelector('.main-menu');
const icon = document.querySelector('#theme-icon');

document.getElementById("theme-toggle").addEventListener("click", function() {

    if (html.getAttribute("data-theme") === "dark") {

        html.dataset.theme = "light";
        localStorage.setItem('dark', 'false');

        html.classList.remove('dark-layout')
        html.classList.add('light-layout')

        headerNavbar.classList.add('navbar-light');
        headerNavbar.classList.remove('navbar-dark');
        mainMenu.classList.add('menu-light')
        mainMenu.classList.remove('menu-dark')
        icon.classList.remove('fa-sun')
        icon.classList.add('fa-moon')
    }
    else {
        localStorage.setItem('dark', 'true');
        html.dataset.theme = "dark";

        html.classList.remove('light-layout')
        html.classList.add('dark-layout')

        headerNavbar.classList.remove('navbar-light');
        headerNavbar.classList.add('navbar-dark');
        mainMenu.classList.remove('menu-light')
        mainMenu.classList.add('menu-dark')
        icon.classList.remove('fa-moon')
        icon.classList.add('fa-sun')
    }
});


if (localStorage.getItem('dark') === "true") {
    if (html.classList.contains('light-layout')) {
        html.classList.remove('light-layout')
        html.classList.add('dark-layout')
    }
    headerNavbar.classList.remove('navbar-light');
    headerNavbar.classList.add('navbar-dark');
    mainMenu.classList.remove('menu-light')
    mainMenu.classList.add('menu-dark')
    icon.classList.remove('fa-moon')
    icon.classList.add('fa-sun')
}
else {
    if (html.classList.contains('dark-layout')) {
        html.classList.remove('dark-layout')
        html.classList.add('light-layout')
    }
    headerNavbar.classList.add('navbar-light');
    headerNavbar.classList.remove('navbar-dark');
    mainMenu.classList.add('menu-light')
    mainMenu.classList.remove('menu-dark')
    icon.classList.remove('fa-sun')
    icon.classList.add('fa-moon')
}


