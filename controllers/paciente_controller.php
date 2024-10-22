<?php
session_start();
require_once '../models/paciente_model.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

switch ($action) {
    case 'list':
        $pacientes = obtenerPacientes();
        include '../views/listar.php';
        break;

    case 'delete':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($id) {
            eliminarPaciente($id);
            header('Location: paciente_controller.php?action=list');
        }
        break;

    case 'edit':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        if ($id) {
            $paciente = obtenerPacientePorId($id);
            $tipos_documento = obtenerTiposDocumento();
            $departamentos = obtenerDepartamentos();
            include '../views/editar_paciente.php';
        }
        break;

    case 'create':
        include '../views/crear_paciente.php';
        break;

    case 'store':
        $tipo_documento_id = isset($_POST['tipo_documento_id']) ? $_POST['tipo_documento_id'] : 0;
        $numero_documento = isset($_POST['numero_documento']) ? $_POST['numero_documento'] : '';
        $nombre1 = isset($_POST['nombre1']) ? $_POST['nombre1'] : '';
        $nombre2 = isset($_POST['nombre2']) ? $_POST['nombre2'] : '';
        $apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
        $apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
        $genero_id = isset($_POST['genero_id']) ? $_POST['genero_id'] : 0;
        $departamento_id = isset($_POST['departamento_id']) ? $_POST['departamento_id'] : 0;
        $municipio_id = isset($_POST['municipio_id']) ? $_POST['municipio_id'] : 0;

        // Manejo del archivo de foto
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        }

        if ($nombre1 && $numero_documento) {
            agregarPaciente($tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $foto);
            header('Location: paciente_controller.php?action=list');
            exit;
        } else {
            echo "Error: Datos incompletos";
        }
        break;

        case 'update':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $tipo_documento_id = isset($_POST['tipo_documento_id']) ? $_POST['tipo_documento_id'] : 0;
            $numero_documento = isset($_POST['numero_documento']) ? $_POST['numero_documento'] : '';
            $nombre1 = isset($_POST['nombre1']) ? $_POST['nombre1'] : '';
            $nombre2 = isset($_POST['nombre2']) ? $_POST['nombre2'] : '';
            $apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
            $apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
            $genero_id = isset($_POST['genero_id']) ? $_POST['genero_id'] : 0;
            $departamento_id = isset($_POST['departamento_id']) ? $_POST['departamento_id'] : 0;
            $municipio_id = isset($_POST['municipio_id']) ? $_POST['municipio_id'] : 0;
        
            // Manejo del archivo de foto
            $foto = null;
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $foto = file_get_contents($_FILES['foto']['tmp_name']);

            }
        
            if ($nombre1 && $numero_documento) {
                if ($foto) {
                    // Si se subió una nueva foto, actualizamos el paciente con la imagen
                    editarPacienteConFoto($id, $tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $foto);
                } else {
                    // Si no se subió una nueva foto, actualizamos el paciente sin cambiar la imagen
                    editarPaciente($id, $tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id);
                }
                header('Location: paciente_controller.php?action=list');
                exit;
            } else {
                echo "Error: Datos incompletos";
            }
            break; 

    case 'getDepartamentos':
        $departamentos = obtenerDepartamentos();
        echo json_encode($departamentos);
        exit;

    case 'getMunicipios':
        $departamento_id = isset($_GET['departamento_id']) ? $_GET['departamento_id'] : 0;
        $municipios = obtenerMunicipios($departamento_id);
        echo json_encode($municipios);
        exit;
}


function obtenerMunicipios($departamento_id) {
    global $pdo;

    $query = "SELECT id, nombre FROM municipios WHERE departamento_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$departamento_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



