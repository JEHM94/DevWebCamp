<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Personal</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input type="text" class="formulario__input" id="nombre" name="nombre" placeholder="Nombre del Ponente" value="<?php echo $ponente->nombre ?? ''; ?>">
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido</label>
        <input type="text" class="formulario__input" id="apellido" name="apellido" placeholder="Apellido del Ponente" value="<?php echo $ponente->apellido ?? ''; ?>">
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <label for="ciudad" class="formulario__label">Ciudad</label>
        <input type="text" class="formulario__input" id="ciudad" name="ciudad" placeholder="Ciudad del Ponente" value="<?php echo $ponente->ciudad ?? ''; ?>">
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <label for="pais" class="formulario__label">País</label>
        <input type="text" class="formulario__input" id="pais" name="pais" placeholder="País del Ponente" value="<?php echo $ponente->pais ?? ''; ?>">
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen</label>
        <input type="file" class="formulario__input formulario__input--file" id="imagen" name="imagen">
    </div><!-- .formulario__campo -->
</fieldset>


<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>

    <div class="formulario__campo">
        <label for="tags_input" class="formulario__label">Áreas de Experiencia(separadas por coma)</label>
        <input type="text" class="formulario__input" id="tags_input" placeholder="Ej. PHP, Laravel, CSS, HTML, MySQL, SASS">

        <div class="formulario__listado" id="tags"></div>
        <input type="hidden" name="tags" value="<?php echo $ponente->tags ?? ''; ?>">
    </div><!-- .formulario__campo -->
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[facebook]" placeholder="Facebook" value="<?php echo $ponente->facebook ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[twitter]" placeholder="Twitter" value="<?php echo $ponente->twitter ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[youtube]" placeholder="Youtube" value="<?php echo $ponente->youtube ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[instagram]" placeholder="Instagram" value="<?php echo $ponente->instagram ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[tiktok]" placeholder="Tiktok" value="<?php echo $ponente->tiktok ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-github"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[github]" placeholder="Github" value="<?php echo $ponente->github ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-linkedin"></i>
            </div>
            <input type="text" class="formulario__input--sociales" name="redes[linkedin]" placeholder="LinkedIn" value="<?php echo $ponente->linkedin ?? ''; ?>">
        </div><!-- .formulario__contenedor-icono -->
    </div><!-- .formulario__campo -->

</fieldset>