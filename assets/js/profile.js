document.querySelector(".editar-info").addEventListener("click", function () {
    // Habilitar los campos de entrada para edición
    document.getElementById("nombre").readOnly = false;
    document.getElementById("apellido").readOnly = false;
    document.getElementById("correo").readOnly = false;
});

function mostrarMensaje(mensaje) {
    var mensajeDiv = document.getElementById("mensaje");
    mensajeDiv.innerText = mensaje;
    mensajeDiv.style.display = "block";
}

// Eliminar el parámetro 'mensaje' de la URL
window.history.replaceState({}, document.title, "perfil.php");



document.querySelector(".editar-info").addEventListener("click", function () {
    // Habilitar los campos de entrada para edición
    document.getElementById("nombre").readOnly = false;
    document.getElementById("apellido").readOnly = false;
    document.getElementById("correo").readOnly = false;

    // Mostrar el botón "Actualizar Cambios"
    document.getElementById("btn-actualizar").style.display = "block";

    // Ocultar el botón "Eliminar perfil"
    // document.querySelector(".btn-eliminar").style.display = "none";

    // Mostrar el botón "Cancelar"
    document.getElementById("btn-cancelar").style.display = "block";

    // Eliminar el mensaje guardado en sessionStorage
    sessionStorage.removeItem("mensajeActualizado");
});



function cancelarEdicion() {
    // Redirigir al usuario nuevamente a la página de perfil
    window.location.href = "perfil.php";
}

document.querySelector("#cameraImage").addEventListener("click", function () {
    document.querySelector("#inputFile").click();
});

document.querySelector("#inputFile").addEventListener("change", function () {
    if (this.files && this.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            let cameraImageDiv = document.querySelector('.perfil-logo');
            // Esconder la imagen de la cámara
            document.querySelector('.camera').style.display = 'none';
            // Establecer la imagen seleccionada como el fondo de 'perfil-logo'
            cameraImageDiv.style.backgroundImage = 'url(' + e.target.result + ')';
            cameraImageDiv.style.backgroundSize = 'cover';
            cameraImageDiv.style.backgroundPosition = 'center';
        }

        reader.readAsDataURL(this.files[0]);
    }
});
