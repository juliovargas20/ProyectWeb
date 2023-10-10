const btnAgregar = document.querySelector("#btnAgregar");
const FrmAcc = document.querySelector("#FrmAcc");
const TblAcc = document.querySelector("#FrmAcc");
const btnGenerar = document.querySelector("#btnGenerar");
var tbody = TblAcc.getElementsByTagName("tbody")[0];

document.addEventListener("DOMContentLoaded", function () {
  btnAgregar.addEventListener("click", function (e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append("id_pa", document.getElementById("id_pa").value);
    formData.append("des", document.getElementById("Descripcion").value);
    formData.append("can", document.getElementById("Cantidad").value);
    formData.append("pre", document.getElementById("PrecioU").value);
    const url = base_url + "Pacientes/InsertDetallePago";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(formData);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo == "success") {
          ListarDetalle();
          document.getElementById("Descripcion").value = "";
          document.getElementById("Cantidad").value = "";
          document.getElementById("PrecioU").value = "";
        }
      }
    };
  });

  ListarDetalle();

  FrmAcc.addEventListener("submit", function (e) {
    e.preventDefault();
    if (tbody.rows.length > 0) {
      btnGenerar.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
      btnGenerar.disabled = true;

      const url = base_url + "Pacientes/RealizarPago";
      const frm = new FormData(FrmAcc);
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(frm);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          setTimeout(() => {
            if (res.tipo == "success") {
              Swal.fire({
                icon: res.tipo,
                title: res.mensaje,
                showConfirmButton: true,
                timer: 2000,
                didClose: () => {
                  PDfPago(res.id);
                  window.location.reload();
                },
              });
            }
          }, 3000);
        }
      };
    }
  });
});

function OnchageAcc() {
  const tip = document.getElementById("TipPago").value;
  const met = document.getElementById("Pago");
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

function ListarDetalle() {
  const id = document.getElementById("id_pa").value;
  const url = base_url + "Pacientes/ListaDetallePago/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res["detalle"].forEach((row) => {
        html += `
          <tr>
              <td class="text-center">${row["CANTIDAD"]}</td>
              <td>${row["DESCRIPCION"]}</td>
              <td class="text-center">S/. ${row["PRECIO_U"]}</td>
              <td class="text-center">S/. ${row["SUB_TOTAL"]}</td>
              <td class="text-center">
                  <button type="button" class="btn btn-icon btn-label-danger btn-sm demo waves-effect" onclick="EliminarDetalle('${row["ID"]}')"><i class="mdi mdi-delete-outline"></i></button>
              </td>
          </tr>
        `;
      });
      document.querySelector("#TblbodyAcc").innerHTML = html;
      document.querySelector("#Total").value = res.total.TOTAL;
    }
  };
}

function EliminarDetalle(id) {
  const url = base_url + "Pacientes/EliminarDetalle/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res.tipo == "success") {
        ListarDetalle();
      }
    }
  };
}

function PDfPago(id) {
  const url = base_url + "Pacientes/MostrarReciboPagos/" + id;
  window.open(url, "_blank");
}
