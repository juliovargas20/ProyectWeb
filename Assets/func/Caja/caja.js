/******* INGRESOS *******/
const btnNuevoIngreso = document.querySelector("#btnNI");
const frmNI = document.querySelector("#FrmNI");
const btnRegistrarNI = document.querySelector("#btnResgistarNI");

const ModalNuevoIngreso = document.querySelector("#NuevoIngreso");
const ModalNuevoIngresoOpen = new bootstrap.Modal(ModalNuevoIngreso);

/******* EGRESOS *******/
const btnNuevoEgreso = document.querySelector("#btnNE");
const frmNE = document.querySelector("#FrmNE");
const btnRegistrarNE = document.querySelector("#btnResgistarNE");

const ModalNuevoEgreso = document.querySelector("#NuevoEgreso");
const ModalNuevoEgresoOpen = new bootstrap.Modal(ModalNuevoEgreso);

let TblNI_data;
let TblNE_data;

document.addEventListener("DOMContentLoaded", function () {
  TotalIngresos();
  TotalEgresos();
  RestaTotal();

  TblNI_data = $("#TblListadoIngresos").DataTable({
    ajax: {
      url: base_url + "Caja/ListarIngresos",
      dataSrc: "",
    },
    columns: [
      { data: "IN_FECHA", className: "text-center" },
      { data: "IN_TRANSACCION", className: "text-center" },
      { data: "IN_RESPONSABLE" },
      { data: "IN_TIP_PAGO", className: "text-center" },
      { data: "IN_DESCRIPCION" },
      { data: "IN_AREA", className: "text-center" },
      { data: "IN_MONTO", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    //order: [[1, "desc"]],
    //dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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

  TblNE_data = $("#TblListadoEgrasos").DataTable({
    ajax: {
      url: base_url + "Caja/ListarEgresos",
      dataSrc: "",
    },
    columns: [
      { data: "SAL_FECHA", className: "text-center" },
      { data: "SAL_TRANSACCION", className: "text-center" },
      { data: "SAL_RESPONSABLE" },
      { data: "SAL_TIP_PAGO", className: "text-center" },
      { data: "SAL_DESCRIPCION" },
      { data: "SAL_AREA", className: "text-center" },
      { data: "SAL_MONTO", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    //order: [[1, "desc"]],
    //dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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

  btnNuevoIngreso.addEventListener("click", function (e) {
    e.preventDefault();
    frmNI.reset();
    frmNI.classList.remove("was-validated");
    ModalNuevoIngresoOpen.show();
  });

  btnNuevoEgreso.addEventListener("click", function (e) {
    e.preventDefault();
    frmNE.reset();
    frmNE.classList.remove("was-validated");
    ModalNuevoEgresoOpen.show();
  });

  frmNI.addEventListener("submit", handleFrmNI, false);
  frmNE.addEventListener("submit", handleFrmNE, false);
});

function handleFrmNI(event) {
  event.preventDefault();
  const FrmNIH = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmNIH.checkValidity()) {
    event.stopPropagation();
  } else {
    btnRegistrarNI.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnRegistrarNI.disabled = true;

    const url = base_url + "Caja/RegistrarIngreso";
    const data = new FormData(FrmNIH);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        setTimeout(function () {
          AlertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            TblNI_data.ajax.reload();
            btnRegistrarNI.innerHTML = "Registrar";
            btnRegistrarNI.disabled = false;
            TotalIngresos();
            TotalEgresos();
            RestaTotal();
            ModalNuevoIngresoOpen.hide();
          } else {
            AlertaPerzonalizada(res.tipo, res.msg);
            btnRegistrarNI.innerHTML = "Registrar";
            btnRegistrarNI.disabled = false;
          }
        }, 3000);
      }
    };
  }
  FrmNIH.classList.add("was-validated");
}

function handleFrmNE(event) {
  event.preventDefault();
  const FrmNeH = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmNeH.checkValidity()) {
    event.stopPropagation();
  } else {
    btnRegistrarNE.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnRegistrarNE.disabled = true;

    const url = base_url + "Caja/RegistrarEgreso";
    const data = new FormData(FrmNeH);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        setTimeout(function () {
          if (res.tipo == "success") {
            Swal.fire({
              icon: res.tipo,
              title: res.msg,
              showConfirmButton: true,
              timer: 2000,
            });
            TblNE_data.ajax.reload();
            btnRegistrarNE.innerHTML = "Registrar";
            btnRegistrarNE.disabled = false;
            TotalIngresos();
            TotalEgresos();
            RestaTotal();
            ModalNuevoEgresoOpen.hide();
          } else {
            AlertaPerzonalizada(res.tipo, res.msg);
            btnRegistrarNE.innerHTML = "Registrar";
            btnRegistrarNE.disabled = false;
          }
        }, 3000);
      }
    };
  }
  FrmNeH.classList.add("was-validated");
}

function TotalIngresos() {
  const url = base_url + "Caja/TotalIngresos";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      $("#TI").html("S/. " + res.IN_TOTAL);
    }
  };
}

function TotalEgresos() {
  const url = base_url + "Caja/TotalEgresos";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      $("#TE").html("S/. " + res.SAL_TOTAL);
    }
  };
}

function RestaTotal() {
  const url = base_url + "Caja/RestaTotal";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      $("#TOTALIE").html("S/. " + res.RESTA);
    }
  };
}

function MostrarIngresos(id) {
  const url = base_url + `Caja/MostrarIngresos/${id}`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      frmNI.reset();
      frmNI.classList.remove("was-validated");
      frmNI.ID.value = res.IN_ID;
      frmNI.Tranx.value = res.IN_TRANSACCION;
      frmNI.Responsable.value = res.IN_RESPONSABLE;
      frmNI.Comprobante.value = res.IN_COMPROBANTE;
      frmNI.NCom.value = res.IN_NCOMPRO;
      frmNI.TipPago.value = res.IN_TIP_PAGO;
      frmNI.Area.value = res.IN_AREA;
      frmNI.Dsc.value = res.IN_DESCRIPCION;
      frmNI.Monto.value = res.IN_MONTO;
      ModalNuevoIngresoOpen.show();
    }
  };
}
