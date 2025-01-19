import './bootstrap';
import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import PerfectScrollbar from "perfect-scrollbar";
import Swal from 'sweetalert2';

window.Swal = Swal;
window.PerfectScrollbar = PerfectScrollbar;

document.addEventListener("alpine:init", () => {
    Alpine.data("mainState", () => {
        let lastScrollTop = 0;
        const init = function () {
            window.addEventListener("scroll", () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop;
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true;
                    this.scrollingUp = false;
                } else {
                    // upscroll
                    this.scrollingDown = false;
                    this.scrollingUp = true;
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false;
                        this.scrollingUp = false;
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
            });
        };

        const getTheme = () => {
            if (window.localStorage.getItem("dark")) {
                return JSON.parse(window.localStorage.getItem("dark"));
            }
            return (
                !!window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            );
        };
        const setTheme = (value) => {
            window.localStorage.setItem("dark", value);
        };
        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode;
                setTheme(this.isDarkMode);
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return;
                }
                this.isSidebarHovered = value;
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false;
                } else {
                    this.isSidebarOpen = true;
                }
            },
            scrollingDown: false,
            scrollingUp: false,
        };
    });
});
window.addEventListener('DOMContentLoaded', (event) => {
    if (document.querySelector('.alert-success')) {
        Swal.fire({
            icon: 'success',
            title: document.querySelector('.alert-success').getAttribute('data-title'),
            text: document.querySelector('.alert-success').getAttribute('data-message'),
            showConfirmButton: false,
            timer: 3000
        });
    }

    if (document.querySelector('.alert-error')) {
        Swal.fire({
            icon: 'error',
            title: document.querySelector('.alert-error').getAttribute('data-title'),
            text: document.querySelector('.alert-error').getAttribute('data-message'),
            showConfirmButton: false,
            timer: 3000
        });
    }

    if (document.querySelector('.alert-warning')) {
        Swal.fire({
            icon: 'warning',
            title: document.querySelector('.alert-warning').getAttribute('data-title'),
            text: document.querySelector('.alert-warning').getAttribute('data-message'),
            showConfirmButton: false,
            timer: 3000
        });
    }

    if (document.querySelector('.alert-info')) {
        Swal.fire({
            icon: 'info',
            title: document.querySelector('.alert-info').getAttribute('data-title'),
            text: document.querySelector('.alert-info').getAttribute('data-message'),
            showConfirmButton: false,
            timer: 3000
        });
    }
});
Alpine.plugin(collapse);

Alpine.start();
