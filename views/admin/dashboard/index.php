<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<main class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading">Últimos Registros</h3>
            <?php foreach ($registros as $registro) : ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto"><span class="bloque__texto--bold"><?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido; ?></span> - Paquete <?php echo $registro->paquete->nombre; ?></p>
                </div><!-- .bloque__contenido -->
            <?php endforeach; ?>

        </div><!-- .bloque -->

        <div class="bloque">
            <h3 class="bloque__heading">Ingresos</h3>
            <p class="bloque__texto--cantidad">Presencial: <span class="bloque__texto--bold">$<?php echo $ingresos['presenciales']; ?></span></p>
            <p class="bloque__texto--cantidad">Virtual: <span class="bloque__texto--bold">$<?php echo $ingresos['virtuales']; ?></span></p>
            <p class="bloque__texto--cantidad-total">Total: $<?php echo $ingresos['total']; ?></p>
        </div><!-- .bloque -->

        <div class="bloque">
            <h3 class="bloque__heading">Eventos con Menos Lugares Disponibles</h3>
            <?php foreach ($menos_disponibles as $evento) : ?>
                <div class="bloque__contenido">
                <p class="bloque__texto"><span class='bloque__texto--bold'>
                        <?php echo $evento->nombre . "</span> - " . $evento->disponibles . " Disponibles"; ?>
                    </p>
                </div><!-- .bloque__contenido -->
            <?php endforeach; ?>
        </div><!-- .bloque -->

        <div class="bloque">
            <h3 class="bloque__heading">Eventos con Más Lugares Disponibles</h3>
            <?php foreach ($mas_disponibles as $evento) : ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto"><span class='bloque__texto--bold'>
                        <?php echo $evento->nombre . "</span> - " . $evento->disponibles . " Disponibles"; ?>
                    </p>
                </div><!-- .bloque__contenido -->
            <?php endforeach; ?>
        </div><!-- .bloque -->

    </div><!-- .bloques__grid -->
</main>