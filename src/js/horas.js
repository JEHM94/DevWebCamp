(function () {
    // Selecciona el elemento con id=horas
    const horas = document.querySelector('#horas');

    // Ejecuta el siguiente código sólo si existe ese elemento
    if (horas) {
        let busqueda = {
            categoria_id: '',
            dia: ''
        };

        // Selecciona el campo de categoría
        const categoria = document.querySelector('[name="categoria_id"]');
        // Selecciona los radio buttons
        const dias = document.querySelectorAll('[name="dia"]');
        // Selecciona el input hidden para asignarle un value
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        // Selecciona el input hidden para asignarle un value
        const inputHiddenHora = document.querySelector('[name="hora_id"]');
        // Selecciona el listado de todas las Horas
        const listadoHoras = document.querySelectorAll('#horas li');


        // Para valores originales si el usuario está Editando un Evento
        let categoriaActual = '';
        let diaActual = '';
        let horaActual = '';

        // Al iniciar la página Verifica si alguno de los inputs ya tiene un valor
        // Esto significa que el usuario está editando el Evento
        if (categoria.value || inputHiddenDia.value || inputHiddenHora.value) {
            // Guarda los valores actuales de los inputs al momento de Editar un Evento
            // para preservar los valores originales
            categoriaActual = categoria.value;
            diaActual = inputHiddenDia.value;
            horaActual = inputHiddenHora.value;

            // Asigna los Valores originales al arreglo de busqueda
            busqueda.categoria_id = categoriaActual;
            busqueda.dia = diaActual;

            // Busca las Horas ocupadas con Eventos
            buscarEventos();
        }


        // Asigna el evento para el cambio del select
        categoria.addEventListener('change', terminoBusqueda);

        // Asigna el evento para el cambio del radio
        dias.forEach(dia => {
            dia.addEventListener('change', terminoBusqueda);
            dia.addEventListener('change', () => {
                // Asigna el valor al input oculto de día
                inputHiddenDia.value = dia.value;
            });
        });

        function terminoBusqueda(e) {
            // Llena el día en el objeto de busqueda con el valor del día
            busqueda[e.target.name] = e.target.value;

            // Reinicia los campos ocultos y el selector de horas
            limpiarHoraPrevia();

            // Previene la ejecución del siguiente código si aún no está lleno el objeto
            if (Object.values(busqueda).includes('')) {
                return;
            }

            buscarEventos();
        }

        async function buscarEventos() {
            const { dia, categoria_id } = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`

            const resultado = await fetch(url);
            const eventos = await resultado.json();

            obtenerHorasDisponibles(eventos.body);

            mostrarHoraActual();
        }

        function mostrarHoraActual() {
            // Verifica si el usuario está en la misma categoría y el mismo día
            // que provienen del servidor al momento de Editar
            if (categoria.value === categoriaActual && inputHiddenDia.value === diaActual) {
                // Asigna la Hora Actual del Evento que se está editando
                const horaSeleccionada = document.querySelector(`[data-hora-id="${horaActual}"]`);

                // Modifica las clases del LI
                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                // Agrega evento click a las hora Seleccionada
                horaSeleccionada.addEventListener('click', seleccionarHora);

                // Asiga el ID de la hora actual al Input oculto
                inputHiddenHora.value = horaSeleccionada.dataset.horaId;
            }
        }

        function obtenerHorasDisponibles(eventos) {
            // Reinicia las Horas
            listadoHoras.forEach(li => {
                // Agrega las clase de horas deshabilitadas
                li.classList.add('horas__hora--deshabilitada')
                // Remueve los eventos listener previos
                li.removeEventListener('click', seleccionarHora);
            });

            // Crea un array con las horas ya tomadas
            const horasTomadas = eventos.map(evento => evento.hora_id);
            // Convierte el listadoHoras a un Array para poder usar filter
            const listadoHorasArray = Array.from(listadoHoras);
            // Filtra el listado de horas y obtiene las horas que no han sido tomadas
            const horasDisponibles = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId));

            horasDisponibles.forEach(li => {
                // Remueve la clase de hora deshabilitada
                li.classList.remove('horas__hora--deshabilitada');
                // Agrega evento click a las horas disponibles
                li.addEventListener('click', seleccionarHora);
            });

            //const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            //horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e) {
            // Remueve la Clase se seleccionada cuando hay un nuevo click
            limpiarHoraPrevia();

            // Agrega clase se Seleccionada
            e.target.classList.add('horas__hora--seleccionada');
            // Agrega el id de la hora al input oculto
            inputHiddenHora.value = e.target.dataset.horaId;

            // Agrega el id del día al input oculto
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }

        function limpiarHoraPrevia() {
            inputHiddenHora.value = '';
            // Remueve la Clase de seleccionada cuando hay un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
        }

    }
})();