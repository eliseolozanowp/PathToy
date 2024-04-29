<?php
// Incluir el archivo de conexión a la base de datos
include_once('../../config/database.php');

// Inicializar un array para almacenar mensajes de error
$errores = array();

// Validar campos vacíos
if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['genero']) || empty($_POST['correo']) || empty($_POST['contrasena']) || empty($_POST['repetir_contrasena'])) {
    $errores[] = "Debes rellenar todos los campos para continuar.";
}

// Validar si el correo ya está registrado (sustituye 'tabla_usuarios' por el nombre de tu tabla de usuarios)
$correo = $_POST['correo'];
$sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $errores[] = "El correo ingresado ya está registrado.";
}

// Validar el dominio del correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/i", $correo)) {
    $errores[] = "El correo debe estar en dominio @gmail.com.";
}

// Validar contraseñas iguales
if ($_POST['contrasena'] !== $_POST['repetir_contrasena']) {
    $errores[] = "Las contraseñas no coinciden.";
}

// Validar longitud de la contraseña
if (strlen($_POST['contrasena']) < 8) {
    $errores[] = "La contraseña debe ser mayor a 8 caracteres.";
}

// Si hay errores, redirigir a register.php con los mensajes de error
if (!empty($errores)) {
    session_start();
    $_SESSION['errores'] = $errores;
    header("Location: ../register.php");
    exit();
}

// Si no hay errores, insertar el registro en la base de datos y redirigir a otra página
// Agrega aquí el código para insertar los datos en la base de datos
// Si no hay errores, insertar el registro en la base de datos
if (empty($errores)) {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $genero = $_POST['genero'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hash de la contraseña

    // Consulta SQL para insertar el registro en la tabla de usuarios (reemplaza 'tabla_usuarios' por el nombre de tu tabla)
    $sql = "INSERT INTO usuarios (nombre, apellido, genero, correo, contrasena) VALUES (?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("sssss", $nombre, $apellido, $genero, $correo, $contrasena);
    if ($stmt->execute()) {
        // Registro exitoso, redirigir a login.php
        session_start();
        $_SESSION['registro_exitoso'] = true;
        header("Location: ../login.php");
        exit();
    } else {
        // Error al insertar el registro
        $errores[] = "Error al registrar el usuario. Por favor, inténtalo de nuevo.";
    }

    // Cerrar la declaración
    $stmt->close();
}

?>