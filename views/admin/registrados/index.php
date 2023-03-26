<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>


<div class="dashboard__contenedor">
    <?php if (!empty($registros)) : ?>

        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Email</th>
                    <th scope="col" class="table__th">Plan</th>
                    <th scope="col" class="table__th">Comprobante</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($registros as $registro) : ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $registro->usuario->nombre . ' ' . $registro->usuario->apellido; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $registro->usuario->email; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $registro->paquete->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php if ($registro->pago_id) : ?>
                                <a class="table__enlace" target="_blank" href="https://www.sandbox.paypal.com/activity/payment/<?php echo $registro->pago_id; ?>">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    <?php echo $registro->pago_id; ?>
                                </a>
                            <?php else : ?>
                                Sin comprobante
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else : ?>
        <p class="text-center">No hay ningún cliente registrado</p>
    <?php endif; ?>

</div><!-- .dashboard__contenedor -->


<?php echo $paginacion; ?>