
const FrmOCompras = document.querySelector("#FrmOC");
const TblCompras = document.querySelector("#TblOC");

var TBodyOC = TblCompras.getElementsByTagName("tbody")[0];

const btnGenerar = document.querySelector("#btnGenerarOC");
const btnModal = document.querySelector("#BtnOCModal");

const ModalOC = document.querySelector("#BuscarOC");
const ModalOpenOC = new bootstrap.Modal(ModalOC);

let TblOC_data;

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

    btnGenerar.addEventListener('click', function (e) {
        e.preventDefault();
        if (TBodyOC.rows.length > 0) {
            if (document.getElementById('Concepto').value == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos Vacíos',
                    showConfirmButton: true,
                    timer: 2000,
                });
            } else {
                btnGenerar.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;
                btnGenerar.disabled = true;

                const url = base_url + "Ordenes/RegistrarOrdenCompra";
                let frm = new FormData();
                frm.append('Area', document.getElementById('Area').value);
                frm.append('OCTotal', document.getElementById('OCTotal').value);
                frm.append('Necesidad', document.getElementById('Necesidad').value);
                frm.append('Concepto', document.getElementById('Concepto').value);
                const http = new XMLHttpRequest();
                http.open("POST", url, true);
                http.send(frm);
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        const res = JSON.parse(this.responseText);
                        setTimeout(() => {
                            if (res.tipo == "success") {
                                Swal.fire({
                                    icon: res.tipo,
                                    title: res.mensaje,
                                    showConfirmButton: true,
                                    timer: 2000,
                                    didClose: () => {
                                        MostrarRecibo(res.id);
                                        window.location.reload();
                                    },
                                });
                            }
                        }, 3000);
                    }
                };
            }
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
        ModalOpenOC.show();
    });

    TblOC_data = $("#TblResumenOC").DataTable({
        ajax: {
            url: base_url + "Ordenes/ListarOC",
            dataSrc: "",
        },
        columns: [
            { data: "ID", className: "text-center" },
            { data: "FECHA", className: "text-center" },
            { data: "AREA", className: "text-center" },
            { data: "CONCEPTO" },
            { data: "TOTAL", className: "text-center" },
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
                <td style="width: 300px;">${row["DESCRIPCION"]}</td>
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

function MostrarRecibo(id) {
    const url = base_url + "Ordenes/MostrarRecibo/" + id;
    window.open(url, "_blank");
}