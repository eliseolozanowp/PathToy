<?php
session_start();
include_once "../../config/database.php";
$idUsuario = $_SESSION['idUsuario'];

// Obtener la lista de usuarios con los que ha chateado
$sql = "SELECT DISTINCT usuarios.idUsuario, usuarios.nombre, usuarios.apellido
        FROM usuarios
        JOIN messages ON (usuarios.idUsuario = messages.incoming_msg_id OR usuarios.idUsuario = messages.outgoing_msg_id)
        WHERE (messages.incoming_msg_id = $idUsuario OR messages.outgoing_msg_id = $idUsuario) AND usuarios.idUsuario != $idUsuario
        ORDER BY usuarios.idUsuario DESC";

$query = mysqli_query($conn, $sql);
$output = "";

if (mysqli_num_rows($query) == 0) {
    $output .= "No se encontraron conversaciones";
} elseif (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        // Aquí puedes personalizar cómo deseas mostrar cada usuario en tu lista
        $output .= '<div class="user-item">';
        $output .= '<h3>' . $row['nombre'] . ' ' . $row['apellido'] . '</h3>';
        $output .= '<a href="chat.php?user_id=' . $row['idUsuario'] . '">Ver Chat</a>';
        $output .= '</div>';
    }
}

echo $output;
?>