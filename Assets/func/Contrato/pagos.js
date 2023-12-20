let TblPagosdata;

document.addEventListener("DOMContentLoaded", function () {

  TblPagosdata = $("#TblPagosContrato").DataTable({
    ajax: {
      url: base_url + "Contrato/ListaPagos",
      dataSrc: "",
    },
    columns: [
      { data: "ID_PACIENTE", className: "text-center" },
      { data: "NOMBRES" },
      { data: "MONTO", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "ESTADO", className: "text-center" },
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
      {
        // Total Invoice Amount
        targets: 2,
        render: function (data, type, full, meta) {
          var $total = full["MONTO"];
          return '<span class="badge rounded-pill bg-label-success">'+ "S/. " + $total + "</span>";
        },
      }
    ],
    dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    buttons: [
      {
        extend: "collection",
        className: "btn btn-label-primary dropdown-toggle me-2",
        text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
        buttons: [
          {
            extend: "print",
            text: '<i class="mdi mdi-printer-outline me-1" ></i>Imprimir',
            className: "dropdown-item",
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = "";
                  $.each(el, function (index, item) {
                    if (
                      item.classList !== undefined &&
                      item.classList.contains("user-name")
                    ) {
                      result = result + item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                },
              },
            },
            customize: function (win) {
              //customize print view for dark
              $(win.document.body)
                .css("color", config.colors.headingColor)
                .css("border-color", config.colors.borderColor)
                .css("background-color", config.colors.bodyBg);
              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("color", "inherit")
                .css("border-color", "inherit")
                .css("background-color", "inherit");
            },
          },
          {
            extend: "csv",
            text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
            className: "dropdown-item",
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = "";
                  $.each(el, function (index, item) {
                    if (
                      item.classList !== undefined &&
                      item.classList.contains("user-name")
                    ) {
                      result = result + item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                },
              },
            },
          },
          {
            extend: "excel",
            text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
            className: "dropdown-item",
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = "";
                  $.each(el, function (index, item) {
                    if (
                      item.classList !== undefined &&
                      item.classList.contains("user-name")
                    ) {
                      result = result + item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                },
              },
            },
          },
          {
            extend: "pdf",
            text: '<i class="mdi mdi-file-pdf-box me-1"></i>Pdf',
            className: "dropdown-item",
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = "";
                  $.each(el, function (index, item) {
                    if (
                      item.classList !== undefined &&
                      item.classList.contains("user-name")
                    ) {
                      result = result + item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                },
              },
            },
          },
          {
            extend: "copy",
            text: '<i class="mdi mdi-content-copy me-1" ></i>Copy',
            className: "dropdown-item",
            exportOptions: {
              columns: [0, 1, 2, 3, 4],
              // prevent avatar to be display
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = "";
                  $.each(el, function (index, item) {
                    if (
                      item.classList !== undefined &&
                      item.classList.contains("user-name")
                    ) {
                      result = result + item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result = result + item.textContent;
                    } else result = result + item.innerText;
                  });
                  return result;
                },
              },
            },
          },
        ],
      }
    ],
    order: [[0, 'desc']],
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


function Visualizar(Id) {
  window.location.href = base_url + 'Contrato/historialPagos/' + Id;
}

function VisualizarContrato(id) {
  const url = base_url + "Contrato/MostrarContrato/" + id;
  window.open(url, '_blank');
}
