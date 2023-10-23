
let TblUsuariosData;
let TblrolData;
const FrmUsuario = document.querySelector("#FrmUsuario");
const btnGuardar = document.querySelector('#BtnGuardatUsuario');

const ModalUsuario = document.querySelector('#ModalUsuario');
const ModalUser = new bootstrap.Modal(ModalUsuario);

document.addEventListener('DOMContentLoaded', function () {

    $(function () {
        TblUsuariosData = $('#TblUsuarios').DataTable({
            ajax: {
                url: base_url + 'Usuarios/Listar',
                dataSrc: ''
            },
            columns: [
                { data: 'NOMBRES' },
                { data: 'USUARIOS', className: 'text-center' },
                { data: 'CAJA', className: 'text-center' },
                { data: 'ESTADO', className: 'text-center' },
                { data: 'ACCIONES', className: 'text-center' },
            ],
            dom:
                '<"row mx-1"' +
                '<"col-sm-12 col-md-3" l>' +
                '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            buttons: [
                {
                    text: '<i class="mdi mdi-plus me-1"></i> <span class="d-none d-lg-inline-block">Agregar Nuevo Usuario</span>',
                    className: 'Off-Usuarios btn btn-primary',
                    attr: {
                        type: 'button',
                        id: 'btnOffCanvasUsuario',
                        onclick: 'Abrir()'
                    }
                }
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles de ' + data['NOMBRES'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            },
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json',
            }
        });
    });

    FrmUsuario.addEventListener('submit', function (e) {
        e.preventDefault();

        // Mostrar el spinner en el botón
        btnGuardar.innerHTML = `
        <span class="spinner-border me-1" role="status" aria-hidden="true"></span> 
        Guardando...  
        `;

        const url = base_url + 'Usuarios/RegistrarUsuario';
        const data = new FormData(FrmUsuario);
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                setTimeout(function () {
                    AlertaPerzonalizada(res.tipo, res.mensaje);
                    if (res.tipo = 'success') {
                        // Restaurar el contenido original del botón
                        btnGuardar.innerHTML = 'Guardar';
                        FrmUsuario.reset();
                        ModalUser.hide();
                        TblUsuariosData.ajax.reload();
                    }else{
                        // Restaurar el contenido original del botón
                        btnGuardar.innerHTML = 'Guardar';
                    }
                }, 3000);
            }
        }
    })

});

function Abrir() {
    FrmUsuario.reset();
    ModalUser.show();
}

function MostrarUsuario(id) {
    const url = base_url + 'Usuarios/Mostrar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            FrmUsuario.IdUsuario.value = res.ID;
            FrmUsuario.Nombres.value = res.NOMBRES;
            FrmUsuario.email.value = res.USUARIOS;
            FrmUsuario.clave.value = res.PASSWORD;
            FrmUsuario.Rol.value = res.ID_CAJA;
            ModalUser.show();
        }
    }
}


function Inactivar(id) {
    const url = base_url + "Usuarios/Inactivar/" + id;

    Eliminar('¿Está Seguro de dar de Baja?', 'El usuario no se eliminará, permanecerá en estado Inactivo', 'Sí, dar de Baja', url, TblUsuariosData)
}

function Activar(id) {
    const url = base_url + "Usuarios/Activar/" + id;

    Eliminar('¿Está Seguro de Activar al Usuario?', 'El usuario sera activado y tendra acceso al sistema', 'Sí, Activar', url, TblUsuariosData)
}



