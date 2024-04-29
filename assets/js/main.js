// Código para la función de mostrar contraseña en el registro o inicio de sesión
function mostrarcontraseña(idPassword, idIcon) {
    let inputPassword = document.getElementById(idPassword);
    let icon = document.getElementById(idIcon);
    if (inputPassword.type == "contrasena" && icon.classList.contains("fa-eye")) {
        inputPassword.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash")
    } else {
        inputPassword.type = "contrasena";
        icon.classList.replace("fa-eye-slash", "fa-eye")
    }
}

const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");


toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
})

searchBtn.addEventListener("click", () => {
    sidebar.classList.remove("close");
})

modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");

    if (body.classList.contains("dark")) {
        modeText.innerText = "Light mode";
    } else {
        modeText.innerText = "Dark mode";

    }
});

const menuToggle = document.querySelector('.menu-toggle');
const menuBar = document.querySelector('.menu-bar');

menuToggle.addEventListener('click', () => {
    menuBar.classList.toggle('open');
});