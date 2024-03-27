function showSuccessPopup(title, text) {
    Swal.fire({
        icon: "success",
        title: title,
        text: text,
        showConfirmButton: false,
        timer: 3000,
    });
}

function showErrorPopup(title, text) {
    Swal.fire({
        icon: "error",
        title: title,
        text: text,
        showConfirmButton: false,
        timer: 3000,
    });
}

function showWarningPopup(title, text) {
    Swal.fire({
        icon: "warning",
        title: title,
        text: text,
        showConfirmButton: false,
        timer: 3000,
    });
}
