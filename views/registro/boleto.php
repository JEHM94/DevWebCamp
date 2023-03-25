<main class="boletos">
    <h2 class="boletos__heading"><?php echo $titulo; ?></h2>
    <p class="boletos__descripcion">Bienvenido <?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido; ?>, este es tu boleto para asistir a DevWebCamp</p>

    <div class="boleto-virtual">
        <div class="boleto boleto--<?php echo strtolower($registro->paquete->nombre); ?> boleto--acceso">
            <div class="boleto__contenido">
                <h4 class="boleto__logo">&#60;DevWebcamp/></h4>
                <p class="boleto__plan">Pase <?php echo $registro->paquete->nombre; ?></p>
                <p class="boleto__nombre"><?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido; ?></p>
            </div><!-- .boleto__contenido -->

            <p class="boleto__codigo"><?php echo "#" . $registro->token; ?></p>


        </div><!-- .boleto boleto--xx -->
    </div><!-- boleto -->
</main>