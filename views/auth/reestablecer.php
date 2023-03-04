<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?? ''; ?></h2>
    <p class="auth__texto"><?php echo (!empty($usuario)) ? 'Coloca tu nueva contraseña' : '' ?></p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php if (!empty($usuario)) : ?>
        <form class="formulario" method="POST">
            <div class="formulario__campo">
                <label for="password" class="formulario__label">Nueva Contraseña</label>
                <input type="password" class="formulario__input" placeholder="Ingresa tu Contraseña" id="password" name="password" />
            </div><!-- -formulario__campo -->

            <div class="formulario__campo">
                <label for="password2" class="formulario__label">Repetir Contraseña</label>
                <input type="password" class="formulario__input" placeholder="Repite tu Contraseña" id="password2" name="password2" />
            </div><!-- -formulario__campo -->

            <input type="submit" class="formulario__submit" value="Cambiar contraseña">
        </form>
    <?php endif; ?>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obetener una</a>
    </div>
</main> <!-- .auth -->