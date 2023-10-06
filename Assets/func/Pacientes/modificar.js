
const Frm = document.querySelector("#FrmModificarPaciente");
const BtnModificarPaciente = document.querySelector("#BtnModificarPaciente");

document.addEventListener('DOMContentLoaded', function () {

    Mostrar();

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const bsValidationForms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(bsValidationForms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            if (!form.checkValidity()) {
                event.stopPropagation();
            } else {
                // Mostrar el spinner en el botón
                BtnModificarPaciente.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;

                const url = base_url + 'Pacientes/modificarPaciente';
                const data = new FormData(Frm);
                const http = new XMLHttpRequest();
                http.open("POST", url, true);
                http.send(data);
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        // Obtener la velocidad de descarga actual
                        const downloadSpeedMbps = getDownloadSpeedMbps();
                        // Calcular el tiempo de espera en función de la velocidad de descarga
                        const timeoutDuration = calculateTimeoutDuration(downloadSpeedMbps);

                        Swal.fire({
                            icon: res.tipo,
                            title: res.mensaje,
                            showConfirmButton: true,
                            timer: timeoutDuration,
                            didClose: () => {
                                if (res.tipo = 'success') {
                                    window.location.href = base_url + "Pacientes";
                                }else{
                                    // Restaurar el contenido original del botón
                                    BtnModificarPaciente.innerHTML = 'Guardar';
                                }
                            }
                        });
                    }
                }
            }

            form.classList.add('was-validated');
        }, false);
    });

    Frm.addEventListener('reset', function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Desear Cancelar el Registro?',
            text: 'Se perderan los datos',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = base_url + "Pacientes";
            }
        });
    })


});

function Mostrar() {
    var id = document.getElementById("IDPaciente").value;
    const url = base_url + 'Pacientes/Mostrar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            Frm.Nombres.value = res.NOMBRES;
            Frm.DNI.value = res.DNI;
            Frm.Genero.value = res.GENERO;
            Frm.Edad.value = res.EDAD;
            Frm.Celular.value = res.CELULAR;
            Frm.naci.value = res.FECHANAC;
            Frm.Direccion.value = res.DIRECCION;
            Frm.Sede.value = res.SEDE;
            Frm.Locacion.value = res.LOCACION;
            Frm.email.value = res.CORREO;
            Frm.Estado.value = res.ESTADO;
            Frm.Canal.value = res.CANAL;
            Frm.TiemA.value = res.TIME_AMP;
            Frm.Motivo.value = res.MOTIVO;
            Frm.Afecc.value = res.AFECCIONES;
            Frm.Alergia.value = res.ALERGIAS;
            Frm.Obs.value = res.OBSERVACION;
            Frm.Peso.value = res.PESO;
        }
    };
}

function OnchageTipMos() {
    var TipSelect = document.querySelector("#TipM");
    var SubSelect = document.querySelector("#TipT");
    var id = TipSelect.value;
    const url = base_url + 'Pacientes/getSubTrab/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.forEach(row => {
                html +=
                    ` 
                    <option value="${row['Subtrabajo']}">${row['Subtrabajo']}</option>
                    `
            });
            SubSelect.innerHTML = html;
        }
    }
}

