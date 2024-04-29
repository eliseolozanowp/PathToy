<?php
session_start();
// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');
// Acceder a los datos de la sesión
$idUsuario = $_SESSION['idUsuario'];
$correo = $_SESSION['correo'];

if (!isset($_SESSION['idUsuario'])) {
    header("location: ../public/login.php");
}
?>
<?php include_once '../views/head.php'; ?>

<head>
    <link rel="stylesheet" href="/webexample/assets/css/chat.css">
</head>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <?php
                    $idUsuario = $_SESSION['idUsuario'];
                    $sql = mysqli_query($conn, "SELECT * FROM usuarios WHERE idUsuario = {$idUsuario}");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                    ?>
                    <div class="details">
                        <span>
                            <?php echo $row['nombre'] . " " . $row['apellido']; ?>
                        </span>
                    </div>
                </div>
            </header>
            <div class="search">
                <span class="text">Seleccione un usuario para iniciar el chat</span>
                <input type="text" placeholder="Introduzca el nombre para buscar...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">

            </div>
        </section>
    </div>

    <script src="../assets/js/users.js"></script>
</body>

</html>
<?php include_once '../views/footer.php'; ?>