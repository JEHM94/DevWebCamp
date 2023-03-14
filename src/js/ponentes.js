(function () {
    const ponentesInput = document.querySelector('#ponentes');

    if (ponentesInput) {

        let ponentes = [];
        let ponentesFiltrados = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHidden = document.querySelector('[name="ponente_id"]');

        obtenerPonentes();

        ponentesInput.addEventListener('input', buscarPonentes);

        async function obtenerPonentes() {
            const url = `/api/ponentes`

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            formatearPonentes(resultado.body);
        }

        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map(ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            });
        }

        function buscarPonentes(e) {
            const busqueda = e.target.value;
            // Busca a partir de 3 caracteres
            if (busqueda.length >= 3) {
                // Expresión regular para buscar un patrón de letras sin importar mayúsculas y minúsculas 
                const expresion = new RegExp(busqueda, "i");

                ponentesFiltrados = ponentes.filter(ponente => {
                    if (ponente.nombre.toLowerCase().search(expresion) != -1) {
                        return ponente;
                    }
                });
            } else {
                // Limpia los ponentes filtrados al estar vacío el campo de búsqueda
                ponentesFiltrados = [];
            }
            mostrarPonentes();
        }

        function mostrarPonentes() {

            // Limpia los ponentes antes de mostrar la búsqueda
            while (listadoPonentes.firstChild) {
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }
            // Elimina el id del ponente seleccionado anteriormente del input hidden
            ponenteHidden.value = '';

            // Si encuentra ponentes filtrados crea el html para mostrarlos
            if (ponentesFiltrados.length > 0) {
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;
                    ponenteHTML.onclick = seleccionarPonente;

                    // Añade el elemento creado al DOM
                    listadoPonentes.appendChild(ponenteHTML);
                });
                return;
            }

            // Muestra mensaje si no encuentra ponentes filtrados
            const sinResultados = document.createElement('P');
            sinResultados.classList.add('listado-ponentes__sin-resultado');
            sinResultados.textContent = 'No hay resultados para tu búsqueda';
            // Añade el elemento creado al DOM
            listadoPonentes.appendChild(sinResultados);
        }

        function seleccionarPonente(e) {
            // Remueve la clase previa de seleccionado
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if (ponentePrevio)
                ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado');

            const ponente = e.target;
            // Agraga la clase seleccionado al ponente
            ponente.classList.add('listado-ponentes__ponente--seleccionado');

            // Agrega el id del ponente seleccionado al input hidden
            ponenteHidden.value = ponente.dataset.ponenteId;
        }
    }
})();