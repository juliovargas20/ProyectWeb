function redirectToPreviousPage() {
    window.location.href = "http://localhost/Proyecto01/Cotizacion";
}

(function () {
    window.print();

    window.onbeforeprint = function () {
        // No se hace nada cuando se inicia la impresión
        //redirectToPreviousPage();
    };
    
    // Detectar si se cancela la impresión
    window.onafterprint = function () {
        // Redirigir a la página anterior
        redirectToPreviousPage();
    };

})();

