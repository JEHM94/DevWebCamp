(function () {
    const tagsInput = document.querySelector('#tags_input');

    // Previene la ejecución del código si no encuentra el elemento de tags
    if (!tagsInput) {
        return;
    }

    let tags = [];
    const tagsDiv = document.querySelector('#tags');
    const tagsInputHidden = document.querySelector('[name="tags"]');

    // Escucha los cambios del input
    tagsInput.addEventListener('keypress', guardarTag);

    function guardarTag(e) {
        // Verifica si fue presionada la coma (,) con su Key Code 44
        if (e.keyCode === 44) {
            // Previene la ejecución del código si solo se ingresan espacios en blanco
            if (e.target.value.trim() === '' || e.target.value < 1) {
                return;
            }

            // Previene que la coma (,) se ingrese al value del input
            e.preventDefault();

            // Crea una copia del array de tags y agrega la nueva tag
            tags = [...tags, e.target.value.trim()];

            // Limpia el Value del input
            tagsInput.value = '';

            // Actualiza el listado de tags
            mostrarTags();
        }
    }

    function mostrarTags() {
        tagsDiv.textContent = '';
        tags.forEach(tag => {
            const nuevaTag = document.createElement('LI');
            nuevaTag.classList.add('formulario__tag');
            nuevaTag.textContent = tag;
            nuevaTag.ondblclick = eliminarTag;
            tagsDiv.appendChild(nuevaTag);
        });

        actualizarInputHidden();
    }

    function eliminarTag(e){
        e.target.remove();
        tags = tags.filter(tag => tag !== e.target.textContent);
        actualizarInputHidden();
    }

    function actualizarInputHidden(){
        tagsInputHidden.value = tags.toString();
    }

})();