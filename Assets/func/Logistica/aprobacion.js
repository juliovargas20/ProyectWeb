
let TblOi_data;
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
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return "Details of " + data["full_name"];
                    },
                }),
                type: "column",
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            "<td>" +
                            col.title +
                            ":" +
                            "</td> " +
                            "<td>" +
                            col.data +
                            "</td>" +
                            "</tr>"
                            : "";
                    }).join("");

                    return data
                        ? $('<table class="table"/><tbody />').append(data)
                        : false;
                },
            },
        },
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