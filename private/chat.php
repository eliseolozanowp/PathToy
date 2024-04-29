<?php
session_start();
include_once "../config/database.php";
if (!isset($_SESSION['idUsuario'])) {
    header("location: ../public/login.php");
}

?>
<?php include_once "../views/head.php"; ?>

<head>
    <link rel="stylesheet" href="../assets/css/chat.css">
</head>

<body>
    <center>
        <div class="wrapper">
            <section class="chat-area">
                <header>
                    <?php
                    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                    $sql = mysqli_query($conn, "SELECT * FROM usuarios WHERE idUsuario = {$user_id}");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    } else {
                        header("location: users.php");
                    }
                    ?>
                    <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                    <div class="details">
                        <span>
                            <?php echo $row['nombre'] . " " . $row['apellido']; ?>
                        </span>
                        <p>
                        </p>
                    </div>
                </header>
                <div class="chat-box">

                </div>
                <form action="#" class="typing-area">
                    <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                    <input type="text" name="message" class="input-field" placeholder="Escribe un mensaje aquí..."
                        autocomplete="off">
                    <button><i class="fab fa-telegram-plane"></i></button>
                </form>
            </section>
        </div>
    </center>

    <script src="../assets/js/chat.js"></script>
</body>

</html>