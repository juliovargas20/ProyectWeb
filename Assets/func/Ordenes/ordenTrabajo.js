
const frm = document.querySelector("#FrmOT");
const btnEnviar = document.querySelector("#btnOT");

const btnModal = document.querySelector("#btnModal");

const ModalOT = document.querySelector("#BuscarOT");
const ModalOpenOT = new bootstrap.Modal(ModalOT);

let TblOT_data;

document.addEventListener('DOMContentLoaded', function () {
  frm.addEventListener('submit', handleFrmOT, false);

  TblOT_data = $("#TblResumenOT").DataTable({
    ajax: {
        url: base_url + "Ordenes/ListarOT",
        dataSrc: "",
    },
    columns: [
        { data: "ID", className: "text-center" },
        { data: "FECHA", className: "text-center" },
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

  btnModal.addEventListener('click', function (e) {
    e.preventDefault();
    ModalOpenOT.show();
  });


});

function handleFrmOT(event) {
  event.preventDefault();
  const FrmOT = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmOT.checkValidity()) {
    event.stopPropagation();
  } else {
    btnEnviar.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnEnviar.disabled = true;

    const url = base_url + "Ordenes/InsertarOrdenTrabajo";
    const data = new FormData(FrmOT);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (http.readyState == 4 && http.status == 200) {
        const res = JSON.parse(http.responseText);
        setTimeout(function () {
          if (res.tipo == "success") {
            Swal.fire({
              icon: res.tipo,
              title: res.mensaje,
              showConfirmButton: true,
              timer: 2000,
              didClose: () => {
                PdfOT(res.id);
                window.location.reload();
              },
            });
          } 
        }, 3000);
      }
    };
  }
  FrmOT.classList.add("was-validated");
}

function PdfOT(id) {
  const url = base_url + "Ordenes/Documento/" + id;
  window.open(url, "_blank");
}