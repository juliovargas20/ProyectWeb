let TblCentroSData;
let TblOrData;

const FrmCenSa = document.querySelector("#FrmCenSa");
const FrmOr = document.querySelector("#FrmOR");

const ModalCentro = document.querySelector("#Centro");
const ModalOpenCentro = new bootstrap.Modal(ModalCentro);
const ModalOr = document.querySelector("#OrtopediaModal");
const ModalOpenOr = new bootstrap.Modal(ModalOr);

const DivOr = document.querySelector("#divOr");
const DivVisme = document.querySelector("#DivVisme");

const btnvisme = document.getElementById("btnVisme");
const btnOr = document.getElementById("btnOr");



document.addEventListener("DOMContentLoaded", function () {
  TblCentroSData = $("#TblCentroS").DataTable({
    ajax: {
      url: base_url + "Citas/Listar",
      dataSrc: "",
    },
    columns: [
      { data: "CENSALUD" },
      { data: "horas", className: "text-center" },
      { data: "NOMDOC", className: "text-center" },
      { data: "VISITADOR", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    columnDefs: [
      {
        targets: 1,
        width: "200px",
      },
      {
        targets: 3,
        width: "100px",
      },
    ],
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
        text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-md-inline-block d-none">Registrar Visita Médica</span>',
        className: "btn btn-dark",
        attr: {
          type: "button",
          onclick: "AbrirModalCentro()",
        },
      },
    ],
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return "Details of " + data["CENSALUD"];
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

  TblOrData = $("#TblOr").DataTable({
    ajax: {
      url: base_url + "Citas/ListarOr",
      dataSrc: "",
    },
    columns: [
      { data: "TIENDA" },
      { data: "horas", className: "text-center" },
      { data: "NOMENC", className: "text-center" },
      { data: "VISITADOR", className: "text-center" },
      { data: "FECHA", className: "text-center" },
      { data: "ACCIONES", className: "text-center" },
    ],
    columnDefs: [
      {
        targets: 1,
        width: "200px",
      },
      {
        targets: 3,
        width: "100px",
      },
    ],
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
        text: '<i class="mdi mdi-plus me-md-1"></i><span class="d-md-inline-block d-none">Registrar Ortopedia</span>',
        className: "btn btn-dark",
        attr: {
          type: "button",
          onclick: "AbrirModalOr()",
        },
      },
    ],
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return "Details of " + data["TIENDA"];
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
  
  FrmCenSa.addEventListener("submit", handleFrmCenSa, false);
  FrmOr.addEventListener("submit", handleFrmOr, false);

});

function AbrirModalCentro() {
  FrmCenSa.reset();
  FrmCenSa.Etime.removeAttribute("readonly");
  FrmCenSa.Stime.removeAttribute("readonly");
  FrmCenSa.CenSalud.removeAttribute("readonly");
  FrmCenSa.NomDoc.removeAttribute("readonly");
  FrmCenSa.TimeVis.removeAttribute("readonly");
  FrmCenSa.Desarrollo.removeAttribute("readonly");
  FrmCenSa.Conclusion.removeAttribute("readonly");
  FrmCenSa.Correo.removeAttribute("readonly");
  FrmCenSa.Celular.removeAttribute("readonly");
  FrmCenSa.FechaNac.removeAttribute("readonly");
  DivVisme.style.display = "block";
  ModalOpenCentro.show();
}

function visualizarCentro(id) {
  const url = base_url + "Citas/MostrarCenSa/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      FrmCenSa.Etime.value = res.INICIO;
      FrmCenSa.Etime.setAttribute("readonly", true);

      FrmCenSa.Stime.value = res.SALIDA;
      FrmCenSa.Stime.setAttribute("readonly", true);

      FrmCenSa.CenSalud.value = res.CENSALUD;
      FrmCenSa.CenSalud.setAttribute("readonly", true);

      FrmCenSa.NomDoc.value = res.NOMDOC;
      FrmCenSa.NomDoc.setAttribute("readonly", true);

      FrmCenSa.TimeVis.value = res.TIME;
      FrmCenSa.TimeVis.setAttribute("readonly", true);

      FrmCenSa.Desarrollo.value = res.DESARROLLO;
      FrmCenSa.Desarrollo.setAttribute("readonly", true);

      FrmCenSa.Conclusion.value = res.CONCLUSION;
      FrmCenSa.Conclusion.setAttribute("readonly", true);

      FrmCenSa.Correo.value = res.CORREO;
      FrmCenSa.Correo.setAttribute("readonly", true);

      FrmCenSa.Celular.value = res.CELULAR;
      FrmCenSa.Celular.setAttribute("readonly", true);

      FrmCenSa.FechaNac.value = res.FECHANAC;
      FrmCenSa.FechaNac.setAttribute("readonly", true);

      DivVisme.style.display = "none";
      ModalOpenCentro.show();
    }
  };
}

