const swalCustomStylingBtn = Swal.mixin({
    customClass: {
        confirmButton: 'btn-sm btn btn-primary',
        cancelButton: 'btn-sm btn btn-outline-primary me-2'
    },
    buttonsStyling: false
});

const swalConfirmation = Swal.mixin({
    customClass: {
        confirmButton: 'btn-sm btn btn-success',
        denyButton: 'btn-sm btn btn-danger me-2',
        cancelButton: 'btn-sm btn btn-secondary me-2'
    },
    buttonsStyling: false
});