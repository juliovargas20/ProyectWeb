let TblrolData;
const btncancel = $("#BtnCancelRolPer");
const btnres = $("#BtnRegistroRolPer");
const btnUpres = $("#BtnUpdateRolPer");
const frmRol = document.querySelector("#FrmRegistroRol");
const frmPer = document.querySelector("#FrmRegistroPermiso");
const frmUpRol = document.querySelector("#FrmUpdateRol");
const frmUpPer = document.querySelector("#FrmUpdatePermiso");

document.addEventListener("DOMContentLoaded", function () {
  $(function () {
    TblrolData = $("#TblRoles").DataTable({
      ajax: {
        url: base_url + "Usuarios/ListarCaja",
        dataSrc: "",
      },
      columns: [
        { data: "ID", className: "text-center" },
        { data: "CAJA" },
        { data: "ESTADO", className: "text-center" },
        { data: "ACCIONES", className: "text-center" },
      ],
      dom:
        '<"row mx-1"' +
        '<"col-sm-12 col-md-3" l>' +
        '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>' +
        ">t" +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        ">",
      buttons: [
        {
          text: '<i class="mdi mdi-plus me-1"></i> <span class="d-none d-lg-inline-block">Agregar Nuevo Rol y Permiso</span>',
          className: "Off-Usuarios btn btn-primary",
          attr: {
            type: "button",
            id: "",
            onclick: "AbrirRegistro()",
          },
        },
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return "Detalles de " + data["CAJA"];
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

  btnres.on("click", function (e) {
    e.preventDefault();
    RegistrarRol();
  });

  btnUpres.on('click', function (e) {
    e.preventDefault();
    UpdateRol();
  });

  btncancel.on("click", function (e) {
    e.preventDefault();
    window.location.href = base_url + "Usuarios/rol";
  });

});

function AbrirRegistro() {
  window.location.href = base_url + "Usuarios/registro";
}

function RegistrarRol() {
  const url = base_url + "Usuarios/RegistrarRol";
  const data = new FormData(frmRol);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo == "success") {
        RegistrarPermisos();
      }
    }
  };
}

function UpdateRol() {
  const id = document.getElementById("idROl").value;
  const url = base_url + "Usuarios/UpdateRol";
  const data = new FormData(frmUpRol);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo == "success") {
        UpdatePermisos(id)
      }
    }
  };
}

function RegistrarPermisos() {
  const url = base_url + "Usuarios/RegistrarPermiso";
  const data = new FormData(frmPer);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      const downloadSpeedMbps = getDownloadSpeedMbps();
      const timeoutDuration = calculateTimeoutDuration(downloadSpeedMbps);

      Swal.fire({
        icon: res.tipo,
        title: res.mensaje,
        showConfirmButton: true,
        timer: timeoutDuration,
        didClose: () => {
          if ((res.tipo = "success")) {
            window.location.href = base_url + "Usuarios/rol";
          }
        },
      });
    }
  };
}

function UpdatePermisos(id) {
  const url = base_url + "Usuarios/UpdatePermiso/" + id;
  const data = new FormData(frmUpPer);
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(data);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      const downloadSpeedMbps = getDownloadSpeedMbps();
      const timeoutDuration = calculateTimeoutDuration(downloadSpeedMbps);

      Swal.fire({
        icon: res.tipo,
        title: res.mensaje,
        showConfirmButton: true,
        timer: timeoutDuration,
        didClose: () => {
          if ((res.tipo = "success")) {
            window.location.href = base_url + "Usuarios/rol";
          }
        },
      });
    }
  };
}


function EliminarRol(id) {
  const url = base_url + "Usuarios/EliminarRol/" + id;

  Eliminar('¿Está Seguro de dar de Baja?', 'El Rol no se eliminará, permanecerá en estado Inactivo', 'Sí, dar de Baja', url, TblrolData)
}

function ActivarRol(id) {
  const url = base_url + "Usuarios/ActivarRol/" + id;

  Eliminar('¿Está Seguro de Activar el Rol?', 'El Rol sera activado y tendra acceso al sistema', 'Sí, Activar', url, TblrolData)
}

function updateRol(id) {
  window.location.href = base_url + "Usuarios/modificar/" + id;
}