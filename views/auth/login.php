<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?? ''; ?></h2>
    <p class="auth__texto">Inicia sesión en DevWebCamp</p>

    <form class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" class="formulario__input" placeholder="Ingresa tu Email" id="email" name="email" />
        </div><!-- -formulario__campo -->

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Contraseña</label>
            <input type="password" class="formulario__input" placeholder="Ingresa tu Contraseña" id="password" name="password" />
        </div><!-- -formulario__campo -->

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes una cuenta? Obetener una</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Contraseña?</a>

    </div>
</main> <!-- .auth -->