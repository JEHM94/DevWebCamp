<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if (empty($_SESSION['login'])) : ?>
                <a href="/registro" class="header__enlace">Registro</a>
                <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php else : ?>
                <a href="<?php echo ($_SESSION['admin']) ? '/admin/dashboard' : '/finalizar-registro'; ?>" class="header__enlace">Administrar</a>
                <form action="/logout" method="POST" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php endif; ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">
                    &#60;DevWebcamp/>
                </h1>
            </a>

            <p class="header__texto">Enero 06 y 07, 2023</p>
            <p class="header__texto header__texto--modalidad">En línea - Presencial</p>

            <a href="/registro" class="header__boton">Comprar Pase</a>

        </div><!-- .header_contenido -->

    </div><!-- .header__contenedor -->
</header>

<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">&#60;DevWebcamp/></h2>
        </a>
        <nav class="navegacion">
            <a href="/devwebcamp" class="navegacion__enlace <?php echo paginaActual('/devwebcamp') ? 'navegacion__enlace--actual' : ''; ?>">Evento</a>
            <a href="/paquetes" class="navegacion__enlace <?php echo paginaActual('/paquetes') ? 'navegacion__enlace--actual' : ''; ?>">Paquetes</a>
            <a href="/workshops-conferencias" class="navegacion__enlace <?php echo paginaActual('/workshops-conferencias') ? 'navegacion__enlace--actual' : ''; ?>">Workshops / Conferencias</a>
            <a href="/registro" class="navegacion__enlace <?php echo paginaActual('/registro') ? 'navegacion__enlace--actual' : ''; ?>">Comprar Pase</a>
        </nav>
    </div><!-- .barra__contenido -->
</div><!-- .barra -->