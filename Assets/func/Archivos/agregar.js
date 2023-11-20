const ModalDocument = document.querySelector("#ModalDocumentos");
const ModalOpenDocument = new bootstrap.Modal(ModalDocument);

const buttonModal = document.querySelector("#btnModal");

const buttonRegistrar = document.querySelector("#btnDocumentoRegistro");
const FrmDoc = document.querySelector("#FrmDocumentos");

let ListadoDocumentosData;
const id = document.getElementById("IDBAse").value;
document.addEventListener('DOMContentLoaded', function () {
    ListadoDocumentosData = $("#TblListaDocumentos").DataTable({
        ajax: {
            url: base_url + "Archivos/ListarDocumentos/" + id,
            dataSrc: "",
        },
        columns: [
            { data: "NOMBRES", className: "text-center"  },
            { data: "ACCIONES", className: "text-center" },
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

    buttonModal.addEventListener("click", function (e) {
        e.preventDefault();
        ModalOpenDocument.show();
    });

    FrmDoc.addEventListener("submit", handleFrmDocumento, false);

});


function handleFrmDocumento(event) {
    event.preventDefault();
    const FrmDocumento = event.target;
    const bsValidationForms = document.querySelectorAll(".needs-validation");

    if (!FrmDocumento.checkValidity()) {
        event.stopPropagation();
    } else {
        buttonRegistrar.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
        buttonRegistrar.disabled = true;

        const url = base_url + "Archivos/RegistrarDocumento";
        const data = new FormData(FrmDocumento);
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                console.log(http.responseText);
                const res = JSON.parse(http.responseText);
                setTimeout(function () {
                    if (res.tipo == "success") {
                        Swal.fire({
                            icon: res.tipo,
                            title: res.mensaje,
                            showConfirmButton: true,
                            timer: 2000,
                            didClose: () => {
                                window.location.reload();
                            },
                        });
                        ModalOpenDocument.hide();
                    }
                }, 3000);
            }
        };
    }
    FrmDocumento.classList.add("was-validated");
}

function Documento(id) {
    const url = base_url + "Archivos/Documento/" + id;
    window.open(url, "_blank");
}

function EliminarDocumento(id) {
    Swal.fire({
      title: "¿Estas Seguro de Eliminar el documento?",
      text: "EL documento se eliminara definitivamente!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, Eliminar!",
      customClass: {
        confirmButton: "btn btn-primary me-3 waves-effect waves-light",
        cancelButton: "btn btn-label-danger waves-effect",
      },
      buttonsStyling: false,
    }).then(function (result) {
      if (result.value) {
        const url = base_url + "Archivos/EliminarDocumento/" + id;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res.tipo == "success") {
              setTimeout(() => {
                Swal.fire({
                  icon: res.tipo,
                  title: "Eliminado!",
                  text: "El Documento ha sido eliminado.",
                  showConfirmButton: true,
                  timer: 2000,
                  didClose: () => {
                    window.location.reload();
                  },
                });
              }, 1000);
            }
          }
        };
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: "Cancelado",
          text: "Acción cancelada!",
          icon: "error",
          customClass: {
            confirmButton: "btn btn-success waves-effect",
          },
        });
      }
    });
}