const previewTemplate = `
    <div class="dz-preview dz-file-preview">
        <div class="dz-details">
            <div class="dz-thumbnail">
                <img data-dz-thumbnail>
                <span class="dz-nopreview">No preview</span>
                <div class="dz-success-mark"></div>
                <div class="dz-error-mark"></div>
                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                <div class="progress">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
                </div>
            </div>
            <div class="dz-filename" data-dz-name></div>
            <div class="dz-size" data-dz-size></div>
        </div>
    </div>
`;
let res;

const pros = document.querySelector("#PrFG").value;
const brn = document.querySelector("#btnMain");
const tip = document.querySelector("#TM").value;
const esd = document.querySelector("#esd");

const p1 = document.querySelector("#P1");
const p2 = document.querySelector("#P2");
const p3 = document.querySelector("#P3");
const p4 = document.querySelector("#P4");

const pros1 = document.querySelector("#pros1");
const pros2 = document.querySelector("#pros2");
const pros3 = document.querySelector("#pros3");
const pros4 = document.querySelector("#pros4");

const btn = document.querySelector("#ProcesoFin");

const btnHistorialRegistro = document.querySelector("#btnhisto");

const ModalHistorial = document.querySelector("#ModalHistorial");
const ModalOpenHistorial = new bootstrap.Modal(ModalHistorial);

