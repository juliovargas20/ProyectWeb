const selectPaciente = $(".select2");
const tip = $("#Servicio");
const sub = $("#Trabajo");

const SelectPacienteManual = $("#IdPacienteManual");
const tipManual = $("#ServicioManual");
const subManual = $("#TrabajoManual");

const btnGen = document.querySelector("#btnGenerar");
const btnItem = document.querySelector("#btnItem");

const btnItemManual = document.querySelector("#btnItemManual");
const btnGenManual = document.querySelector("#btnManualCoti");

const ModalManual = document.querySelector("#ModalManualCoti");
const ModalOpenManual = new bootstrap.Modal(ModalManual);

document.addEventListener("DOMContentLoaded", function () {
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  tip.hide();
  sub.hide();

  selectPaciente.each(function () {
    var $this = $(this);
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: "Seleccionar Paciente",
      dropdownParent: $this.parent(),
    });
  });

  btnGen.addEventListener("click", habdleFrmOri, false);

  btnGenManual.addEventListener("click", handleFrm, false);

  btnItem.addEventListener("click", function () {
    const mpmContainer = document.getElementById("FrmLista");

    const divFormGroup = document.createElement("div");
    divFormGroup.classList.add("input-group", "mb-2");

    const nuevoItem = document.createElement("input");
    nuevoItem.setAttribute("type", "text");
    nuevoItem.setAttribute("required", "true");
    nuevoItem.classList.add("form-control");

    const btnEliminar = document.createElement("button");
    btnEliminar.innerHTML = "<i class='mdi mdi-trash-can-outline me-1'></i>";
    btnEliminar.classList.add("btn", "btn-outline-danger");
    btnEliminar.addEventListener("click", function () {
      mpmContainer.removeChild(divFormGroup);
    });

    divFormGroup.appendChild(nuevoItem);
    divFormGroup.appendChild(btnEliminar);

    // Agregar la fila al formulario
    mpmContainer.appendChild(divFormGroup);
  });

  btnItemManual.addEventListener("click", function () {
    const mpmContainer = document.getElementById("FrmListaManual");

    const divFormGroup = document.createElement("div");
    divFormGroup.classList.add("input-group");

    const nuevoItem = document.createElement("input");
    nuevoItem.setAttribute("type", "text");
    nuevoItem.setAttribute("required", "true");
    nuevoItem.classList.add("form-control");

    const btnEliminar = document.createElement("button");
    btnEliminar.innerHTML = "<i class='mdi mdi-trash-can-outline me-1'></i>";
    btnEliminar.classList.add("btn", "btn-outline-danger");
    btnEliminar.addEventListener("click", function () {
      mpmContainer.removeChild(divFormGroup);
    });

    divFormGroup.appendChild(nuevoItem);
    divFormGroup.appendChild(btnEliminar);

    // Agregar la fila al formulario
    mpmContainer.appendChild(divFormGroup);
  });
});
let listadoGenerado = false;

/************* LOGICA DE LOS MIEMBROS SUPERIORES Y ESTETICA *************/
const tiposTrabajo = {
  //Miembros Superiores
  "Mano Completa Biónica": mcb_data,
  "Falange Mecánica": fm_data,
  "Protesis Transhumeral tipo gancho con guante cosmético (Fillauer)":
    transh_data,
  "Protesis Transhumeral tipo gancho con guante cosmético (Aosuo)": transh_data,
  "Protesis transradial mecánica de TPU": transMe_data,
  "Protesis transradial tipo gancho con guante cosmético (Fillauer)":
    transTG_data,
  "Protesis transradial tipo gancho con guante cosmético (Aosuo)": transTG_data,
  //Estetica
  "Falange Parcial": fp_data,
  "Microtia Tipo 1 y 2": micro_data,
  "Microtia Tipo 3 y 4": micro_data,
  "Falange Total": ft_data,
  "Mano Completa Estética": mce_data,
  "Mano Parcial Estética": mpe_data,
  "Parte Corporal": pt_data,
  "Mitón de Pie Estético": Miton_pie_Estetico_data,
  "Prótesis de Mamas": Mamas_data,
  "Falange Estética de Pie": fep,
  //Miembro Inferior
  "Metatarsal": meta_data,
  //Encaje
  "Socket Transfemoral": sctransfe,
  "Socket Transtibial": sctranti,
};

