let ListadoArchivosData;
document.addEventListener('DOMContentLoaded', function () {
   
    ListadoArchivosData = $("#TblListaArchivos").DataTable({
        ajax: {
          url: base_url + "Archivos/Listar",
          dataSrc: "",
        },
        columns: [
          { data: "ID_PACIENTE", className: "text-center" },
          { data: "NOMBRES" },
          { data: "ACCIONES", className: "text-center" },
        ],
        columnDefs: [
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
        ],
        order: [[0, "desc"]],
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

function archivos(id) {
    window.location.href = base_url + "Archivos/agregar/" + id;
}

