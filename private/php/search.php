<?php
session_start();
include_once "../../config/database.php";

$outgoing_id = $_SESSION['idUsuario'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql = "SELECT * FROM usuarios WHERE NOT idUsuario = {$outgoing_id} AND (nombre LIKE '%{$searchTerm}%' OR apellido LIKE '%{$searchTerm}%') ";
$output = "";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    include_once "data.php";
} else {
    $output .= 'No se ha encontrado ningún usuario relacionado con su término de búsqueda';
}
echo $output;
?>