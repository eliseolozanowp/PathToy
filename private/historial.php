<?php
session_start();

// Acceder a los datos de la sesión
$idUsuario = $_SESSION['idUsuario'];
$correo = $_SESSION['correo'];

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    // Si el usuario no ha iniciado sesión, puedes redirigirlo a la página de inicio de sesión o mostrar un mensaje de error.
    header("Location: ../public/login.php");
    exit();
}
?>

<?php include_once '../views/head.php'; ?>

<?php
// Incluir el archivo de conexión a la base de datos
include_once('../config/database.php');

// Consultas SQL para obtener el número de publicaciones por tipo
// Consultas SQL para obtener el número de publicaciones por tipo para el usuario actual
$sqlIntercambios = "SELECT COUNT(*) as total_intercambios FROM publicaciones WHERE tipoPublicacion = 'intercambio' AND usuarioId = $idUsuario";
$sqlPeticiones = "SELECT COUNT(*) as total_peticiones FROM publicaciones WHERE tipoPublicacion = 'peticion' AND usuarioId = $idUsuario";
$sqlDonaciones = "SELECT COUNT(*) as total_donaciones FROM publicaciones WHERE tipoPublicacion = 'donacion' AND usuarioId = $idUsuario";

$resultIntercambios = $conn->query($sqlIntercambios);
$resultPeticiones = $conn->query($sqlPeticiones);
$resultDonaciones = $conn->query($sqlDonaciones);

// Obtén el número de publicaciones por tipo
$numeroDeIntercambios = 0;
$numeroDePeticiones = 0;
$numeroDeDonaciones = 0;

if ($resultIntercambios->num_rows > 0) {
    $row = $resultIntercambios->fetch_assoc();
    $numeroDeIntercambios = $row["total_intercambios"];
}

if ($resultPeticiones->num_rows > 0) {
    $row = $resultPeticiones->fetch_assoc();
    $numeroDePeticiones = $row["total_peticiones"];
}

if ($resultDonaciones->num_rows > 0) {
    $row = $resultDonaciones->fetch_assoc();
    $numeroDeDonaciones = $row["total_donaciones"];
}

// // Realizar una consulta SQL para obtener las publicaciones del usuario actual (reemplaza 'tabla_publicaciones' por el nombre de tu tabla)
// $sql = "SELECT * FROM publicaciones WHERE usuarioId = ? ORDER BY fechaRegistro DESC"; // Puedes ajustar el orden según tus necesidades

// // Preparar la consulta
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $idUsuario);
// $stmt->execute();

// // Obtener los resultados de la consulta
// $resultado = $stmt->get_result();

// // Verificar si se obtuvieron resultados
// if ($resultado->num_rows > 0) {
//     echo '<br>';
//     echo '<h2>Historial</h2>';
//     // Mostrar las publicaciones y agregar botones de "Editar" y "Eliminar"
//     while ($fila = $resultado->fetch_assoc()) {
//         // Agrega las clases a las tarjetas de historial de publicaciones
//         echo '<div class="card-historial">';
//         echo "<h3>" . $fila['tipoPublicacion'] . "</h3>";
//         echo "<p><b>Descripción:</b> " . $fila['descripcion'] . "</p>";
//         echo "<p><b>Habilidad(es):</b> " . $fila['habilidadRequerida'] . "</p>";
//         echo "<p><b>Edad:</b> " . $fila['edadRecomendada'] . "</p>";

//         // Agrega botones de "Editar" y "Eliminar" para cada publicación
//         echo '<a href="editar_publicacion.php?id=' . $fila['idPublicacion'] . '" class="btn-editar">Editar</a>';
//         // Agregar enlace de "Eliminar" con JavaScript para confirmación
//         echo '<a href="#" class="btn-eliminar" onclick="confirmarEliminar(' . $fila['idPublicacion'] . ');">Eliminar</a>';

//         // Agrega más detalles de la publicación según tus necesidades
//         echo '</div>'; // Cierra la tarjeta de historial de publicación
//     }
// } else {
//     // Si no hay publicaciones, muestra el mensaje
//     echo '<p class="no-publications-message">No hay publicaciones en tu historial.</p>';
// }

