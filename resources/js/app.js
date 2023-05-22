import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Control of dark mode
document.querySelectorAll('.theme-mode').forEach(element => {
    element.addEventListener('click', function () {
        console.log(localStorage.theme)
        if (localStorage.theme === 'light') {
            localStorage.theme = 'dark';
            document.documentElement.classList.add('dark')
            document.querySelectorAll('.dark-theme').forEach(e => {
                e.style.display = 'block'
            })
            document.querySelectorAll('.light-theme').forEach(e => {
                e.style.display = 'none'
            })
        } else {
            localStorage.theme = 'light';
            document.documentElement.classList.remove('dark')
            document.querySelectorAll('.light-theme').forEach(e => {
                e.style.display = 'block'
            })
            document.querySelectorAll('.dark-theme').forEach(e => {
                e.style.display = 'none'
            })
        }
    })
})
