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

<head>
    <style>
        .card-image img {
            width: 200px;
            /* Ancho deseado */
            height: 250px;
            /* Altura automática para mantener la proporción */
        }
    </style>
    <link rel="stylesheet" href="/webexample/assets/css/panel.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <form id="searchForm" class="search-form">
        <div style="display: flex; align-items: center;">
            <input type="text" name="q" placeholder="Buscar..." style="flex: 1;">
            <button class="bx bx-search icon" type="button" id="advancedSearch">Búsqueda filtrada</button>
            <button class="bx bx-search icon" type="button" id="busquedaTexto">Búsqueda por texto</button>
        </div>

        <div class="selectors" id="selectors" style="display: none;">
            <select id="tipo_publicacion" name="tipo_publicacion">
                <option value="">Tipo de publicación</option>
                <option value="Intercambio">Intercambio</option>
                <option value="Petición">Petición</option>
                <option value="Donación">Donación</option>
            </select>

            <select id="edad" name="edad">
                <option value="">Edad</option>
                <option value="1">1 año</option>
                <option value="2">2 años</option>
                <option value="3">3 años</option>
                <option value="4">4 años</option>
                <option value="5">5 años</option>
                <option value="6">6 años</option>
                <option value="7">7 años</option>
                <option value="8">8 años</option>
                <option value="9">9 años</option>
                <option value="10">10 años</option>
                <option value="11">11 años</option>
                <option value="12">12 años</option>
                <option value="13">13 años</option>
                <option value="14">14 años</option>
                <option value="15">15 años</option>
                <option value="16">16 años</option>
                <option value="17">17 años</option>
                <option value="18-99">18+ años</option>
                <!-- ... Otras opciones de edad ... -->
            </select>

            <select id="habilidad" name="habilidad">
                <option value="">Habilidades</option>
                <option value="Habilidades Motoras">Motoras</option>
                <option value="Habilidades Cognitivas">Cognitivas</option>
                <option value="Habilidades Linguísticas">Linguísticas</option>
            </select>
        </div>
    </form>

    <h2 class="centered-title">Publicaciones que te pueden interesar</h2>
    <section id="publicaciones">
        <div id="cardContainer" class="card-container">
            <?php
            // Incluir el archivo de conexión a la base de datos
            include_once('../config/database.php');

            // Aquí realizas una consulta basada en los parámetros de búsqueda
            // y obtienes los resultados de la base de datos
            $sql = "SELECT idPublicacion, tipoPublicacion, descripcion, habilidadRequerida, edadRecomendada, fechaRegistro, usuarioId FROM publicaciones";
            $resultado = $conn->query($sql);

            // Verificar si se obtuvieron resultados
            if ($resultado->num_rows > 0) {
                echo '<div class="card-container">';
                // Mostrar las publicaciones
                while ($fila = $resultado->fetch_assoc()) {
                    $fechaRegistro = $fila['fechaRegistro'];
                    $fecha = date_create($fechaRegistro);
                    $meses = array(
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    );
                    $mes = $meses[(date_format($fecha, 'n') - 1)];
                    $hora = date_format($fecha, 'H');
                    $minuto = date_format($fecha, 'i');
                    $fechaFormateada = date_format($fecha, 'd') . " de " . $mes . " - " . date_format($fecha, 'Y');
                    $horaFormateada = $hora . ":" . $minuto;
                    // Agrega las clases a las tarjetas de publicaciones
                    echo '<div class="card">';
                    echo '<p style="text-align: right;">' . $fechaFormateada . /*' <br> ' . $horaFormateada .*/'</p>';
                    echo '<div class="card-image">';
                    // echo '<img src="data:image/jpeg;base64,' . $row['imagen_producto'] . '" alt="Imagen del producto">';
                    echo '</div>';
                    echo '<div class="card-content">';
                    echo '<h3 class="campo-editable">' . $fila['tipoPublicacion'] . '</h3>';
                    echo '<p> <span class="campo-editable">' . $fila['descripcion'] . '</span></p>';
                    echo '<p> <span class="campo-editable">' . $fila['edadRecomendada'] . '</span></p>';
                    echo '<p> <span class="campo-editable">' . $fila['habilidadRequerida'] . '</span></p>';
                    echo '</div>';

                    echo '<div class="card-botones">';
                    // Agregar enlace "Ver" con el ID de la publicación
                    echo '<a class="btn-ver" href="publicacion.php?id=' . $fila['idPublicacion'] . '">Ver más</a>';
                    echo '</div>';
                    echo '</div>';
                    echo "<br>";
                }
            } else {
                // Si no hay publicaciones, muestra el mensaje
                echo '<p class="no-publications-message">No hay publicaciones disponibles.</p>';
            }
            echo '</div>';

            $conn->close();
            ?>
        </div>
    </section>
    <script>
        // Función para realizar la búsqueda automáticamente
        function realizarBusqueda() {
            // Obtén los valores del formulario
            var formData = $('#searchForm').serialize();

            // Realiza la petición AJAX
            $.ajax({
                url: 'buscar_ajax.php',
                type: 'GET',
                data: formData,
                success: function (response) {
                    $('#cardContainer').html(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Función para mostrar la búsqueda por texto
        function mostrarBusquedaTexto() {
            $('#selectors').hide();
            $('#advancedSearch').show(); // Muestra el botón "Búsqueda filtrada"
            $('input[name="q"]').show();
            $('#busquedaTexto').hide();
        }

        // Función para mostrar la búsqueda filtrada
        function mostrarBusquedaFiltrada() {
            $('#selectors').show();
            $('#advancedSearch').hide(); // Oculta el botón "Búsqueda filtrada"
            $('input[name="q"]').hide();
            $('#busquedaTexto').show();
        }

        // Captura el evento de entrada en los campos de búsqueda
        $('#searchForm input, #searchForm select').on('input', function () {
            realizarBusqueda();
        });

        // Muestra los selectores
        document.addEventListener("DOMContentLoaded", function () {
            const filterButton = document.getElementById("advancedSearch");

            filterButton.addEventListener("click", function () {
                if ($('#selectors').is(':visible')) {
                    mostrarBusquedaTexto();
                } else {
                    mostrarBusquedaFiltrada();
                }
            });
            // Inicialmente muestra la búsqueda por texto
            mostrarBusquedaTexto();
        });

        // Captura el evento de clic en "Búsqueda por texto"
        $('#busquedaTexto').click(function () {
            mostrarBusquedaTexto();
        });

        // Captura el evento de clic en "Búsqueda filtrada"
        $('#busquedaFiltrada').click(function () {
            mostrarBusquedaFiltrada();
        });

        // Realiza la búsqueda inicial al cargar la página
        realizarBusqueda();
    </script>
</body>

<?php include_once '../views/footer.php'; ?>