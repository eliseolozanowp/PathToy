<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['idUsuario'])) {
    // Si el usuario ha iniciado sesión, redirigirlo a la página de feed
    header("Location: /webexample/private/feed.php");
    exit();
}
include_once '../views/head.php'; ?>

<!-- Contenido del formulario de registro -->
<div class="fondo-login">
    <div class="icon">
        <a href="/webexample/index.php">
            <i class="fa-solid fa-house back-icon"> Inicio</i>
        </a>
    </div>
    <div class="titulo">
        Regístrate en PathToy
    </div>

    <!--formulario de singup-->
    <form action="validaciones/validar_registro.php" method="POST" class="col-8 col-md-3  login">
        <div class="md-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control">
        </div>
        <div class="md-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" id="apellido" name="apellido" class="form-control">
        </div>
        <div class="md-3">
            <label for="genero" class="form-label">Género</label>
            <select id="genero" name="genero" class="form-control">
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
        </div>
        <div class="md-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" id="correo" name="correo" class="form-control">
        </div>
        <div class="md-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" class="form-control">
        </div>
        <div class="md-3">
            <label for="repetir_contrasena" class="form-label">Repetir Contraseña</label>
            <input type="password" id="repetir_contrasena" name="repetir_contrasena" class="form-control">
        </div><br>
        <?php
        session_start();
        if (isset($_SESSION['errores'])) {
            foreach ($_SESSION['errores'] as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            unset($_SESSION['errores']);
        }
        ?>

        <div class="row p-1">
            <div class="d-grid">
                <button type="submit" class=" btn btn-dark">Crear Usuario</button>
            </div>
        </div>
    </form>
    <div class="col-8 col-md-3 mt-3 login">
        ¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión</a>
    </div><br>
</div>

<script>
    // Código JavaScript para ocultar los mensajes de error después de 3 segundos
    setTimeout(function () {
        let mensajesError = document.querySelectorAll('.alert-danger');
        mensajesError.forEach(function (mensaje) {
            mensaje.style.display = 'none';
        });
    }, 3000); // 3 segundos (3000 milisegundos)
</script>

<?php include_once '../views/footer.php'; ?>