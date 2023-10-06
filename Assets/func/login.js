const frm = document.querySelector("#Frm");


document.addEventListener('DOMContentLoaded', function () {

    frm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (frm.email.value == '' || frm.password.value == '') {
            AlertaPerzonalizada('warning', 'Complete los campos');
        } else {
            const data = new FormData(frm);
            const http = new XMLHttpRequest();
            const url = BASE_URL + 'Usuarios/Validar';
            http.open("POST", url, true)
            http.send(data);
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    AlertaPerzonalizada(res.tipo, res.mensaje);
                    if (res.tipo == 'success') {
                        let timerInterval
                        Swal.fire({
                            title: res.mensaje,
                            html: 'Sera redireccionado en <b></b> milliseconds.',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location = BASE_URL + 'admin';
                            }
                        })
                    }
                }
            }
        }
    })
})