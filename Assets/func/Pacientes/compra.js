const btnAgregar = document.querySelector("#btnCompraAgregar");

document.addEventListener("DOMContentLoaded", function () {
  btnAgregar.addEventListener("click", function (e) {
    e.preventDefault();

    if (
      document.getElementById("ComprasDescripcion").value == "" ||
      document.getElementById("CompraCantidad").value == "" ||
      document.getElementById("CompraPrecioU").value == ""
    ) {
    } else {
      let formData = new FormData();
      formData.append(
        "des",
        document.getElementById("ComprasDescripcion").value
      );
      formData.append("can", document.getElementById("CompraCantidad").value);
      formData.append("pre", document.getElementById("CompraPrecioU").value);
      const url = base_url + "Pacientes/InsertDetalleCompras";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(formData);
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          if (res.tipo == "success") {
            ListarDetalle();
            document.getElementById("ComprasDescripcion").value = "";
            document.getElementById("CompraCantidad").value = "";
            document.getElementById("CompraPrecioU").value = "";
          }
        }
      };
    }
  });

  ListarDetalle();
});

function OnchageCompras() {
  const tip = document.getElementById("CompraTipPago").value;
  const met = document.getElementById("CompraPago");
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
  const url = base_url + "Pacientes/ListaDetalleCompras";
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
      document.querySelector("#TblbodyCompra").innerHTML = html;
      document.querySelector("#CompraTotal").value = res.total.TOTAL;
    }
  };
}

function EliminarDetalle(id) {
    const url = base_url + "Pacientes/EliminarDetalleCompras/" + id;
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