// // Cerrar la conexión a la base de datos
// $stmt->close();
// $conn->close();
?>

<head>
    <style>
        /* Estilos personalizados para la página */
        .fondo-login {
            background-color: #b8e4ff;
            padding: 20px;
        }

        .dash-count {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .dash-count h5 {
            font-size: 14px;
            color: #777;
        }

        .dash-count h4 {
            font-size: 28px;
            color: #333;
            margin-top: 10px;
        }

        .dash-imgs i {
            font-size: 40px;
            color: #007BFF;
        }

        .historial-heading {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .historial-list {
            list-style: none;
            padding: 0;
        }

        .historial-list-item {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .historial-list-item img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }

        .historial-list-item h3 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }

        .historial-list-item p {
            font-size: 14px;
            color: #777;
        }

        .btn-editar {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn-eliminar {
            display: inline-block;
            padding: 5px 10px;
            background-color: #ff3333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .no-publications-message {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<div class="fondo-login">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h5>Mis Intercambios</h5>
                        <h4>
                            <?php echo $numeroDeIntercambios; ?>
                        </h4>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h5>Mis Peticiones</h5>
                        <h4>
                            <?php echo $numeroDePeticiones; ?>
                        </h4>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h5>Mis Donaciones</h5>
                        <h4>
                            <?php echo $numeroDeDonaciones; ?>
                        </h4>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
        <div class="row">
            <div class="col-12">
                <h2 class="historial-heading">Historial de publicaciones</h2>
            </div>
        </div>
        <br>
        <div class="historial-list">
            <?php
            // Consulta SQL para obtener las publicaciones
            $sqlPublicaciones = "SELECT * FROM publicaciones WHERE usuarioId = $idUsuario";
            $resultPublicaciones = $conn->query($sqlPublicaciones);

            if ($resultPublicaciones->num_rows > 0) {
                while ($row = $resultPublicaciones->fetch_assoc()) {
                    $imagen = $row["imagenProducto"]; // Reemplaza "imagen" con el nombre de tu columna de imagen
                    $descripcion = $row["descripcion"]; // Reemplaza "descripcion" con el nombre de tu columna de descripción
                    $tipoPublicacion = $row["tipoPublicacion"]; // Reemplaza "tipo_publicacion" con el nombre de tu columna de tipo de publicación
                    $habilidades = $row["habilidadRequerida"]; // Reemplaza "tipo_publicacion" con el nombre de tu columna de tipo de publicación
                    $edad = $row["edadRecomendada"]; // Reemplaza "tipo_publicacion" con el nombre de tu columna de tipo de publicación
                    $publicacionID = $row["idPublicacion"]; // Reemplaza "id" con el nombre de tu columna de identificación de publicación
            
                    echo '<li class="historial-list-item">';
                    echo '<div class="row">';
                    echo '<div class="col-4"><img src="data:image/jpeg;base64,' . $imagen . '" alt="Foto de perfil"></div>';
                    echo '<div class="col-8">';
                    echo '<h3>' . $descripcion . '</h3>';
                    echo '<p><b>Tipo de Publicación:</b> ' . $tipoPublicacion . '</p>';
                    echo '<p><b>Habilidad(es) requerida(s):</b> ' . $habilidades . '</p>';
                    echo '<p><b>Edad Recomendada:</b> ' . $edad . '</p>';
                    echo '<a href="editar_publicacion.php?id=' . $row['idPublicacion'] . '" class="btn-editar">Editar</a>';
                    echo '<a href="eliminar_publicacion.php?id=' . $publicacionID . '" class="btn-eliminar" onclick="return confirm(\'¿Estás seguro de eliminar esta publicación?\');">Eliminar</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                    echo '<br>';
                }
            } else {
                echo '<li class="historial-list-item">No hay publicaciones disponibles</li>';
            }
            ?>
        </div>
        <?php
        $conn->close(); // Cierra la conexión a la base de datos después de mostrar las publicaciones
        ?>
    </div>

</div>

<?php include_once '../views/footer.php'; ?>