// Esta función abre y cierra el modal
// especificado a través de su id.

function dispatchModal(id, action = 'toggle') {
    const el = document.querySelector("#" + id);
    const modal = tailwind.Modal.getOrCreateInstance(el);

    switch (action) {
        case 'toggle':
            modal.toggle();
            break;

        case 'show':
            modal.show();
            break;

        case 'hide':
            modal.hide();
            break;

        default:
            console.log('Error: Unknown action in dispatchModal() function');
            return;
    }
}

// Hacer la función accesible globalmente
// de manera que se puede llamar en las vistas blade

window.dispatchModal = dispatchModal;

window.addEventListener('toggle-modal', event => {
    dispatchModal(event.detail[0].id, event.detail[0].action);
})
