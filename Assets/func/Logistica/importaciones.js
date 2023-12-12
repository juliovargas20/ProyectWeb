const btnClean = document.querySelector("#btnLimpiar");
const Frm = document.querySelector("#FrmProve");

const btnImport = document.querySelector("#btnImportacion");

const btnModal = document.querySelector("#btnModalImpor");

const OpenModal = document.querySelector("#BuscarOI");
const ModalOpenOI = new bootstrap.Modal(OpenModal);

const TblOI = document.querySelector("#TblDetallesImport");
var TBodyOI = TblOI.getElementsByTagName("tbody")[0];

let TblOi_data;

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
                    Frm.ID_Provee.value = "";
                }
            }
        };
    });

    btnClean.addEventListener("click", function (e) {
        e.preventDefault();
        Frm.reset();
    });

    Listar();

    btnImport.addEventListener("click", function (e) {
        e.preventDefault();

        if (TBodyOI.rows.length > 0) {
            btnImport.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
            btnImport.disabled = true;

            const url = base_url + "Logistica/RegistrarImportacion";
            let frm = new FormData();
            frm.append('AreaImport', document.getElementById('AreaImport').value);
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(frm);
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire({
                        icon: res.tipo,
                        title: res.mensaje,
                        showConfirmButton: true,
                        timer: 2000,
                        didClose: () => {
                            if (res.tipo == 'success') {
                                EnviarCorreo(res.id)
                                MostrarPDf(res.id);
                                Listar();
                                Frm.reset();
                                TblOi_data.ajax.reload();
                                btnImport.innerHTML = `Generar Importacion`;
                                btnImport.disabled = false;
                            }
                        },
                    });

                }
            };
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tabla Vacía',
                showConfirmButton: true,
                timer: 2000,
            });
        }

    });

    btnModal.addEventListener("click", function (e) {
        e.preventDefault();
        ModalOpenOI.show();
    });

    TblOi_data = $("#TblResumenOI").DataTable({
        ajax: {
            url: base_url + "Logistica/ListarImportacion",
            dataSrc: "",
        },
        columns: [
            { data: "ID", className: "text-center" },
            { data: "FECHA", className: "text-center" },
            { data: "AREA", className: "text-center" },
            { data: "STATUS", className: "text-center" },
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

function MostrarPDf(id) {
    const url = base_url + 'Logistica/MostrarPdf/' + id;
    window.open(url, '_blank');
}

function EnviarCorreo(id_importacion) {
    let formData = new FormData();
    formData.append("id_importacion", id_importacion);
    formData.append("area", document.getElementById("AreaImport").value);
    const url = base_url + 'Logistica/EnviarCorreo';
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(formData);
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    }
  }