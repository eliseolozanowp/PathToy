<?php
session_start();
if (isset($_SESSION['idUsuario'])) {
    include_once "../../config/database.php";
    $outgoing_id = $_SESSION['idUsuario'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    if (!empty($message)) {
        $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                    VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die(mysqli_error($conn));
        if ($sql) {
            echo "Mensaje enviado correctamente"; // Puedes personalizar este mensaje de éxito
        } else {
            echo "Error al enviar el mensaje"; // Puedes personalizar este mensaje de error
        }
    } else {
        echo "El mensaje está vacío"; // Puedes personalizar este mensaje si el mensaje está vacío
    }
} else {
    header("location: ../../public/login.php");
}
?>