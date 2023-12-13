let TblOi_data;
let TblOC_data;
document.addEventListener('DOMContentLoaded', function () {
   
    TblOi_data = $("#TblResumenOI").DataTable({
        ajax: {
            url: base_url + "Logistica/ListarImportacionAprobacion",
            dataSrc: "",
        },
        columns: [
            { data: "ID", className: "text-center" },
            { data: "FECHA", className: "text-center" },
            { data: "AREA", className: "text-center" },
            { data: "STATUS", className: "text-center" },
            { data: "ACCIONES", className: "text-center" },
        ],
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
        },
    });

    TblOC_data = $("#TblResumenOC").DataTable({
        ajax: {
            url: base_url + "Logistica/ListarOC",
            dataSrc: "",
        },
        columns: [
            { data: "ID", className: "text-center" },
            { data: "FECHA", className: "text-center" },
            { data: "AREA", className: "text-center" },
            { data: "TOTAL", className: "text-center" },
            { data: "STATUS", className: "text-center" },
            { data: "ACCIONES", className: "text-center" },
        ],
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
        },
    });

});

function MostrarPDf(id) {
    const url = base_url + 'Logistica/MostrarPdf/' + id;
    window.open(url, '_blank');
}

function Aprobacion(id) {
    const url = base_url + 'Logistica/AprobacionStatus/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.tipo == 'success') {
                TblOi_data.ajax.reload();
            }
        }
    };
}

function Espera(id) {
    const url = base_url + 'Logistica/EsperaStatus/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.tipo == 'success') {
                TblOi_data.ajax.reload();
            }
        }
    };
}

function Denegado(id) {
    const url = base_url + 'Logistica/DenegadoStatus/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.tipo == 'success') {
                TblOi_data.ajax.reload();
            }
        }
    };
}

function MostrarPDfCompra(id) {
    const url = base_url + "Ordenes/MostrarRecibo/" + id;
    window.open(url, "_blank");
}

function AprobacionCompra(id) {
    const url = base_url + 'Logistica/AprobacionStatusCompra/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.tipo == 'success') {
                TblOC_data.ajax.reload();
            }
        }
    };
}

function EsperaCompra(id) {
    const url = base_url + 'Logistica/EsperaStatusCompra/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.tipo == 'success') {
                TblOC_data.ajax.reload();
            }
        }
    };
}

function DenegadoCompra(id) {
    const url = base_url + 'Logistica/DenegadoStatusCompra/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.tipo == 'success') {
                TblOC_data.ajax.reload();
            }
        }
    };
}