let DataListaCotizacion;
document.addEventListener("DOMContentLoaded", function () {
  
  DataListaCotizacion = $("#TblListaCotizacion").DataTable({
    ajax: {
      url: base_url + "Cotizacion/Listar",
      dataSrc: "",
    },
    columns: [
      { data: "ID_PACIENTE", className: "text-center" },
      { data: "NOMBRES" },
      { data: "MONTO", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    columnDefs: [
      {
        // Invoice ID
        targets: 0,
        render: function (data, type, full, meta) {
          var $id = full["ID_PACIENTE"];
          var $cod = full['ID'];
          // Creates full output for row
          var $row_output = "<span>#" + $id + " - " + $cod + "</span>";
          return $row_output;
        },
      },
      {
        // Client name and Service
        targets: 1,
        responsivePriority: 1,
        render: function (data, type, full, meta) {
          var $nombres = full["NOMBRES"],
            $sub = full["SUB_TRAB"];
          // Creates full output for row
          var $row_output =
            '<div class="d-flex justify-content-start align-items-center">' +
            '<div class="d-flex flex-column gap-1">' +
            '<h6 class="mb-0">' +
            $nombres +
            "</h6>" +
            '<small class="text-truncate text-muted">' +
            $sub +
            "</small>" +
            "</div>" +
            "</div>";
          return $row_output;
        },
      },
      {
        // Total Invoice Amount
        targets: 2,
        render: function (data, type, full, meta) {
          var $total = full["MONTO"];
          return '<span class="badge bg-label-success">S/. ' + $total + "</span>";
        },
      },
    ],
    "order": [[0, 'desc']] ,
    dom:
      '<"row ms-2 me-3"' +
      '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
      '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' +
      ">t" +
      '<"row mx-2"' +
      '<"col-sm-12 col-md-6"i>' +
      '<"col-sm-12 col-md-6"p>' +
      ">",
    buttons: [
      {
        text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-md-inline-block d-none">Crear Cotización</span>',
        className: "btn btn-primary",
        action: function (e, dt, button, config) {
          window.location = base_url + "Cotizacion/agregar";
        },
      },
    ],
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

function Prevista(id) {
  window.location.href = base_url + "Cotizacion/imprimir/" + id;
}