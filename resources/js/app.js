import './bootstrap';

import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Alpine = Alpine;

Alpine.start();

AOS.init({
    duration: 1000,
    easing: 'cubic-bezier(0.33, 1, 0.68, 1)',
    once: true,
});

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".toggle-password").forEach(function(button){

        button.addEventListener("click", function(){

            const targetId = this.dataset.target;
            const iconId = this.dataset.icon;

            const input = document.getElementById(targetId);
            const icon = document.getElementById(iconId);

            if (!input) return;

            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";

            if(icon){
                icon.src = isPassword
                    ? "/images/icons/ShowPassword.webp"
                    : "/images/icons/HidePassword.webp";
            }
        });

    });

});