const MItrabajo = {
  "Protesis Transfemoral": transfemoral_tmp,
  "Protesis Transtibial": transtibial_tmp,
  "Protesis de Desarticulado de Cadera": cadera_tmp,
  "Bilateral Transfemoral": bitranfe,
  "Bilateral Transtibial": bitrasnti,
  "Protesis de Desarticulado de Rodilla": desartRodilla_tmp,
  "Mano Parcial Mecánica": mpm_data,
  "Mano Parcial de articulación manual": mpam_data,
  "Mano Parcial Biónica": mpb_data,
  "Protesis Syme": transtibial_tmp,
  "Protesis Chopart": cp_tmp,
  "Protesis Linsfrack": lnf_tmp
};

const trabajosMontos = {
  "Protesis Transhumeral tipo gancho con guante cosmético (Fillauer)": 15500,
  "Protesis Transhumeral tipo gancho con guante cosmético (Aosuo)": 8500,
  "Protesis transradial tipo gancho con guante cosmético (Aosuo)": 6500,
  "Protesis transradial tipo gancho con guante cosmético (Fillauer)": 12500,
};

function listado(x) {
  const mpmContainer = document.getElementById("FrmLista");

  // Limpiamos el contenido anterior
  mpmContainer.innerHTML = "";

  x.forEach((item) => {
    const inputElement = document.createElement("input");
    inputElement.setAttribute("type", "text");
    inputElement.setAttribute("readonly", "true");
    inputElement.setAttribute("c", "true");
    inputElement.classList.add("form-control");
    inputElement.value = item;

    const colDiv = document.createElement("div");
    colDiv.classList.add("row");
    colDiv.classList.add("m-1");
    colDiv.appendChild(inputElement);

    mpmContainer.appendChild(colDiv);
  });
}

function OnchaCoti() {
  const trabajo = document.getElementById("Sub_trab").value;
  const coti = $("#Coti");
  const tittle = document.getElementById("TitleTipTra");

  //coti.hide(500);

  tittle.innerText = trabajo;

  if (MItrabajo.hasOwnProperty(trabajo)) {
    MI_data(MItrabajo[trabajo]);
  }

  if (!listadoGenerado && tiposTrabajo.hasOwnProperty(trabajo)) {
    listado(tiposTrabajo[trabajo]);
    listadoGenerado = false;
  }

  // Verifica si el trabajo está en el objeto
  if (trabajo in trabajosMontos) {
    // Establece el valor del campo "#monto" con el monto correspondiente
    $("#monto").val(trabajosMontos[trabajo]);
  } else {
    // En caso contrario, borra el valor del campo "#monto"
    $("#monto").val("");
  }

  coti.show(800);
}

function OnchageShow() {
  tip.show(500);
}

