function redirectToPreviousPage() {
    window.location.href = "http://localhost/Proyecto01/Cotizacion";
}

(function () {
    window.print();

    // Detectar si se cancela la impresión
    window.onafterprint = function () {
        // Redirigir a la página anterior después de un pequeño retraso (500 milisegundos)
        setTimeout(function () {
            redirectToPreviousPage();
        }, 500);
    };
})();
