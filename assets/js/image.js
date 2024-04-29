document.addEventListener("DOMContentLoaded", function () {
    const imagenProducto = document.getElementById("imagenProducto");
    const labelImagen = document.getElementById("labelImagen");
    const iconoImagen = document.getElementById("iconoImagen");

    imagenProducto.addEventListener("change", function (event) {
        const archivo = event.target.files[0];

        if (archivo) {
            const reader = new FileReader();

            reader.onload = function (e) {
                // Crear un nuevo elemento de imagen
                const imagenPrevia = new Image();
                imagenPrevia.src = e.target.result;
                imagenPrevia.alt = "Vista previa de la imagen";
                imagenPrevia.id = "imagenPrevia";
                imagenPrevia.style.maxWidth = "100%";
                imagenPrevia.style.maxHeight = "100%";

                // Reemplazar el icono con la imagen de vista previa
                labelImagen.replaceChild(imagenPrevia, iconoImagen);
            };

            reader.readAsDataURL(archivo);
        }
    });
});
