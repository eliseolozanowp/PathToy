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

<!-- Contenido del formulario de inicio de sesión -->
<div class="fondo-login">
    <div class="icon">
        <a href="/webexample/index.php">
            <i class="fa-solid fa-house back-icon"> Inicio</i>
        </a>
    </div>
    <div class="titulo">
        Iniciar sesión
    </div>

    <!--formulario de login-->
    <form action="validaciones/validar_login.php" method="POST" class="col-8 col-md-3  login">
        <div class="md-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" id="correo" name="correo" class="form-control">
        </div>
        <div class="md-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <div class="box-eye">
                <button type="button" onclick="mostrarcontraseña('contrasena', 'eyepassword')">
                    <i id="eyepassword" class="fa-solid fa-eye changePassword"></i>
                </button>
            </div>
            <input type="password" id="contrasena" name="contrasena" class="form-control">
        </div><br>
        <?php
        if (isset($_SESSION['errores'])) {
            foreach ($_SESSION['errores'] as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            unset($_SESSION['errores']);
        }
        ?>
        <div class="row p-3">
            <div class="d-grid">
                <a href="pass_forgot.php" class="btn btn-link">¿Olvidaste tu contraseña?</a>
                <button type="submit" class="btn btn-dark">Ingresar</button>
            </div>
        </div>
    </form>
    <div class="col-8 col-md-3 mt-3 login">
        ¿No tienes una cuenta? <a href="register.php">Registrate</a>
    </div>
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