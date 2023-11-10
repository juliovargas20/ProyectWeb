/******* INGRESOS *******/
const btnNuevoIngreso = document.querySelector("#btnNI");
const frmNI = document.querySelector("#FrmNI");
const btnRegistrarNI = document.querySelector("#btnResgistarNI");

const ModalNuevoIngreso = document.querySelector("#NuevoIngreso");
const ModalNuevoIngresoOpen = new bootstrap.Modal(ModalNuevoIngreso);

/******* INGRESOS CON RECIBO *******/
const btnNuevoIngresoRecibo = document.querySelector("#btnNICR");
const frmNICR = document.querySelector("#FrmNICR");
const btnRegistrarNICR = document.querySelector("#btnResgistarNIRC");

const ModalNuevoIngresoCR = document.querySelector("#NuevoIngresoRecibo");
const ModalNuevoIngresoCROpen = new bootstrap.Modal(ModalNuevoIngresoCR);

/******* EGRESOS *******/
const btnNuevoEgreso = document.querySelector("#btnNE");
const frmNE = document.querySelector("#FrmNE");
const btnRegistrarNE = document.querySelector("#btnResgistarNE");

const ModalNuevoEgreso = document.querySelector("#NuevoEgreso");
const ModalNuevoEgresoOpen = new bootstrap.Modal(ModalNuevoEgreso);

/******* EGRESOS CON RECIBO *******/
const btnNuevoEgresoCR = document.querySelector("#btnNECR");
const frmNECR = document.querySelector("#FrmNECR");
const btnRegistrarNECR = document.querySelector("#btnResgistarNERC");

const ModalNuevoEgresoCR = document.querySelector("#NuevoEgresoRecibo");
const ModalNuevoEgresoCROpen = new bootstrap.Modal(ModalNuevoEgresoCR);

/******* LISTA RECIBOS INGRESOS *******/
const btnListaRecibos = document.querySelector("#BtnLRI");

const ModalListaRecibos = document.querySelector("#ListaRecibos");
const ModalListaRecibosOpen = new bootstrap.Modal(ModalListaRecibos);

const btnCerrarCaja = document.querySelector("#btnCloseBOx");

/******* LISTA RECIBOS EGRESOS *******/
const btnListaRecibosEgreso = document.querySelector("#BtnLRE");

const ModalListaRecibosEgreso = document.querySelector("#ListaRecibosEgreso");
const ModalListaRecibosEgresoOpen = new bootstrap.Modal(ModalListaRecibosEgreso);


/******* RESUMEN CAJA *******/
const btnResumenCaja = document.querySelector("#BtnRC");
const ModalResumenCaja = document.querySelector("#ResumenCaja");
const ModalResumenCajasOpen = new bootstrap.Modal(ModalResumenCaja);

const btnExcel = document.querySelector("#BtnEx");

