const ModalPago = document.querySelector("#ModalPagos");
const ModalOpenPago = new bootstrap.Modal(ModalPago);

const btnPago = document.querySelector("#btnHistoPagos");
const FrmPagos = document.querySelector("#FrmPagos");

document.addEventListener("DOMContentLoaded", function () {
  ListarPagos();
  FrmPagos.addEventListener("submit", handleFrmPagos, false);
});

function AbriModal() {
  ModalOpenPago.show();
}

function OnchageTP() {
  const tip = document.getElementById("TipPago").value;
  const met = document.getElementById("Metodo");
  let html;
  if (tip == "Transferencia") {
    html = `
            <option value="" disabled selected>Seleccione</option>
            <option value="BBVA - Administración">BBVA - Administración</option>
            <option value="BCP - Administración">BCP - Administración</option>
            <option value="Interbank - Administración">Interbank - Administración</option>
            <option value="Banco Nación - Administración">Banco Nación - Administración</option>
        `;
  } else if (tip == "Efectivo") {
    html = `<option value="Efectivo">Efectivo</option>`;
  } else if (tip == "Pago con Tarjeta") {
    html = `<option value="Pago con Tarjeta">Pago con Tarjeta</option>`;
  } else if (tip == "Billetera Digital") {
    html = `
        <option value="" disabled selected>Seleccione</option>
        <option value="Yape">Yape</option>
        <option value="Plin">Plin</option>
    `;
  }

  met.innerHTML = html;
}

function handleFrmPagos(event) {
  event.preventDefault();
  const FrmPagos = event.target;
  const bsValidationForms = document.querySelectorAll(".needs-validation");

  if (!FrmPagos.checkValidity()) {
    event.stopPropagation();
  } else {
    btnPago.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
    btnPago.disabled = true;

    const url = base_url + "Contrato/RegistroPago";
    const data = new FormData(FrmPagos);
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
                const url = base_url + "Contrato/Recibo/" + res.id;
                window.open(url, "_blank");
                window.location.reload();
              },
            });
            ModalOpenPago.hide();
          } else if (res.tipo == "warning") {
            AlertaPerzonalizada(res.tipo, res.mensaje);
            btnPago.innerHTML = "Realizar Pago";
            btnPago.disabled = false;
            ModalOpenPago.hide();
          } else {
            AlertaPerzonalizada(res.tipo, res.mensaje);
            btnPago.innerHTML = "Realizar Pago";
            btnPago.disabled = false;
          }
        }, 3000);
      }
    };
  }
  FrmPagos.classList.add("was-validated");
}

function ListarPagos() {
  const id = document.getElementById("id_pro").value;
  const url = base_url + "Contrato/ListarPagos/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.forEach((row) => {
        html += `
        <tr>
            <td class="text-center">${row["FECHA"]}</td>
            <td class="text-center">${row["NPAGO"]}</td>
            <td class="text-center">${row["TIP_PAGO"]}</td>
            <td>${row["METODO"]}</td>
            <td class="text-center"><span class="badge bg-label-primary">S/. ${row["ABONO"]}</span></td>
            <td class="text-center">
              <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="mdi mdi-dots-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                      <button type="button" class="dropdown-item" onclick="Comprobante(${row["ID"]})">
                          <i class="mdi mdi-image-check-outline mdi-20px mx-1"></i> 
                          Comprobante
                      </button>
                      <button type="button" class="dropdown-item" onclick="Recibo(${row["ID"]})">
                          <i class="mdi mdi-file-pdf-box mdi-20px mx-1"></i> 
                          Recibo
                      </button>
                  </div>
              </div>
            </td>
        </tr>
        `;
      });
      document.querySelector("#bodyPagos").innerHTML = html;
    }
  };
}

function Comprobante(id) {
  const url = base_url + "Contrato/Comprobante/" + id;
  window.open(url, "_blank");
}

function Recibo(id) {
  const url = base_url + 'Contrato/MostrarRecibo/' + id;
  window.open(url, '_blank');
}
