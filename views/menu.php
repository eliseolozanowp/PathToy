<?php
// Verificar si el usuario ha iniciado sesión
$usuarioIniciado = isset($_SESSION['idUsuario']);

if ($usuarioIniciado) {
    // Menú para usuario autenticado
    echo '<nav class="sidebar close">';
    echo '<header>';
    echo '<div class="image-text">';
    echo '<span class="image"><!--<img src="logo.png" alt="">--></span>';
    echo '<div class="text logo-text"><span class="name">PathToy</span></div>';
    echo '</div>';
    echo '<i class="bx bx-chevron-right toggle"></i>';
    echo '</header>';

    echo '<div class="menu-bar">';
    echo '<div class="menu">';

    echo '<li class="nav-link"><a href="/webexample/private/feed.php"><i class="bx bx-home icon"></i><span class="text nav-text">Inicio</span></a></li>';
    echo '<li class="nav-link"><a href="/webexample/private/search.php"><i class="bx bx-search icon"></i><span class="text nav-text">Buscar</span></a></li>';
    echo '<li class="nav-link"><a href="/webexample/private/publicar.php"><i class="bx bx-edit icon"></i><span class="text nav-text">Publicar</span></a></li>';

    echo '</div>';

    echo '<div class="bottom-content">';

    echo '<li class="nav-link"><a href="/webexample/private/perfil.php"><i class="bx bx-id-card icon"></i><span class="text nav-text">Perfil</span></a></li>';
    echo '<li class="nav-link"><a href="/webexample/private/users.php"><i class="bx bx-chat icon"></i><span class="text nav-text">Chat</span></a></li>';
    // echo '<li class="nav-link"><a href="/webexample/private/historial.php"><i class="bx bx-history icon"></i><span class="text nav-text">Historial</span></a></li>';
    echo '<li class="nav-link"><a href="/webexample/private/validaciones/logout.php"><i class="bx bx-log-out icon"></i><span class="text nav-text">Cerrar Sesióm</span></a></li>';

    echo '</div>';
    echo '</div>';
    echo '</nav>';
} else {
    // Menú para usuario no autenticado
    echo '<nav class="sidebar close">';
    echo '<header>';
    echo '<div class="image-text">';
    echo '<span class="image"><!--<img src="logo.png" alt="">--></span>';
    echo '<div class="text logo-text"><span class="name">PathToy</span></div>';
    echo '</div>';
    echo '<i class="bx bx-chevron-right toggle"></i>';
    echo '</header>';

    echo '<div class="menu-bar">';
    echo '<div class="menu">';

    echo '<li class="nav-link"><a href="/webexample/index.php"><i class="bx bx-home icon"></i><span class="text nav-text">Inicio</span></a></li>';
    echo '<li class="nav-link"><a href="/webexample/public/login.php"><i class="bx bx-log-in icon"></i><span class="text nav-text">Iniciar Sesión</span></a></li>';
    echo '<li class="nav-link"><a href="/webexample/public/register.php"><i class="bx bx-user-plus icon"></i><span class="text nav-text">Registrarse</span></a></li>';

    echo '</div>';
    echo '</div>';
    echo '</nav>';
}
?>