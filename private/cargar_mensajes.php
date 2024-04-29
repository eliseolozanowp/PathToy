<?php
session_start();

// Aquí puedes realizar una consulta a la base de datos para obtener los mensajes
// Reemplaza este ejemplo con tu lógica real para obtener los mensajes
$mensajes = [
    ['usuario' => 'Usuario1', 'mensaje' => 'Hola'],
    ['usuario' => 'Usuario2', 'mensaje' => '¡Hola!'],
    // Agrega más mensajes desde tu base de datos
];

// Genera el HTML para mostrar los mensajes
$htmlMensajes = '';
foreach ($mensajes as $mensaje) {
    $htmlMensajes .= '<div><strong>' . $mensaje['usuario'] . ':</strong> ' . $mensaje['mensaje'] . '</div>';
}

echo $htmlMensajes;
?>