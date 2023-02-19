<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?? ''; ?></h2>
    <p class="auth__texto">Ingresa los datos a continuación</p>

    <form class="formulario">
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input type="text" class="formulario__input" placeholder="Ingresa tu Nombre" id="nombre" name="nombre" />
        </div><!-- -formulario__campo -->

        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido</label>
            <input type="text" class="formulario__input" placeholder="Ingresa tu Apellido" id="apellido" name="apellido" />
        </div><!-- -formulario__campo -->

        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" class="formulario__input" placeholder="Ingresa tu Email" id="email" name="email" />
        </div><!-- -formulario__campo -->

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Contraseña</label>
            <input type="password" class="formulario__input" placeholder="Ingresa tu Contraseña" id="password" name="password" />
        </div><!-- -formulario__campo -->

        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir Contraseña</label>
            <input type="password" class="formulario__input" placeholder="Repite tu Contraseña" id="password2" name="password2" />
        </div><!-- -formulario__campo -->

        <input type="submit" class="formulario__submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Contraseña?</a>

    </div>
</main> <!-- .auth -->