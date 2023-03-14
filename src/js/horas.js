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


        // Asigna el evento para el cambio del select
        categoria.addEventListener('change', terminoBusqueda);

        // Asigna el evento para el cambio del radio
        dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));


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
        }

        function obtenerHorasDisponibles(eventos) {
            // Reinicia las Horas
            const listadoHoras = document.querySelectorAll('#horas li');
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
            inputHiddenDia.value = '';
            // Remueve la Clase se seleccionada cuando hay un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
        }

    }
})();