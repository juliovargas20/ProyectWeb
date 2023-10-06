const id = document.getElementById("id_paciente").value;
const ModalContrato = document.querySelector("#ModalContrato");
const ModalOpenContrato = new bootstrap.Modal(ModalContrato);
const btnPreVizualizar = document.querySelector("#btnVis");
const btnContrato = document.querySelector("#btnContrato");
let id_coti = 0;

let TblContratodata;

document.addEventListener("DOMContentLoaded", function () {
  TblContratodata = $("#TblContrato").DataTable({
    ajax: {
      url: base_url + "Contrato/getLista/" + id,
      dataSrc: "",
    },
    columns: [
      { data: "FECHA", className: "text-center" },
      { data: "SUB_TRAB" },
      { data: "MONTO", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    columnDefs: [
      {
        // Total Invoice Amount
        targets: 2,
        render: function (data, type, full, meta) {
          var $total = full["MONTO"];
          return '<span class="badge rounded-pill bg-label-info">S/.' + $total + "</span>";
        },
      }
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

  btnContrato.addEventListener("click", function (e) {
    e.preventDefault();

    // Mostrar el spinner en el botón
    btnContrato.innerHTML = `
    <span class="spinner-border me-1" role="status" aria-hidden="true"></span> 
    Guardando...  
    `;

    const id_cotizacion = document.getElementById("IdCoti").value;
    const url = base_url + "Contrato/Registrar/" + id_cotizacion;
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        const res = JSON.parse(this.responseText);

        setTimeout(function () {
          Swal.fire({
            icon: res.tipo,
            title: res.mensaje,
            showConfirmButton: true,
            timer: 2000,
            didClose: () => {
              if ((res.tipo = "success")) {
                // Restaurar el contenido original del botón
                btnContrato.innerHTML = "Guardar";
                EnviarCorreo(res.id, id_cotizacion);
                window.open(base_url + 'Contrato/PdfContrato/' + id_cotizacion, '_blank');
                window.location.href = base_url + "Pacientes";
              } else {
                // Restaurar el contenido original del botón
                btnContrato.innerHTML = "Guardar";
              }
            },
          });
        }, 3000);
        ModalOpenContrato.hide();
      }
    };
  });

  btnPreVizualizar.addEventListener("click", function () {
    PreContrato(id_coti);
  });
});

function AbrirContrato(id, obs, monto) {
  document.getElementById("IdCoti").value = id;
  document.getElementById("Obs").value = obs;
  document.getElementById("Monto").value = monto;
  id_coti = id
  Lista(id);
  ModalOpenContrato.show();
}

function Lista(id) {
  const ol = document.getElementById("listaCompo");
  const url = base_url + "Contrato/ListaComponente/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += ` 
                    <li class="list-group-item">${row["LISTA"]}</li>
                `;
      });
      ol.innerHTML = html;
    }
  };
}

function PreContrato(id) {
  const url = base_url + "Contrato/PdfContrato/" + id;
  window.open(url, '_blank');
}

function EnviarCorreo(id_contrato, id_coti) {
  let formData = new FormData();
  formData.append("id_contrato", id_contrato);
  formData.append("id_coti", id_coti);
  const url = base_url + 'Contrato/EnviarCorreo';
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(formData);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
    }
  }
}