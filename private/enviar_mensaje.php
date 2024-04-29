<?php
session_start();

if (isset($_POST['mensaje'])) {
    // Aquí puedes guardar el mensaje en la base de datos o realizar la lógica necesaria
    // Reemplaza este ejemplo con tu lógica real para guardar mensajes
    $mensaje = $_POST['mensaje'];
    // Guarda el mensaje en la base de datos o realiza cualquier otra acción

    // Puedes responder con un mensaje de éxito si es necesario
    echo 'Mensaje enviado con éxito';
} else {
    // Si no se proporciona un mensaje válido, responde con un mensaje de error
    echo 'Error al enviar el mensaje';
}
?>