const btnClean = document.querySelector("#btnLimpiar");
const Frm = document.querySelector("#FrmProve");

document.addEventListener('DOMContentLoaded', function () {

    Frm.addEventListener("submit", function (e) {
        e.preventDefault();
        const url = base_url + "Logistica/RegistroDetallePro";
        const data = new FormData(Frm);
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function () {
            if (http.readyState == 4 && http.status == 200) {
                const res = JSON.parse(this.responseText);
                AlertaPerzonalizada(res.tipo, res.mensaje)
                if (res.tipo == 'success') {
                    Listar();
                    Frm.Cantidad.value = "";
                    Frm.Producto.value = "";
                    Frm.Descripcion.value = "";
                    Frm.Link.value = "";
                    Frm.Obs.value = "";
                    Frm.Precio.value = "";
                    Frm.Moneda.value = "";
                }
            }
        };
    });

    btnClean.addEventListener("click", function (e) {
        e.preventDefault();
        Frm.reset();
    });

    Listar();

})

function Listar() {
    const url = base_url + "Logistica/Listar";
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
                        <td class="text-center">${row["CANTIDAD"]}</td>
                        <td>${row["PRODUCTO"]}</td>
                        <td class="text-center">${row["PRO_NOMBRE"]}</td>
                        <td class="text-center">${row["PAIS"]}</td>
                        <td class="text-center"> ${row["VENDEDOR"]}</td>
                        <td class="text-center">${row["MONEDA"]} ${row["PRECIO"]}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-icon btn-label-danger btn-sm demo waves-effect" onclick="Eliminar(${row['ID']})"><i class="mdi mdi-delete-outline"></i></button>

                            <button type="button" class="btn btn-icon btn-label-warning btn-sm demo waves-effect" onclick="Mostrar(${row['ID']})"><i class="mdi mdi-circle-edit-outline"></i></button>
                        </td>
                    </tr>
                `;
            });
            document.querySelector("#BodyProo").innerHTML = html;
        }
    };
}

function Mostrar(id) {
    const url = base_url + 'Logistica/Mostrar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Frm.ID_Provee.value = res.ID;
            Frm.NombreProve.value = res.PRO_NOMBRE;
            Frm.PaisProve.value = res.PAIS;
            Frm.TelProve.value = res.TEL_PRO;
            Frm.PaginaPro.value = res.PAGINA;
            Frm.Vendedor.value = res.VENDEDOR;
            Frm.VenTel.value = res.TEL_VENDEDOR;
            Frm.Cantidad.value = res.CANTIDAD;
            Frm.Producto.value = res.PRODUCTO;
            Frm.Descripcion.value = res.DESCRIPCION;
            Frm.Link.value = res.LINK;
            Frm.Obs.value = res.OBSERVACION;
            Frm.Precio.value = res.PRECIO;
            Frm.Moneda.value = res.MONEDA;
        }
    };
}

function Eliminar(id) {
    Swal.fire({
        title: '¿Esta Seguro?',
        text: 'La importación agregada se eliminará',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: 'Sí, Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + 'Logistica/Eliminar/' + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    AlertaPerzonalizada(res.tipo, res.mensaje);
                    if (res.tipo == 'success') {
                        Listar();
                    }
                }
            };
        }
    });
}