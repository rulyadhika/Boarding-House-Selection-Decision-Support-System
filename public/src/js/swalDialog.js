const dispatchErrorDialog = (response) => {
    swalCustomStylingBtn
        .fire({
            title: "Oops! Terjadi Kesalahan",
            text: response.message,
            icon: "error",
            confirmButtonText: "OK",
        })
        .then((result) => {
            if (response.refresh) {
                location.reload();
            }
        });
};

const dispatchSuccessDialog = (response) => {
    swalCustomStylingBtn
        .fire({
            title: response.title,
            text: response.text,
            icon: "success",
            confirmButtonText: response.confirmButtonText ?? "OK",
            showCancelButton: response.showCancelButton ?? false,
            cancelButtonText: response.cancelButtonText ?? "Cancel",
            reverseButtons: response.reverseButtons ?? true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                if (response.confirmAction ?? false) {
                    if ((response.confirmAction.type = "redirect")) {
                        window.location.replace(response.confirmAction.to);
                    }
                }
            }
        });
};

const dispatchConfirmationDialog = (response) => {
    return swalCustomStylingBtn
        .fire({
            title: response.title,
            text: response.text,
            icon: response.icon ?? "info",
            confirmButtonText: response.confirmButtonText ?? "OK",
            showCancelButton: response.showCancelButton ?? false,
            cancelButtonText: response.cancelButtonText ?? "Cancel",
            reverseButtons: response.reverseButtons ?? true,
        })
        .then((result) => {
            return result.isConfirmed;
        });
};
