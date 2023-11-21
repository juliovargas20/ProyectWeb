
const FrmOCompras = document.querySelector("#FrmOC");
const TblCompras = document.querySelector("#TblOC");

var TBodyOC = TblCompras.getElementsByTagName("tbody")[0];

document.addEventListener('DOMContentLoaded', function () {

    FrmOCompras.addEventListener("submit", function (e) {
        e.preventDefault();
        const url = base_url + "Ordenes/InsertarDetallesCompra";
        const frm = new FormData(FrmOCompras);
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(frm);
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res.tipo == "success") {
                    ListarDetalles();
                    FrmOCompras.reset();
                }
            }
        };
    });

    ListarDetalles();

});

function ListarDetalles() {
    const url = base_url + "Ordenes/ListarDetalle";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = "";
            res["Lista"].forEach((row) => {
                html += `
            <tr>
                <td class="text-center">${row["CANTIDAD"]}</td>
                <td>${row["DESCRIPCION"]}</td>
                <td class="text-center">${row["UNIDADES"]}</td>
                <td class="text-center">S/. ${row["PRECIO_U"]}</td>
                <td class="text-center">S/. ${row["SUB_TOTAL"]}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-icon btn-label-danger btn-sm demo waves-effect" onclick="EliminarDetalle(${row['ID']})"><i class="mdi mdi-delete-outline"></i></button>
                </td>
            </tr>
          `;
            });
            document.querySelector("#TblbodyOC").innerHTML = html;
            document.querySelector("#OCTotal").value = res.Total.TOTAL;
        }
    };
}

function EliminarDetalle(id) {
    const url = base_url + "Ordenes/EliminarDetalle/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        if (res.tipo == "success") {
            ListarDetalles();
        }
      }
    };
}