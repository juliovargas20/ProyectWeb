/************** LISTADO PACIENTES  **************/
let TblListadoPacienteData;

const ModalAcc = document.querySelector("#BuscarRecibos");
const ModalOpenAcc = new bootstrap.Modal(ModalAcc);

//const flatpickrRange = document.querySelector("#flatpickr-range");

document.addEventListener("DOMContentLoaded", function () {
  TblListadoPacienteData = $("#TblListadoPacientes").DataTable({
    ajax: {
      url: base_url + "Pacientes/Listar",
      dataSrc: "",
    },
    columns: [
      { data: "" },
      { data: "ID_PACIENTE", className: "text-center" },
      { data: "NOMBRES" },
      { data: "DNI" },
      { data: "CELULAR", className: "text-center" },
      { data: "SEDE", className: "text-center" },
      { data: "ESTADO", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    columnDefs: [
      {
        // For Responsive
        className: "control",
        orderable: false,
        searchable: false,
        responsivePriority: 2,
        targets: 0,
        render: function (data, type, full, meta) {
          return "";
        },
      },
      {
        targets: 2,
        width: "300px",
      },
      {
        targets: 3,
        visible: false,
      },
    ],
    order: [[1, "desc"]],
    dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    displayLength: 7,
    lengthMenu: [7, 10, 25, 50, 75, 100],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
              columns: [1, 2, 3, 4, 5, 6, 7],
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
      },
      {
        text: '<i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Agregar Paciente</span>',
        className: "btn btn-dark",
        attr: {
          type: "button",
          id: "btnAddPaciente",
          onclick: "AbrirRegistro()",
        },
      },
      {
        text: '<i class="mdi mdi-tab-search me-sm-1"></i> <span class="d-none d-sm-inline-block">Buscar Recibos</span>',
        className: "btn btn-primary mx-2",
        attr: {
          type: "button",
          onclick: "ModalReciboPago()",
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

  $("#TblAccRecibo").DataTable({
    ajax: {
      url: base_url + "Pacientes/ListarRecibos",
      dataSrc: "",
    },
    columns: [
      { data: "ID_PACIENTE", className: "text-center" },
      { data: "NOMBRES" },
      { data: "TIP_PAGO", className: "text-center" },
      { data: "PAGO", className: "text-center" },
      { data: "TOTAL", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
  });

  /*flatpickrRange.flatpickr({
    mode: "range",
    onClose: function (selectedDates, dateStr, instance) {
      var dateRange = dateStr.split(" to ");
      var startDate = dateRange[0].trim();
      var endDate = dateRange[1].trim();

      TblListadoPacienteData.column(7) // Asegúrate de que este sea el índice correcto de la columna de fecha
        .data()
        .each(function (value, index) {
          var date = new Date(value);
          if (date >= new Date(startDate) && date <= new Date(endDate)) {
            TblListadoPacienteData.row(index)
              .nodes()
              .to$()
              .addClass("in-range");
          }
        });

      TblListadoPacienteData.draw();
    },
  });*/
});

function AbrirRegistro() {
  window.location.href = base_url + "Pacientes/registro";
}

function eliminar(id) {
  const url = base_url + "Pacientes/Eliminar/" + id;
  Eliminar(
    "Deseas Eliminar al Paciente",
    "El paciente será eliminado del sistema",
    "Sí",
    url,
    TblListadoPacienteData
  );
}

function editar(id) {
  window.location.href = base_url + "Pacientes/modificar/" + id;
}

function FichaEvaluacion(id) {
  document.getElementById("IDTipServicio").value = id;
  const Modalficha = document.querySelector("#TipoServicio");
  const ModalEva = new bootstrap.Modal(Modalficha);
  ModalEva.show();
}

function MS() {
  const cod = document.getElementById("IDTipServicio").value;
  document.getElementById("IDTip").value = cod;
}

function MI() {
  const cod = document.getElementById("IDTipServicio").value;
  document.getElementById("IDTipI").value = cod;
}

function Este() {
  const cod = document.getElementById("IDTipServicio").value;
  document.getElementById("IDEste").value = cod;
}

function Contrato(id) {
  window.location.href = base_url + "Contrato/generar/" + id;
}

function getFicha(id) {
  window.open(base_url + "Pacientes/Ficha/" + id);
}

function Accesorios(id) {
  window.location.href = base_url + "Pacientes/Accesorios/" + id;
}

function ModalReciboPago() {

  ModalOpenAcc.show();
}

function PDfPago(id) {
  const url = base_url + "Pacientes/MostrarReciboPagos/" + id;
  window.open(url, "_blank");
}