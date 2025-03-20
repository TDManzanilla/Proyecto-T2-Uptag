function showAlert(title, icon, href = '', confirmButtonText = 'Confirmar', cancelButtonText = 'Cancelar') {
    return Swal.fire({
        title: title,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText
    }).then((result) => {
        if (result.isConfirmed && href) {
            window.location.href = href;
        }
        return result;
    });
}

function confirmCreateRole() {
    const nombreRol = document.getElementById('nombre_rol').value;
    showAlert(
        `¿Quiere crear este rol: ${nombreRol}?`,
        'question',
        '',
        'Confirmar',
        'Cancelar'
    ).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('createRoleForm').submit();
        }
    });
}

function handleEnter(event, formId, confirmFunction) {
    if (event.key === 'Enter') {
        event.preventDefault();
        confirmFunction(formId);
    }
}