function OnchageTip() {
  var TipSelect = document.querySelector("#Tip_trab");
  var SubSelect = document.querySelector("#Sub_trab");
  var id = TipSelect.value;
  const url = base_url + "Cotizacion/getSubtrabajo/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += ` 
                  <option value="${row["Subtrabajo"]}">${row["Subtrabajo"]}</option>
                `;
      });
      sub.show(500);
      SubSelect.innerHTML =
        `<option value="" disabled selected>Seleccionar Trabajo</option>` +
        html;
    }
  };
}

function MI_data(m) {
  const mpmContainer2 = document.getElementById("FrmLista");
  mpmContainer2.innerHTML = m;
  const SelectLiner = $(".selectL");

  SelectLiner.each(function () {
    var $this = $(this);
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: "Seleccionar",
      dropdownParent: $this.parent(),
    });
  });
}

function Existe() {
  const id = document.getElementById("IdPaciente").value;
  const tra = document.getElementById("Sub_trab").value;
  const url = base_url + "Cotizacion/Existe/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = this.responseText;
      if (res.includes(tra)) {
        RegistrarCoti2();
      } else {
        RegistrarServicio(function () {
          RegistrarCoti(function (idFromRegistrarCoti) {
            RegistrarLista(idFromRegistrarCoti);
          });
        });
      }
    }
  };
}

/***** LOGICA 1 #$$ *****/
function RegistrarServicio(callback) {
  // Cambiar el contenido del botón y deshabilitarlo en RegistrarServicio
  btnGen.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
  btnGen.disabled = true;

  const id = document.getElementById("IdPaciente").value;
  const tip = document.getElementById("Tip_trab").value;
  const sub = document.getElementById("Sub_trab").value;
  const monto = document.getElementById("monto").value;

  if (id == "" || tip == "" || sub == "" || monto == "") {
    Swal.fire({
      icon: "warning",
      title: "Complete los campos vacíos",
      showConfirmButton: true,
      timer: 1000,
    });
    // Restaurar el contenido original del botón y habilitarlo si hay un error
    btnGen.innerHTML = `<span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>`;
    btnGen.disabled = false;
  } else {
    const frm = document.getElementById("frmServicio");
    const url = base_url + "Cotizacion/RegistrarServicio";
    const data = new FormData(frm);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);

    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo === "success") {
          // Llamar a la siguiente función en el orden
          callback();
        } else {
          btnGen.innerHTML = "Registrar Servicio";
          btnGen.disabled = false;
        }
      }
    };
  }
}

function RegistrarCoti(callback) {
  const id = document.getElementById("IdPaciente").value;
  const tip = document.getElementById("Tip_trab").value;
  const sub = document.getElementById("Sub_trab").value;
  const monto = document.getElementById("monto").value;
  const obs = document.getElementById("Observacion").value;
  const peso = document.getElementById("Peso").value;
  const igv = document.getElementById("IGV");
  const cant = document.getElementById("cantidad").value;
  let che = 0;

  if (igv.checked) {
    che = 1;
  } else {
    che = 0;
  }

  const url = base_url + "Cotizacion/RegistrarCoti";
  const datos = {
    id: id,
    tip: tip,
    sub: sub,
    monto: monto,
    obs: obs,
    peso: peso,
    igv: che,
    cant: cant,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      if (res.tipo === "success") {
        // Llamar a la siguiente función en el orden
        callback(res.id);
      }
    }
  };

  http.send(JSON.stringify(datos));
}

function RegistrarLista(id) {
  var formulario = document.getElementById("FrmLista");
  var valoresSelect = [];

  for (var i = 0; i < formulario.elements.length; i++) {
    var elemento = formulario.elements[i];

    if (elemento.tagName === "SELECT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    } else if (elemento.tagName === "INPUT" || elemento.tagName === "SELECT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    } else if (elemento.tagName === "INPUT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    }
  }

  const url = base_url + "Cotizacion/RegistrarLista";
  const datos = {
    selecciones: valoresSelect,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      setTimeout(function () {
        Swal.fire({
          icon: res.tipo,
          title: res.mensaje,
          showConfirmButton: true,
          timer: 2000,
          didClose: () => {
            if ((res.tipo = "success")) {
              window.location.href = base_url + "Cotizacion/imprimir/" + id;
            }
          },
        });
      }, 4000);
    }
  };

  http.send(JSON.stringify(datos));
}

/***** LOGICA 2 #$$ *****/
function RegistrarCoti2() {
  // Cambiar el contenido del botón y deshabilitarlo en RegistrarServicio
  btnGen.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
  btnGen.disabled = true;

  const id = document.getElementById("IdPaciente").value;
  const tip = document.getElementById("Tip_trab").value;
  const sub = document.getElementById("Sub_trab").value;
  const monto = document.getElementById("monto").value;
  const obs = document.getElementById("Observacion").value;
  const peso = document.getElementById("Peso").value;
  const igv = document.getElementById("IGV");
  const cant = document.getElementById("cantidad").value;
  let che = 0;

  if (igv.checked) {
    che = 1;
  } else {
    che = 0;
  }

  const url = base_url + "Cotizacion/RegistrarCoti";
  const datos = {
    id: id,
    tip: tip,
    sub: sub,
    monto: monto,
    obs: obs,
    peso: peso,
    igv: che,
    cant: cant,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      if (res.tipo == "success") {
        // Llamar a la siguiente función en el orden
        RegistrarLista2(res.id);
      } else {
        btnGen.innerHTML = "Registrar Servicio";
        btnGen.disabled = false;
      }
    }
  };

  http.send(JSON.stringify(datos));
}

function RegistrarLista2(id) {
  var formulario = document.getElementById("FrmLista");
  var valoresSelect = [];

  for (var i = 0; i < formulario.elements.length; i++) {
    var elemento = formulario.elements[i];

    if (elemento.tagName === "SELECT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    } else if (elemento.tagName === "INPUT" || elemento.tagName === "SELECT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    } else if (elemento.tagName === "INPUT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    }
  }

  const url = base_url + "Cotizacion/RegistrarLista";
  const datos = {
    selecciones: valoresSelect,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      setTimeout(function () {
        Swal.fire({
          icon: res.tipo,
          title: res.mensaje,
          showConfirmButton: true,
          timer: 2000,
          didClose: () => {
            if (res.tipo === "success") {
              window.location.href = base_url + "Cotizacion/imprimir/" + id;
            }
          },
        });
      }, 4000);
    }
  };

  http.send(JSON.stringify(datos));
}

/************* COTIZACION MANUAL *************/
function AbrirManual() {
  SelectPacienteManual.each(function () {
    var $this = $(this);
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: "Seleccionar Paciente",
      dropdownParent: $this.parent(),
    });
  });

  ModalOpenManual.show();
}

function OnchageShowManual() {
  tipManual.show(500);
}

function OnchageTipManual() {
  var TipSelect = document.querySelector("#Tip_trabManual");
  var SubSelect = document.querySelector("#Sub_trabManual");
  var id = TipSelect.value;
  const url = base_url + "Cotizacion/getSubtrabajo/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += ` 
                  <option value="${row["Subtrabajo"]}">${row["Subtrabajo"]}</option>
                `;
      });
      subManual.show(500);
      SubSelect.innerHTML =
        `<option value="" disabled selected>Seleccionar Trabajo</option>` +
        html;
    }
  };
}

function ExisteManual() {
  const id = document.getElementById("IdPacienteManual").value;
  const tra = document.getElementById("Sub_trabManual").value;
  const url = base_url + "Cotizacion/Existe/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = this.responseText;
      if (res.includes(tra)) {
        RegistrarCotiManual2();
      } else {
        RegistrarServicioManual(function () {
          RegistrarCotiManual(function (idFromRegistrarCotiManual) {
            RegistrarListaManual(idFromRegistrarCotiManual);
          });
        });
      }
    }
  };
}

function RegistrarServicioManual(callback) {
  // Cambiar el contenido del botón y deshabilitarlo en RegistrarServicio
  btnGenManual.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
  btnGenManual.disabled = true;

  const id = document.getElementById("IdPacienteManual").value;
  const tip = document.getElementById("Tip_trabManual").value;
  const sub = document.getElementById("Sub_trabManual").value;
  const monto = document.getElementById("montoManual").value;

  if (id == "" || tip == "" || sub == "" || monto == "") {
    Swal.fire({
      icon: "warning",
      title: "Complete los campos vacíos",
      showConfirmButton: true,
      timer: 1000,
    });
    // Restaurar el contenido original del botón y habilitarlo si hay un error
    btnGenManual.innerHTML = `<span class="d-flex align-items-center justify-content-center text-nowrap"><i class="mdi mdi-send-outline scaleX-n1-rtl me-1"></i>Generar</span>`;
    btnGenManual.disabled = false;
  } else {
    const frm = document.getElementById("frmServicioManual");
    const url = base_url + "Cotizacion/RegistrarServicioManual";
    const data = new FormData(frm);
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(data);

    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo === "success") {
          // Llamar a la siguiente función en el orden
          callback();
        } else {
          btnGenManual.innerHTML = "Registrar Servicio";
          btnGenManual.disabled = false;
        }
      }
    };
  }
}

function RegistrarCotiManual(callback) {
  const id = document.getElementById("IdPacienteManual").value;
  const tip = document.getElementById("Tip_trabManual").value;
  const sub = document.getElementById("Sub_trabManual").value;
  const monto = document.getElementById("montoManual").value;
  const obs = document.getElementById("ObservacionManual").value;
  const peso = document.getElementById("PesoManual").value;
  const igv = document.getElementById("IGV");
  const cant = document.getElementById("cantidadManual").value;
  let che = 0;

  if (igv.checked) {
    che = 1;
  } else {
    che = 0;
  }

  const url = base_url + "Cotizacion/RegistrarCoti";
  const datos = {
    id: id,
    tip: tip,
    sub: sub,
    monto: monto,
    obs: obs,
    peso: peso,
    igv: che,
    cant: cant,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      const res = JSON.parse(this.responseText);
      if (res.tipo === "success") {
        // Llamar a la siguiente función en el orden
        callback(res.id);
      }
    }
  };

  http.send(JSON.stringify(datos));
}

function RegistrarListaManual(id) {
  var formulario = document.getElementById("FrmListaManual");
  var valoresSelect = [];

  for (var i = 0; i < formulario.elements.length; i++) {
    var elemento = formulario.elements[i];

    if (elemento.tagName === "INPUT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    }
  }

  const url = base_url + "Cotizacion/RegistrarLista";
  const datos = {
    selecciones: valoresSelect,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      setTimeout(function () {
        Swal.fire({
          icon: res.tipo,
          title: res.mensaje,
          showConfirmButton: true,
          timer: 2000,
          didClose: () => {
            if ((res.tipo = "success")) {
              window.location.href = base_url + "Cotizacion/imprimir/" + id;
            }
          },
        });
      }, 3000);
      ModalOpenManual.hide();
    }
  };

  http.send(JSON.stringify(datos));
}

function RegistrarCotiManual2() {
  // Cambiar el contenido del botón y deshabilitarlo en RegistrarServicio
  btnGenManual.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
  btnGenManual.disabled = true;

  const id = document.getElementById("IdPacienteManual").value;
  const tip = document.getElementById("Tip_trabManual").value;
  const sub = document.getElementById("Sub_trabManual").value;
  const monto = document.getElementById("montoManual").value;
  const obs = document.getElementById("ObservacionManual").value;
  const peso = document.getElementById("PesoManual").value;
  const igv = document.getElementById("IGV");
  const cant = document.getElementById("cantidadManual").value;
  let che = 0;

  if (igv.checked) {
    che = 1;
  } else {
    che = 0;
  }

  const url = base_url + "Cotizacion/RegistrarCoti";
  const datos = {
    id: id,
    tip: tip,
    sub: sub,
    monto: monto,
    obs: obs,
    peso: peso,
    igv: che,
    cant: cant,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo === "success") {
        // Llamar a la siguiente función en el orden
        RegistrarListaManual2(res.id);
      } else {
        btnGenManual.innerHTML = "Registrar Servicio";
        btnGenManual.disabled = false;
      }
    }
  };

  http.send(JSON.stringify(datos));
}

function RegistrarListaManual2(id) {
  var formulario = document.getElementById("FrmListaManual");
  var valoresSelect = [];

  for (var i = 0; i < formulario.elements.length; i++) {
    var elemento = formulario.elements[i];

    if (elemento.tagName === "INPUT") {
      var valor = elemento.value;
      valoresSelect.push(valor);
    }
  }

  const url = base_url + "Cotizacion/RegistrarLista";
  const datos = {
    selecciones: valoresSelect,
  };

  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);

      setTimeout(function () {
        Swal.fire({
          icon: res.tipo,
          title: res.mensaje,
          showConfirmButton: true,
          timer: 2000,
          didClose: () => {
            if ((res.tipo = "success")) {
              window.location.href = base_url + "Cotizacion/imprimir/" + id;
            }
          },
        });
      }, 3000);
      ModalOpenManual.hide();
    }
  };

  http.send(JSON.stringify(datos));
}

function handleFrm(e) {
  const FrmManual = document.getElementById("FrmListaManual");
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmManual.checkValidity()) {
    e.stopPropagation();
  } else {
    ExisteManual();
  }
  FrmManual.classList.add("was-validated");
}

function habdleFrmOri(e) {
  const Frm = document.getElementById("FrmLista");
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!Frm.checkValidity()) {
    e.stopPropagation();
  } else {
    Existe();
  }
  Frm.classList.add("was-validated");
}
