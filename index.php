<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['idUsuario'])) {
    // Si el usuario ha iniciado sesión, redirigirlo a la página de feed
    header("Location: /webexample/private/feed.php");
    exit();
}
include_once 'views/head.php';
?>


<section>
    <div class="text-container ">
        <h2 class="text-center">Importancia de los juguetes en el crecimiento de los niños</h2>
        <p class="text-justified">
            Los juguetes son importantes para el crecimiento de los niños, ya que potencian tanto
            sus habilidades motoras como cognitivas. Los juguetes permiten a los niños desarrollar
            su coordinación, equilibrio y fuerza, mientras que los juguetes educativos estimulan
            el pensamiento lógico, la resolución de problemas y la creatividad. Además, el juego
            con juguetes fomenta el desarrollo emocional y social, ya que los niños aprenden a
            compartir, comunicarse y cooperar. Es esencial elegir juguetes apropiados para la edad
            y nivel de desarrollo de los niños, proporcionando un entorno de juego enriquecedor y
            seguro. En resumen, los juguetes son herramientas fundamentales que promueven un crecimiento
            integral en los niños.
        </p>
    </div>

    <div class="video-container">
        <iframe width="800" height="450" src="https://www.youtube.com/embed/9WuBAWMW15g" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>
    </div>

    <div class="attribution">
        <p>
            Video creado por <a href="https://www.youtube.com/@eduardosifredogarciaflores8376" target="_blank">Sifredo
                Flores</a>
        </p>
    </div>
    <div class="Especialistas">
        <div class="Psicologo">
            <h2>Contactos de Especialistas</h2>
        </div>
        <div class="contact-info">
            <h3 class="psico1">Medi Integral</h3>
            <div class="contact-details">
                <div class="numero"><i class="fas fa-phone-alt"></i> Teléfonos:
                    <p>+503 7568 7614 <br>+503 2697 1104</p>
                </div>
                <div class="direccion"><i class="fas fa-map-marker-alt"></i>
                    <a href="https://www.google.com/maps/place/Mediintegral:+Psicologos+El+Salvador+-+Clinica+psicologica/@13.7034521,-89.2453556,21z/data=!4m6!3m5!1s0x8f6330203d7eb3b1:0x1aea82c142487593!8m2!3d13.7034575!4d-89.2453541!16s%2Fg%2F11g6vg2zxz?entry=ttu"
                        target="_blank">Dirección</a>
                </div>
                <div class="psico"><i class="fas fa-globe"></i>
                    <a href="https://www.mediintegral.com.sv/?fbclid=IwAR11qloEOjAgOlo1AkCLJ7r_l9a8f20aDrhHs_xjE6rVfhuQvke-LJOljIs"
                        target="_blank">Sitio Web</a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include_once 'views/footer.php'; ?>