document.addEventListener("DOMContentLoaded", function () {
  ListarHisto();

  const dropzoneBasic = document.querySelector("#dropzone-basic");

  const myDropzone = new Dropzone(dropzoneBasic, {
    previewTemplate: previewTemplate,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFilesize: 256,
    addRemoveLinks: true,
    maxFiles: 6,

    init: function () {
      var myDropzone = this;

      // First change the button to actually tell Dropzone to process the queue.
      btnHistorialRegistro.addEventListener("click", function (e) {
          // Make sure that the form isn't actually being sent.
          e.preventDefault();

          RegistarHisto(function () {
            myDropzone.processQueue(); // Procesar la cola de imágenes después del registro
          }); // Procesar la cola de imágenes después del registro

          e.stopPropagation();
        });

      this.on("successmultiple", function (files, response) {
        Swal.fire({
          icon: res.tipo,
          title: res.mensaje,
          showConfirmButton: true,
          timer: 3000,
          didClose: () => {
            if ((res.tipo = "success")) {
              window.location.reload();
            }
          },
        });
        ModalOpenHistorial.hide();
      });
    },
  });

  if (pros == 1) {
    if (tip == "Miembro Inferior") {
      brn.innerHTML = "Toma de Molde";
      esd.innerHTML = "Toma de Molde";
    }

    if (tip == "Miembro Superior") {
      brn.innerHTML = "Escaneo y Toma de medidas";
      esd.innerHTML = "Escaneo y Toma de medidas";
    }

    if (tip == "Estética") {
      brn.innerHTML = "Toma de Molde";
      esd.innerHTML = "Toma de Molde";
    }
  }

  if (pros == 2) {
    if (tip == "Miembro Inferior") {
      p1.innerHTML = "Toma de Molde";
      brn.innerHTML = "Prueba de Encaje";
      esd.innerHTML = "Prueba de Encaje";
    }

    if (tip == "Miembro Superior") {
      p1.innerHTML = "Escaneo y Toma de medidas";
      brn.innerHTML = "Pruebas de Encaje";
      esd.innerHTML = "Pruebas de Encaje";
    }

    if (tip == "Estética") {
      p1.innerHTML = "Toma de Molde";
      brn.innerHTML = "Moldeado o Escultura";
      esd.innerHTML = "Moldeado o Escultura";
    }

    pros1.style.display = "block";
    Res1();
  }

  if (pros == 3) {
    if (tip == "Miembro Inferior") {
      p1.innerHTML = "Toma de Molde";
      p2.innerHTML = "Prueba de Encaje";
      brn.innerHTML = "Prueba de Marcha";
      esd.innerHTML = "Prueba de Marcha";
    }

    if (tip == "Miembro Superior") {
      p1.innerHTML = "Escaneo y Toma de medidas";
      p2.innerHTML = "Pruebas de Encaje";
      brn.innerHTML = "Prueba de Función y Alineación";
      esd.innerHTML = "Prueba de Función y Alineación";
    }

    if (tip == "Estética") {
      p1.innerHTML = "Toma de Molde";
      p2.innerHTML = "Moldeado o Escultura";
      brn.innerHTML = "Prueba de Succión";
      esd.innerHTML = "Prueba de Succión";
    }

    pros1.style.display = "block";
    pros2.style.display = "block";
    Res1();
    Res2();
  }

  if (pros == 4) {
    if (tip == "Miembro Inferior") {
      p1.innerHTML = "Toma de Molde";
      p2.innerHTML = "Prueba de Encaje";
      p3.innerHTML = "Prueba de Marcha";
      brn.innerHTML = "Encaje Final";
      esd.innerHTML = "Encaje Final";
    }

    if (tip == "Miembro Superior") {
      p1.innerHTML = "Escaneo y Toma de medidas";
      p2.innerHTML = "Pruebas de Encaje";
      p3.innerHTML = "Prueba de Función y Alineación";
      brn.innerHTML = "Encaje Final";
      esd.innerHTML = "Encaje Final";
    }

    if (tip == "Estética") {
      p1.innerHTML = "Toma de Molde";
      p2.innerHTML = "Moldeado o Escultura";
      p3.innerHTML = "Prueba de Succión";
      brn.innerHTML = "Encaje Final";
      esd.innerHTML = "Encaje Final";
    }

    pros1.style.display = "block";
    pros2.style.display = "block";
    pros3.style.display = "block";
    Res1();
    Res2();
    Res3();
  }

  if (pros == 10) {
    if (tip == "Miembro Inferior") {
      p1.innerHTML = "Toma de Molde";
      p2.innerHTML = "Prueba de Encaje";
      p3.innerHTML = "Prueba de Marcha";
      p4.innerHTML = "Encaje Final";
      brn.innerHTML = "Historial";
      esd.innerHTML = "Historial";
    }

    if (tip == "Miembro Superior") {
      p1.innerHTML = "Escaneo y Toma de medidas";
      p2.innerHTML = "Pruebas de Encaje";
      p3.innerHTML = "Prueba de Función y Alineación";
      p4.innerHTML = "Encaje Final";
      brn.innerHTML = "Historial";
      esd.innerHTML = "Historial";
    }

    if (tip == "Estética") {
      p1.innerHTML = "Toma de Molde";
      p2.innerHTML = "Moldeado o Escultura";
      p3.innerHTML = "Prueba de Succión";
      p4.innerHTML = "Encaje Final";
      brn.innerHTML = "Historial";
      esd.innerHTML = "Historial";
    }

    btn.style.display = "none";
    pros1.style.display = "block";
    pros2.style.display = "block";
    pros3.style.display = "block";
    pros4.style.display = "block";
    Res1();
    Res2();
    Res3();
    Res4();
  }
});

function AbrirModal() {
  ModalOpenHistorial.show();
}

function RegistarHisto(callback) {
  var des = document.getElementById("Descripcion");

  if (des.value == "") {
    Swal.fire("Oops...", "Completo los campos Vacíos", "error");
  } else {
    const url = base_url + "Historial/Registrar";
    const frm = document.getElementById("FrmHistorial");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        res = JSON.parse(this.responseText);
        if (res.tipo == "success") {
          if (typeof callback === "function") {
            callback();
          }
        } else {
          Swal.fire("Oops...", res.tipo, "error");
        }
      }
    };
  }
}

function ListarHisto() {
  const url = base_url + "Historial/ListarHistorial";
  const frm = document.getElementById("FrmFG");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-none bg-transparent border border-danger mb-3" style="border-radius: 10px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" id="IDHistoD" value="">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" value="${row["FECHACITA"]}" placeholder="Fecha" readonly>
                                    <label for="">Fecha</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" value="${row["TECNICO"]}" placeholder="Encargado" readonly>
                                    <label for="">Encargado</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <textarea class="form-control h-px-150" placeholder="Descripción" readonly>${row["DESCRIPCION"]}</textarea>
                                <label>Descripcion</label>
                            </div>
                        </div>
                        <div class="IMG">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary btn-sm" onclick="Descargar(${row['ID']})">Ver Fotos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
      });
      $("#ResHis").html(html);
    }
  };
}

