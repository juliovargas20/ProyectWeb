<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /*********************** <USUARIOS> ***********************/

    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 1);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Usuarios - Usuarios | KYPBioingeniería';
            $data['active'] = 'active';
            $data['scripts'] = 'Usuarios/usuarios.js';
            $data['caja'] = $this->model->getCaja();
            $this->views->getView('Usuarios', 'usuario', $data);
        }else{
            header('Location: ' . BASE_URL . 'MyError');
        }

        
    }

    public function Listar()
    {
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['ESTADO'] == 1) {
                $data[$i]['ESTADO'] = '<span class="badge bg-label-success me-1">Activo</span>';
                if ($data[$i]['ID_CAJA'] == 1) {
                    $data[$i]['ACCIONES'] = '<span class="badge bg-label-success me-1">Administrador</span>';
                } else {
                    $data[$i]['ACCIONES'] = '
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item" onclick="MostrarUsuario(' . $data[$i]['ID'] . ')">
                                <i class="mdi mdi-pencil-outline me-1"></i> 
                                Editar
                            </button>
                            <button type="button" class="dropdown-item" onclick="Inactivar(' . $data[$i]['ID'] . ')">
                                <i class="mdi mdi-trash-can-outline me-1"></i> 
                                Eliminar
                            </button>
                        </div>
                    </div>';
                }
            } else {
                $data[$i]['ESTADO'] = '<span class="badge bg-label-danger me-1">Inactivo</span>';
                $data[$i]['ACCIONES'] = '<button type="button" onclick="Activar(' . $data[$i]['ID'] . ')" class="btn btn-outline-success btn-sm">Activar</button>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Mostrar($id)
    {
        $data = $this->model->MostrarUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarUsuario()
    {
        $id = $_POST['IdUsuario'];
        $nombre = $_POST['Nombres'];
        $correo = $_POST['email'];
        $clave = $_POST['clave'];
        $rol = $_POST['Rol'];

        if (empty($nombre) || empty($correo) || empty($clave)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Campos Incompletos');
        } else {
            if ($id == '') {
                $data = $this->model->RegistrarUsuario($nombre, $correo, $clave, $rol);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Usuario Registrado', 'condicion' => 'Registrado');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al Registrar');
                }
            } else {
                $data = $this->model->Modificar($id, $nombre, $correo, $clave, $rol);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Usuario Modificado', 'condicion' => 'Modificado');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al Modificar');
                }
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Inactivar($id)
    {
        $data = $this->model->Inactivar($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Usuario dado de baja');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error dado de baja');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Activar($id)
    {
        $data = $this->model->Activar($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Usuario Activo');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error al activar');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    /*********************** </USUARIOS> ***********************/




    /*********************** <ROLES Y PERMISOS> ***********************/

    public function rol()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $id_caja = $_SESSION['id'];
        $verificar = $this->model->Verificar($id_caja, 1);

        if (!empty($verificar)) {
            $data['title'] = 'Gestión de Usuarios - Roles y Permisos | KYPBioingeniería';
            $data['activeRol'] = 'active';
            $data['scripts'] = 'Usuarios/rol.js';
            $this->views->getView('Usuarios', 'roles', $data);
        } else {
            header('Location: ' . BASE_URL . 'MyError');
        }

        
    }

    public function ListarCaja()
    {
        $data = $this->model->getCaja();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['ESTADO'] == 1) {
                $data[$i]['ESTADO'] = '<span class="badge bg-label-success me-1">Activo</span>';
                $data[$i]['ACCIONES'] = '
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button type="button" class="dropdown-item" onclick="updateRol('.$data[$i]['ID'].')">
                                <i class="mdi mdi-pencil-outline me-1"></i> 
                                Editar
                            </button>
                            <button type="button" class="dropdown-item" onclick="EliminarRol('.$data[$i]['ID'].')">
                                <i class="mdi mdi-trash-can-outline me-1"></i> 
                                Eliminar
                            </button>
                        </div>
                    </div>';
            } else {
                $data[$i]['ESTADO'] = '<span class="badge bg-label-danger me-1">Inactivo</span>';
                $data[$i]['ACCIONES'] = '<button type="button" onclick="ActivarRol('.$data[$i]['ID'].')" class="btn btn-outline-success btn-sm">Activar</button>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registro()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $data['title'] = 'Gestión de Usuarios - Registro Rol y Permiso | KYPBioingeniería';
        $data['activeRol'] = 'active';
        $data['scripts'] = 'Usuarios/rol.js';
        $data['permisos'] = $this->model->getPermisos();
        $this->views->getView('Usuarios', 'insertrol', $data);
    }

    public function RegistrarRol()
    {
        $rol = $_POST['Nombre'];

        if (empty($rol)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Campos Incompletos');
        } else {
            $data = $this->model->RegistrarRol($rol);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Rol Registrado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Rol');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function UpdateRol()
    {
        $rol = $_POST['Nombre'];
        $id = $_POST['idROl'];

        if (empty($rol)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Campos Incompletos');
        } else {
            $data = $this->model->UpdateRol($rol, $id);
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Rol Modificado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Rol');
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function RegistrarPermiso()
    {
        $cod = $this->model->getMaxCaja();
        
        if ($cod['ID'] == NULL) {
            $max = 1;
        } else {
            $max = $cod['ID'];
        }

        $eliminar = $this->model->EliminarPermiso($max);

        if ($eliminar == 'ok') {
            foreach ($_POST['permisos'] as $id_permiso) {
                $data = $this->model->RegistrarPermiso($max, $id_permiso);
            }
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Permiso Registrado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Permiso');
            }
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar los permisos');
        }
        
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function UpdatePermiso($id_rol)
    {
        $eliminar = $this->model->EliminarPermiso($id_rol);

        if ($eliminar == 'ok') {
            foreach ($_POST['permisos'] as $id_permiso) {
                $data = $this->model->RegistrarPermiso($id_rol, $id_permiso);
            }
            if ($data > 0) {
                $res = array('tipo' => 'success', 'mensaje' => 'Permiso Registrado');
            } else {
                $res = array('tipo' => 'error', 'mensaje' => 'Error al Permiso');
            }
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar los permisos');
        }
        
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function EliminarRol($id)
    {
        $data = $this->model->EliminarRol($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Rol dado de baja');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Rol dado de baja');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ActivarRol($id)
    {
        $data = $this->model->ActivarRol($id);
        if ($data > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Rol dado de baja');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'error Rol dado de baja');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function modificar($id)
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . BASE_URL);
        }

        $data['title'] = 'Gestión de Usuarios - Modificar Rol y Permiso | KYPBioingeniería';
        $data['activeRol'] = 'active';
        $data['scripts'] = 'Usuarios/rol.js';
        $data['caja'] = $this->model->getBCaja($id);
        $data['permisos'] = $this->model->getPermisos();
        $data['id'] = $id;

        $permisos = $this->model->getBPermisos($id);
        $data['asignados'] = array();
        foreach ($permisos as $permiso) {
            $data['asignados'][$permiso['ID_PERMISO']] = true;
        }

        $this->views->getView('Usuarios', 'updaterol', $data);
    }


    /*********************** </ROLES Y PERMISOS> ***********************/

    function Validar()
    {
        $correo = $_POST['email'];
        $clave = $_POST['password'];

        $data = $this->model->getUsuariosLogin($correo, $clave);
        if (!empty($data)) {
            $_SESSION['id_usuario'] = $data['ID'];
            $_SESSION['email'] = $data['USUARIOS'];
            $_SESSION['nombres'] = $data['NOMBRES'];
            $_SESSION['activo'] = $data['ESTADO'];
            $_SESSION['id'] = $data['ID_CAJA'];

            $verUser = $this->model->Verificar($_SESSION['id'], 1);
            $verListPa = $this->model->Verificar($_SESSION['id'], 2);
            $verCoti = $this->model->Verificar($_SESSION['id'], 3);
            $verHisto = $this->model->Verificar($_SESSION['id'], 4);
            $verContra = $this->model->Verificar($_SESSION['id'], 5);
            $verCitas = $this->model->Verificar($_SESSION['id'], 6);

            $_SESSION['user'] = json_decode(json_encode($verUser), true);
            $_SESSION['ListPa'] = json_decode(json_encode($verListPa), true);
            $_SESSION['Coti'] = json_decode(json_encode($verCoti), true);
            $_SESSION['histo'] = json_decode(json_encode($verHisto), true);
            $_SESSION['Contra'] = json_decode(json_encode($verContra), true);
            $_SESSION['citas'] = json_decode(json_encode($verCitas), true);

            $res = array('tipo' => 'success', 'mensaje' => 'Bienvenido al Sistema');
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'Usuario o Contraseña Incorrecta');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function Salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}