let TblNI_data;
let TblNE_data;
let TblLR_data;
let TblLrE_data;
let TblRC_data;

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

  TblLR_data = $("#TblCajaRecibo").DataTable({
    ajax: {
      url: base_url + "Caja/ListarRecibos",
      dataSrc: "",
    },
    columns: [
      { data: "ID", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "IN_RESPONSABLE" },
      { data: "IN_MONTO", className: "text-center" },
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

  TblLrE_data = $("#TblCajaReciboEgreso").DataTable({
    ajax: {
      url: base_url + "Caja/ListarRecibosEgreso",
      dataSrc: "",
    },
    columns: [
      { data: "ID", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "SAL_RESPONSABLE" },
      { data: "SAL_MONTO", className: "text-center" },
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

  TblRC_data = $("#TblResumenCaja").DataTable({
    ajax: {
      url: base_url + "Caja/ListaResumenCaja",
      dataSrc: "",
    },
    columns: [
      { data: "FECHA", className: "text-center" },
      { data: "MONTO", className: "text-center" },
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

  btnNuevoIngreso.addEventListener("click", function (e) {
    e.preventDefault();
    frmNI.reset();
    frmNI.ID_IN.value = "";
    frmNI.classList.remove("was-validated");
    ModalNuevoIngresoOpen.show();
  });

  btnNuevoEgreso.addEventListener("click", function (e) {
    e.preventDefault();
    frmNE.reset();
    frmNE.ID.value = "";
    frmNE.classList.remove("was-validated");
    ModalNuevoEgresoOpen.show();
  });

  btnNuevoIngresoRecibo.addEventListener("click", function (e) {
    e.preventDefault();
    frmNICR.reset();
    frmNICR.ID_IN.value = "";
    IdMax();
    frmNICR.classList.remove("was-validated");
    ModalNuevoIngresoCROpen.show();
  });

  btnNuevoEgresoCR.addEventListener("click", function (e) {
    e.preventDefault();
    frmNECR.reset();
    frmNECR.ID.value = "";
    IdMaxEgreso();
    frmNICR.classList.remove("was-validated");
    ModalNuevoEgresoCROpen.show();
  });

  btnListaRecibos.addEventListener("click", function (e) {
    e.preventDefault();
    ModalListaRecibosOpen.show();
  });

  btnListaRecibosEgreso.addEventListener("click", function (e) {
    e.preventDefault();
    ModalListaRecibosEgresoOpen.show();
  });

  btnCerrarCaja.addEventListener("click", function (e) {
    e.preventDefault();
    CerrarCaja();
  });

  btnResumenCaja.addEventListener("click", function (e) {
    e.preventDefault();
    ModalResumenCajasOpen.show();
  });

  btnExcel.addEventListener("click", function (e) {
    e.preventDefault();
    const url = base_url + "Caja/ReportExcel";
    window.open(url);
  });

  frmNI.addEventListener("submit", handleFrmNI, false);
  frmNE.addEventListener("submit", handleFrmNE, false);
  frmNICR.addEventListener("submit", handleFrmNICR, false);
  frmNECR.addEventListener("submit", handleFrmNECR, false);
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
          AlertaPerzonalizada(res.tipo, res.msg);
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
          AlertaPerzonalizada(res.tipo, res.msg);
          if (res.tipo == "success") {
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

function handleFrmNICR(event) {
  event.preventDefault();
  const FrmNICRH = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmNICRH.checkValidity()) {
    event.stopPropagation();
  } else {
    btnRegistrarNICR.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnRegistrarNICR.disabled = true;

    const url = base_url + "Caja/RegistrarIngreso";
    const data = new FormData(FrmNICRH);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo == "success" && res.condicion == "registrado") {
          RegistrarRecibo(res.id);
        } else if (res.tipo == "success" && res.condicion == "modificado") {
          TblNI_data.ajax.reload();
          TblLR_data.ajax.reload();
          btnRegistrarNICR.innerHTML = "Registrar";
          btnRegistrarNICR.disabled = false;
          ReciboPdf(FrmNICRH.ID_IN.value);
          TotalIngresos();
          TotalEgresos();
          RestaTotal();
          ModalNuevoIngresoCROpen.hide();
        } else {
          AlertaPerzonalizada(res.tipo, res.msg);
          btnRegistrarNICR.innerHTML = "Registrar";
          btnRegistrarNICR.disabled = false;
        }
      }
    };
  }
  FrmNICRH.classList.add("was-validated");
}

function handleFrmNECR(event) {
  event.preventDefault();
  const FrmNECRH = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmNECRH.checkValidity()) {
    event.stopPropagation();
  } else {
    btnRegistrarNECR.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnRegistrarNECR.disabled = true;

    const url = base_url + "Caja/RegistrarEgreso";
    const data = new FormData(FrmNECRH);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo == "success" && res.condicion == "registrado") {
          RegistrarReciboEgreso(res.id);
        } else if (res.tipo == "success" && res.condicion == "modificado") {
          TblNE_data.ajax.reload();
          TblLR_data.ajax.reload();
          btnRegistrarNECR.innerHTML = "Registrar";
          btnRegistrarNECR.disabled = false;
          ReciboPDFEgreso(FrmNECRH.ID.value);
          TotalIngresos();
          TotalEgresos();
          RestaTotal();
          ModalNuevoEgresoCROpen.hide();
        } else {
          AlertaPerzonalizada(res.tipo, res.msg);
          btnRegistrarNECR.innerHTML = "Registrar";
          btnRegistrarNECR.disabled = false;
        }
      }
    };
  }
  FrmNECRH.classList.add("was-validated");
}


function TotalIngresos() {
  const url = base_url + "Caja/TotalIngresos";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.IN_TOTAL == null) {
        $("#TI").html("S/. 0.00");
      } else {
        $("#TI").html("S/. " + res.IN_TOTAL);
      }
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
      if (res.SAL_TOTAL == null) {
        $("#TE").html("S/. 0.00");
      } else {
        $("#TE").html("S/. " + res.SAL_TOTAL);
      }
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
      frmNI.ID_IN.value = res.IN_ID;
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

function EliminarIngres(id) {
  Swal.fire({
    title: "¿Deseas Eliminar el ingreso?",
    text: "El ingreso será eliminado del sistema",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + `Caja/EliminarIngreso/${id}`;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          AlertaPerzonalizada(res.tipo, res.mensaje);
          TblNI_data.ajax.reload();
          TblLR_data.ajax.reload();
          TotalIngresos();
          TotalEgresos();
          RestaTotal();
        }
      };
    }
  });
}