function Proceso(id, proceso) {
  Swal.fire({
    title: "¿Esta Seguro?",
    text: "¿Deseas Finalizar el Proceso?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, Finalizar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Historial/Proceso";
      const data = {
        id: id,
        proceso: proceso,
      };
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Swal.fire({
            icon: res.tipo,
            title: res.mensaje,
            showConfirmButton: true,
            timer: 2000,
            didClose: () => {
              if ((res.tipo = "success")) {
                window.location.href = base_url + "Historial";
              }
            },
          });
        }
      };
      http.send(JSON.stringify(data));
    }
  });
}

function Res1() {
  const url = base_url + "Historial/Res1";
  const frm = document.getElementById("FrmFG");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
            <div class="col-md-6 col-xl-4">
                <div class="card shadow-none bg-transparent border border-danger mb-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="hidden" id="IDHistoD" value="">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["FECHACITA"]}" placeholder="Fecha" readonly>
                                        <label for="">Fecha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["TECNICO"]}" placeholder="Encargado" readonly>
                                        <label for="">Encargado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <textarea class="form-control h-px-150" placeholder="Descripción" readonly>${row["DESCRIPCION"]}</textarea>
                                    <label>Descripcion</label>
                                </div>
                            </div>
                            <div class="IMG">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="Descargar(${row['ID']})">Ver Fotos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
      });
      $("#ResumenAnt1").html(html);
    }
  };
}

function Res2() {
  const url = base_url + "Historial/Res2";
  const frm = document.getElementById("FrmFG");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
            <div class="col-md-6 col-xl-4">
                <div class="card shadow-none bg-transparent border border-danger mb-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="hidden" id="IDHistoD" value="">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["FECHACITA"]}" placeholder="Fecha" readonly>
                                        <label for="">Fecha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["TECNICO"]}" placeholder="Encargado" readonly>
                                        <label for="">Encargado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <textarea class="form-control h-px-150" placeholder="Descripción" readonly>${row["DESCRIPCION"]}</textarea>
                                    <label>Descripcion</label>
                                </div>
                            </div>
                            <div class="IMG">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="Descargar(${row['ID']})">Ver Fotos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
      });
      $("#ResumenAnt2").html(html);
    }
  };
}

function Res3() {
  const url = base_url + "Historial/Res3";
  const frm = document.getElementById("FrmFG");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
            <div class="col-md-6 col-xl-4">
                <div class="card shadow-none bg-transparent border border-danger mb-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="hidden" id="IDHistoD" value="">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["FECHACITA"]}" placeholder="Fecha" readonly>
                                        <label for="">Fecha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["TECNICO"]}" placeholder="Encargado" readonly>
                                        <label for="">Encargado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <textarea class="form-control h-px-150" placeholder="Descripción" readonly>${row["DESCRIPCION"]}</textarea>
                                    <label>Descripcion</label>
                                </div>
                            </div>
                            <div class="IMG">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="Descargar(${row['ID']})">Ver Fotos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
      });
      $("#ResumenAnt3").html(html);
    }
  };
}

function Res4() {
  const url = base_url + "Historial/Res4";
  const frm = document.getElementById("FrmFG");
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
            <div class="col-md-6 col-xl-4">
                <div class="card shadow-none bg-transparent border border-danger mb-3" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <input type="hidden" id="IDHistoD" value="">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-calendar-range"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["FECHACITA"]}" placeholder="Fecha" readonly>
                                        <label for="">Fecha</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-doctor"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" value="${row["TECNICO"]}" placeholder="Encargado" readonly>
                                        <label for="">Encargado</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <textarea class="form-control h-px-150" placeholder="Descripción" readonly>${row["DESCRIPCION"]}</textarea>
                                    <label>Descripcion</label>
                                </div>
                            </div>
                            <div class="IMG">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="Descargar(${row['ID']})">Ver Fotos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
      });
      $("#ResumenAnt4").html(html);
    }
  };
}

function Descargar(id) {
  window.location.href = base_url + 'Historial/Descargar/' + id;
}
