<?php
session_start();

// Acceder a los datos de la sesión
$idUsuario = $_SESSION['idUsuario'];
$correo = $_SESSION['correo'];

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    // Si el usuario no ha iniciado sesión, puedes redirigirlo a la página de inicio de sesión o mostrar un mensaje de error.
    header("Location: ../public/login.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');
?>

<?php include_once '../views/head.php'; ?>

<?php
// Obtener los datos del usuario desde la base de datos (reemplaza 'tabla_usuarios' con el nombre de tu tabla de usuarios)
$sql = "SELECT * FROM usuarios WHERE idUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['idUsuario']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $correo = $row['correo'];
} else {
    $nombre = "";
    $apellido = "";
    $correo = "";
    $fotoPerfil = null;
}
$conn->close();
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores actualizados del formulario
    $nuevoNombre = $_POST['nombre'];
    $nuevoApellido = $_POST['apellido'];
    $nuevoCorreo = $_POST['correo'];

    // Verificar si se realizaron modificaciones
    if ($nuevoNombre != $nombre || $nuevoApellido != $apellido || $nuevoCorreo != $correo) {
        // Verificar si hay campos vacíos
        if (!empty($nuevoNombre) && !empty($nuevoApellido) && !empty($nuevoCorreo)) {
            // Realizar la actualización en la base de datos
            $conn = new mysqli($servername, $username, $password, $database);
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }

            // Actualizar nombre y apellido
            $sql = "UPDATE usuarios SET nombre='$nuevoNombre', apellido='$nuevoApellido' WHERE idUsuario = $idUsuario";
            if ($conn->query($sql) === TRUE) {
                // Actualización exitosa

                // // Manejar la carga de la nueva foto de perfil si se selecciona una
                // if ($_FILES['userfile']['name']) {
                //     $imageData = file_get_contents($_FILES['userfile']['tmp_name']);
                //     $imageType = $_FILES['userfile']['type'];

                //     // Actualizar la imagen de perfil en la base de datos
                //     $sql = "UPDATE usuarios SET foto_perfil=?, foto_tipo=? WHERE correo='$usuario'";
                //     $stmt = $conn->prepare($sql);
                //     $stmt->bind_param("ss", $imageData, $imageType);

                //     if ($stmt->execute()) {
                //         echo "La foto de perfil se ha actualizado con éxito.";
                //     } else {
                //         echo "Error al actualizar la foto de perfil: " . $conn->error;
                //     }
                // }

                // Redirigir a la página de perfil nuevamente
                header("Location: perfil.php?mensaje=actualizado");
                exit();
            } else {
                echo "Error al actualizar los datos: " . $conn->error;
            }

            $conn->close();
        } else {
            // Campos vacíos, mostrar mensaje de error
            header("Location: perfil.php?mensaje=campos_vacios");
            exit();
        }
    } else {
        // No se realizaron modificaciones, mostrar mensaje de error
        header("Location: perfil.php?mensaje=sin_modificaciones");
        exit();
    }
}

?>

<head>
    <link rel="stylesheet" href="/PathToy/asset/css/perfil.css">
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const mensaje = document.querySelector('.mensaje');
            if (mensaje) {
                setTimeout(() => {
                    mensaje.style.display = 'none';
                }, 2500);
            }
        });
    </script>
</head>

<body>
    <div class="background">
        <div class="perfil-form">
            <h1 class="titulo">Información del Usuario</h1>
            <div id="cameraImage" class="perfil-logo">
                <img class="camera" src="/PathToy/asset/img/camara.png" alt="Camara">
            </div>
            <a href="#" class="editar-info">Editar Información</a>

            <form id="form-perfil" action="perfil.php" method="POST" class="form-perfil" enctype="multipart/form-data">
                <input type="text" id="nombre" name="nombre" class="input-perfil" value="<?php echo $nombre; ?>"
                    readonly>
                <input type="text" id="apellido" name="apellido" class="input-perfil" value="<?php echo $apellido; ?>"
                    readonly>
                <input type="email" id="correo" name="correo" class="input-perfil" value="<?php echo $correo; ?>"
                    readonly>
                <button type="submit" id="btn-actualizar" class="btn-actualizar"><b>Actualizar Cambios</b></button>
                <button type="button" id="btn-cancelar" class="btn-cancelar"
                    onclick="cancelarEdicion()"><b>Cancelar</b></button>
            </form>


            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === "campos_vacios"): ?>
                <div class="mensaje">Rellene todos los campos antes de actualizar</div>
            <?php elseif (isset($_GET['mensaje']) && $_GET['mensaje'] === "actualizado"): ?>
                <div class="mensaje">Datos actualizados correctamente</div>
            <?php elseif (isset($_GET['mensaje']) && $_GET['mensaje'] === "sin_modificaciones"): ?>
                <div class="mensaje">Debes editar los datos antes de actualizar</div>
            <?php endif; ?>
        </div>
        <div class="perfil-form form-perfil">
            <h1 class="titulo">Estadisticas</h1>
            <a href="historial.php">
                <button type="text" id="intercambios" name="intercambios" class="input-perfil"> <b>Mis publicaciones</b>
                </button>
            </a>

        </div>
    </div>
</body>

<?php include_once '../views/footer.php'; ?>