function EliminarEgres(id) {
  Swal.fire({
    title: "¿Deseas Eliminar el egreso?",
    text: "El egreso será eliminado del sistema",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + `Caja/EliminarEgreso/${id}`;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          AlertaPerzonalizada(res.tipo, res.msg);
          TblNE_data.ajax.reload();
          TblNE_data.ajax.reload();
          TotalIngresos();
          TotalEgresos();
          RestaTotal();
        }
      };
    }
  });
}

function MostrarEgresos(id) {
  const url = base_url + `Caja/MostrarEgresos/${id}`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      frmNE.reset();
      frmNE.classList.remove("was-validated");
      frmNE.ID.value = res.SAL_ID;
      frmNE.Tranx.value = res.SAL_TRANSACCION;
      frmNE.Responsable.value = res.SAL_RESPONSABLE;
      frmNE.Comprobante.value = res.SAL_COMPROBANTE;
      frmNE.NCom.value = res.SAL_NCOMPRO;
      frmNE.TipPago.value = res.SAL_TIP_PAGO;
      frmNE.Area.value = res.SAL_AREA;
      frmNE.Dsc.value = res.SAL_DESCRIPCION;
      frmNE.Monto.value = res.SAL_MONTO;
      ModalNuevoEgresoOpen.show();
    }
  };
}

function IdMax() {
  const url = base_url + `Caja/IDMaxRecibo`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.ID == null) {
        frmNICR.NCom.value = "001";
      } else {
        frmNICR.NCom.value = "00" + (parseInt(res.ID) + 1);
      }
    }
  };
}

function IdMaxEgreso() {
  const url = base_url + `Caja/IdMaxReciboEgreso`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.ID == null) {
        frmNECR.NCom.value = "001";
      } else {
        frmNECR.NCom.value = "00" + (parseInt(res.ID) + 1);
      }
    }
  };
}

function RegistrarRecibo(id) {
  const url = base_url + `Caja/RegistrarRecibo/${id}`;
  const data = new FormData(frmNECR);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      setTimeout(function () {
        AlertaPerzonalizada(res.tipo, res.msg);
        if (res.tipo == "success") {
          TblNI_data.ajax.reload();
          TblLR_data.ajax.reload();
          btnRegistrarNICR.innerHTML = "Registrar";
          btnRegistrarNICR.disabled = false;
          ReciboPdf(id);
          TotalIngresos();
          TotalEgresos();
          RestaTotal();
          ModalNuevoIngresoCROpen.hide();
        } else {
          AlertaPerzonalizada(res.tipo, res.msg);
          btnRegistrarNICR.innerHTML = "Registrar";
          btnRegistrarNICR.disabled = false;
        }
      }, 3000);
    }
  };
}

