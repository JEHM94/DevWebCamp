const { default: Swal } = require("sweetalert2");

(function () {
    let eventos = [];

    const resumen = document.querySelector('#registro-resumen');
    if (resumen) {

        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitFormulario);

        function seleccionarEvento({ target }) {

            // Establece el máximo de eventos para agregar (5)
            if (eventos.length >= 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Solo puede agregar hasta 5 eventos',
                })
                return;
            }

            // Si se le da click a unos de los elementos dentro botón, asigna al elemento padre como el target
            if (target.nodeName !== 'BUTTON') target = target.parentElement;

            // Una vez seleccionado un evento, deshabilita el botón y su listener
            target.disabled = true;
            target.removeEventListener('click', seleccionarEvento);

            // Guarda el texto del botón
            textoBoton = target.innerHTML;

            // Sustituye el texto del botón
            target.textContent = 'Agregado';

            eventos = [...eventos, {
                id: target.dataset.id,
                titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim(),
                textoBoton: textoBoton
            }];

            // Muestra los eventos
            mostrarEventos();
        }

        function mostrarEventos() {
            // Limpia los eventos anteriores
            limpiarEventos();

            if (eventos.length <= 0) {
                // Crea el elemento para cuando no haya eventos seleccionados
                const sinEventos = document.createElement('P');
                sinEventos.classList.add('registro__sin-registros');
                sinEventos.textContent = 'No hay eventos seleccionados';
                resumen.appendChild(sinEventos);
                return;
            }

            eventos.forEach(evento => {
                const eventoDOM = document.createElement('DIV');
                eventoDOM.classList.add('registro__evento');

                const titulo = document.createElement('H3');
                titulo.classList.add('registro__nombre');
                titulo.textContent = evento.titulo;

                const botonEliminar = document.createElement('BUTTON');
                botonEliminar.classList.add('registro__eliminar');
                botonEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>';
                botonEliminar.onclick = function () {
                    elimiarEvento(evento);
                }

                // Renderizar en el HTML
                eventoDOM.appendChild(titulo);
                eventoDOM.appendChild(botonEliminar);
                resumen.appendChild(eventoDOM);
            });
        }

        function elimiarEvento(evento) {

            const { id, textoBoton } = evento;
            // Elimina el evento con el id ingresado del array de eventos
            eventos = eventos.filter(evento => evento.id !== id);

            // Habilita el botón del evento eliminado y reestablece sus valores
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            botonAgregar.innerHTML = textoBoton;
            botonAgregar.addEventListener('click', seleccionarEvento);

            mostrarEventos();
        }

        function limpiarEventos() {
            while (resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        async function submitFormulario(e) {
            e.preventDefault();

            // Obtener el Regalo
            const regaloId = document.querySelector('#regalo').value;
            const eventosId = eventos.map(evento => evento.id);

            // Verifica si no hay eventos seleccionas o regalos
            if (eventosId.length === 0 || regaloId === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Elige al menos un evento y el regalo',
                })
                return;
            }

            //  Registra al usuario
            const url = '/finalizar-registro/conferencias';

            const datos = new FormData();
            datos.append('eventos', eventosId);
            datos.append('regalo_id', regaloId);

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if (!resultado.resultado) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ha ocurrido un error con tu registro. Por favor inténtelo nuevamente',
                }).then(() => location.reload());
                return;
            }

            Swal.fire(
                'Registro Exitoso',
                'Tus conferencias se han almacenado correctamente, te esperamos en DevWebCamp',
                'success'
            ).then(() => location.href = `/boleto?token=${resultado.token}`);

        }

    }
})();