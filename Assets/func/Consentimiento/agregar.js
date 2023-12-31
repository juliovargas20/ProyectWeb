const btnItem = document.querySelector("#btnItem");
const btnGenerar = document.querySelector("#btnGenerar");

const ModalCarta = document.querySelector("#ModalCarta");
const ModalOpenCarta = new bootstrap.Modal(ModalCarta);

const btnSP = document.querySelector("#btnSP");
const btnSF = document.querySelector("#btnSF");
const btnImage = document.querySelector("#btnImage");

const frm = document.querySelector("#FrmLista");

document.addEventListener('DOMContentLoaded', function () {

    btnItem.addEventListener('click', function (e) {
        e.preventDefault();
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

    btnGenerar.addEventListener('click', function (e) {

        if (frm.elements.length === 0) {
            alert('Formulario Vacío')
        } else {
            e.preventDefault();
            const url = base_url + 'Consentimiento/RegistrarDatos';
            let frm = new FormData();
            frm.append('id_paciente', document.getElementById('id_paciente').value);
            frm.append('id_contrato', document.getElementById('id_contrato').value);
            frm.append('tip_trab', document.getElementById('tip_trab').value);
            frm.append('sub_trab', document.getElementById('sub_trab').value);
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(frm);
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.tipo == "success") {
                        RegistrarList(res.id);
                    }
                }
            }
        }
    });
})

function RegistrarList(id) {
    var formulario = document.getElementById("FrmLista");
    var valoresSelect = [];

    const id_pa = document.getElementById("id_contrato").value;

    for (var i = 0; i < formulario.elements.length; i++) {
        var elemento = formulario.elements[i];

        if (elemento.tagName === "INPUT") {
            var valor = elemento.value;
            valoresSelect.push(valor);
        }
    }

    const url = base_url + "Consentimiento/RegistrarLista/" + id;
    const datos = {
        selecciones: valoresSelect,
    };

    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            Swal.fire({
                icon: res.tipo,
                title: res.mensaje,
                showConfirmButton: true,
                timer: 2000,
                didClose: () => {
                    if ((res.tipo = "success")) {
                        const link = base_url + "Consentimiento/CartaSP/" + id_pa;
                        window.open(link, '_blank');
                        window.location.href = base_url + "Consentimiento/consen";
                    }
                },
            });

        }
    };

    http.send(JSON.stringify(datos));
}
