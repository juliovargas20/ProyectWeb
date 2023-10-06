const FrmPaciente = document.querySelector("#FrmRegistroPaciente");
const BtnRegistroPaciente = document.querySelector('#BtnRegistroPaciente');

document.addEventListener('DOMContentLoaded', function () {
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
                BtnRegistroPaciente.innerHTML = `<span class="spinner-border me-1" role="status" aria-hidden="true"></span> Guardando...`;

                const url = base_url + 'Pacientes/registroPaciente';
                const data = new FormData(FrmPaciente);
                const http = new XMLHttpRequest();
                http.open("POST", url, true);
                http.send(data);
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        Swal.fire({
                            icon: res.tipo,
                            title: res.mensaje,
                            showConfirmButton: true,
                            timer: 3000,
                            didClose: () => {
                                if (res.tipo = 'success') {
                                    window.location.href = base_url + "Pacientes";
                                }else{
                                    // Restaurar el contenido original del botón
                                    btnGuardar.innerHTML = 'Guardar';
                                }
                            }
                        });
                    }
                }
            }

            form.classList.add('was-validated');
        }, false);
    });

    FrmPaciente.addEventListener('reset', function (e) {
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

