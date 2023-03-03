<main class="auth">

    <h2 class="auth__heading"><?php echo $titulo ?? ''; ?></h2>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <div class="auth__boton">
        <a class="auth__boton--enlace" href="<?php echo isset($alertas['exito']) ? '/login' : '/'; ?>">
            <?php echo isset($alertas['exito']) ? 'Iniciar Sesión' : 'Volver'; ?>
        </a>
    </div>

</main>