function AbrirModalOr() {
  FrmOr.reset();
  FrmOr.EtimeOr.removeAttribute("readonly");
  FrmOr.StimeOr.removeAttribute("readonly");
  FrmOr.Tienda.removeAttribute("readonly");
  FrmOr.NomEnc.removeAttribute("readonly");
  FrmOr.TimeOr.removeAttribute("readonly");
  FrmOr.DesarrolloOr.removeAttribute("readonly");
  FrmOr.ConclusionOr.removeAttribute("readonly");
  FrmOr.CorreoOr.removeAttribute("readonly");
  FrmOr.CelularOr.removeAttribute("readonly");
  FrmOr.Ruc.removeAttribute("readonly");
  DivOr.style.display = "block";
  ModalOpenOr.show();
}

function visualizarOR(id) {
  const url = base_url + "Citas/MostrarOr/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      FrmOr.EtimeOr.value = res.INICIO;
      FrmOr.EtimeOr.setAttribute("readonly", true);

      FrmOr.StimeOr.value = res.SALIDA;
      FrmOr.StimeOr.setAttribute("readonly", true);

      FrmOr.Tienda.value = res.TIENDA;
      FrmOr.Tienda.setAttribute("readonly", true);

      FrmOr.NomEnc.value = res.NOMENC;
      FrmOr.NomEnc.setAttribute("readonly", true);

      FrmOr.TimeOr.value = res.TIME;
      FrmOr.TimeOr.setAttribute("readonly", true);

      FrmOr.DesarrolloOr.value = res.DESARROLLO;
      FrmOr.DesarrolloOr.setAttribute("readonly", true);

      FrmOr.ConclusionOr.value = res.CONCLUSION;
      FrmOr.ConclusionOr.setAttribute("readonly", true);

      FrmOr.CorreoOr.value = res.CORREO;
      FrmOr.CorreoOr.setAttribute("readonly", true);

      FrmOr.CelularOr.value = res.CELULAR;
      FrmOr.CelularOr.setAttribute("readonly", true);

      FrmOr.Ruc.value = res.RUC;
      FrmOr.Ruc.setAttribute("readonly", true);

      DivOr.style.display = "none";
      ModalOpenOr.show();
    }
  };
}



function handleFrmCenSa(event) {
  event.preventDefault();
  const FrmCenSa = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmCenSa.checkValidity()) {
    event.stopPropagation();
  } else {
    btnvisme.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;

    const url = base_url + "Citas/RegistrarVisme";
    const data = new FormData(FrmCenSa);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (http.readyState == 4 && http.status == 200) {
        const res = JSON.parse(http.responseText);
        setTimeout(function () {
          AlertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            btnvisme.innerHTML = "Registrar";
            FrmCenSa.reset();
            ModalOpenCentro.hide();
            TblCentroSData.ajax.reload();
          } else {
            btnvisme.innerHTML = "Guardar";
          }
        }, 3000);
      }
    };
  }
  FrmCenSa.classList.add("was-validated");
}



function handleFrmOr(event) {
  event.preventDefault();
  const FrmOr = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmOr.checkValidity()) {
    event.stopPropagation();
  } else {
    btnOr.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;

    const url = base_url + "Citas/RegistrarOR";
    const data = new FormData(FrmOr);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);
    http.onreadystatechange = function () {
      if (http.readyState == 4 && http.status == 200) {
        const res = JSON.parse(http.responseText);
        setTimeout(function () {
          AlertaPerzonalizada(res.tipo, res.mensaje);
          if (res.tipo == "success") {
            btnOr.innerHTML = "Registrar";
            FrmOr.reset();
            ModalOpenOr.hide();
            TblOrData.ajax.reload();
          } else {
            btnOr.innerHTML = "Guardar";
          }
        }, 3000);
      }
    };
  }
  FrmOr.classList.add("was-validated");
}