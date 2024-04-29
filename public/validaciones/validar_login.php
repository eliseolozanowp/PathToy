<?php
// Incluir el archivo de conexión a la base de datos
include_once('../../config/database.php');

// Inicializar un array para almacenar mensajes de error
$errores = array();

// Validar campos vacíos
if (empty($_POST['correo']) || empty($_POST['contrasena'])) {
    $errores[] = "Debes rellenar todos los campos para continuar.";
}

// Validar el correo
$correo = $_POST['correo'];
$sql = "SELECT idUsuario, correo, contrasena FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $errores[] = "El correo ingresado no está registrado.";
} else {
    // Obtener el registro de usuario de la base de datos
    $usuario = $result->fetch_assoc();
    $contrasena = $_POST['contrasena'];

    // Verificar la contraseña
    if (!password_verify($contrasena, $usuario['contrasena'])) {
        $errores[] = "La contraseña no es correcta.";
    }
}

// Si hay errores, redirigir a login.php con los mensajes de error
if (!empty($errores)) {
    session_start();
    $_SESSION['errores'] = $errores;
    header("Location: ../login.php");
    exit();
}

// Si no hay errores, iniciar sesión y redirigir a otra página (por ejemplo, el perfil del usuario)
// Agrega aquí el código para iniciar la sesión del usuario
// Si no hay errores, iniciar sesión y redirigir al usuario
if (empty($errores)) {
    // Iniciar una nueva sesión
    session_start();

    // Almacenar la información del usuario en la sesión (puedes agregar más datos según tus necesidades)
    $_SESSION['idUsuario'] = $usuario['idUsuario'];
    $_SESSION['correo'] = $usuario['correo'];

    // Redirigir al usuario a la página deseada (por ejemplo, feed.php)
    header("Location: ../../private/feed.php");
    exit();
}

?>