function RegistrarReciboEgreso(id) {
  const url = base_url + `Caja/RegistrarReciboEgreso/${id}`;
  const data = new FormData(frmNECR);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      setTimeout(function () {
        AlertaPerzonalizada(res.tipo, res.msg);
        if (res.tipo == "success") {
          TblNE_data.ajax.reload();
          TblLR_data.ajax.reload();
          btnRegistrarNECR.innerHTML = "Registrar";
          btnRegistrarNECR.disabled = false;
          ReciboPDFEgreso(id);
          TotalIngresos();
          TotalEgresos();
          RestaTotal();
          ModalNuevoEgresoCROpen.hide();
        } else {
          AlertaPerzonalizada(res.tipo, res.msg);
          btnRegistrarNECR.innerHTML = "Registrar";
          btnRegistrarNECR.disabled = false;
        }
      }, 3000);
    }
  };
}

function ReciboPdf(id) {
  const url = base_url + `Caja/ReciboPDF/${id}`;
  window.open(url, "_blank");
}

function ReciboPDFEgreso(id) {
  const url = base_url + `Caja/ReciboPDFEgreso/${id}`;
  window.open(url, "_blank");
}

function MostrarIngresosRecibo(id) {
  const url = base_url + `Caja/MostrarIngresos/${id}`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      frmNICR.reset();
      frmNICR.classList.remove("was-validated");
      frmNICR.ID_IN.value = res.IN_ID;
      frmNICR.Tranx.value = res.IN_TRANSACCION;
      frmNICR.Responsable.value = res.IN_RESPONSABLE;
      frmNICR.Comprobante.value = res.IN_COMPROBANTE;
      frmNICR.NCom.value = res.IN_NCOMPRO;
      frmNICR.TipPago.value = res.IN_TIP_PAGO;
      frmNICR.Area.value = res.IN_AREA;
      frmNICR.Dsc.value = res.IN_DESCRIPCION;
      frmNICR.Monto.value = res.IN_MONTO;
      ModalNuevoIngresoCROpen.show();
    }
  };
}

function MostrarEgresosRecibo(id) {
  const url = base_url + `Caja/MostrarEgresos/${id}`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      frmNECR.reset();
      frmNECR.classList.remove("was-validated");
      frmNECR.ID.value = res.SAL_ID;
      frmNECR.Tranx.value = res.SAL_TRANSACCION;
      frmNECR.Responsable.value = res.SAL_RESPONSABLE;
      frmNECR.Comprobante.value = res.SAL_COMPROBANTE;
      frmNECR.NCom.value = res.SAL_NCOMPRO;
      frmNECR.TipPago.value = res.SAL_TIP_PAGO;
      frmNECR.Area.value = res.SAL_AREA;
      frmNECR.Dsc.value = res.SAL_DESCRIPCION;
      frmNECR.Monto.value = res.SAL_MONTO;
      ModalNuevoEgresoCROpen.show();
    }
  };
}

function CerrarCaja() {
  Swal.fire({
    title: "¿Deseas Cerrar caja?",
    text: "",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + `Caja/CerrarCaja`;
      window.open(url, "_blank");
      TblRC_data.ajax.reload();
    }
  });
}

function VerPDFcaja(id) {
  const url = base_url + `Caja/VerPDFCaja/${id}`;
  window.open(url, "_blank");
}

function EliminarCerrarCaja(id) {
  const url = base_url + `Caja/EliminarResumenCaja/${id}`;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo == "success") {
        TblRC_data.ajax.reload();
      }
    }
  };
}
