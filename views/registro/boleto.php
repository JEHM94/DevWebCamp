<main class="boletos">
    <h2 class="boletos__heading"><?php echo $titulo; ?></h2>
    <?php if ($registro->usuario_id === $_SESSION['id']) : ?>
        <p class="boletos__descripcion">Bienvenido/a <?php echo $registro->usuario->nombre; ?>, este es tu boleto para asistir a DevWebCamp</p>
    <?php else : ?>
        <p class="boletos__descripcion">Boleto de asistencia a DevWebCamp</p>
    <?php endif; ?>

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
    <?php if ($registro->paquete_id === "3" && $registro->usuario_id === $_SESSION['id']) : ?>
        <div class="boletos__renovar">
            <p class="boletos__actualizar-pase">¡Aún puedes actualizar tu boleto a Presencial/Virtual y obtener todos los Beneficios incluidos!</p>
            <a href="/finalizar-registro" class="boletos__enlace">Actualizar Boleto</a>
        </div><!-- boletos__renovar -->

    <?php endif; ?>
</main>