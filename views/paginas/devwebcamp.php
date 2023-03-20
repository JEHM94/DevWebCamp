<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animacion(); ?> class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img src="build/img/sobre_devwebcamp.jpg" alt="Imagen DevWebCamp" loading="lazy" width="200" height="300">
            </picture>
        </div> <!-- .devwebcamp__imagen -->

        <div <?php aos_animacion(); ?> class="devwebcamp__contenido">
            <p class="devwebcamp__texto">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, commodi fugit culpa sunt ratione nobis qui aut ipsa ea porro doloremque molestiae facilis est nisi sint repudiandae. Id, soluta quas.
                Consequuntur, maiores non rem similique eum tempore voluptatum beatae. Omnis perspiciatis accusamus cum consequatur dolores error nihil eum minima perferendis totam rerum voluptatibus, fuga placeat veritatis harum. Facere, dolor unde?</p>
            <p class="devwebcamp__texto">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, commodi fugit culpa sunt ratione nobis qui aut ipsa ea porro doloremque molestiae facilis est nisi sint repudiandae. Id, soluta quas.
                Consequuntur, maiores non rem similique eum tempore voluptatum beatae. Omnis perspiciatis accusamus cum consequatur dolores error nihil eum minima perferendis totam rerum voluptatibus, fuga placeat veritatis harum. Facere, dolor unde?</p>
        </div><!-- .devwebcamp__contenido -->
    </div><!-- .devwebcamp__grid -->
</main>