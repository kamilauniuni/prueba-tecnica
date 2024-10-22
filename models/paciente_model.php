<?php
function obtenerPacientes() {
    $conexion = new mysqli('localhost', 'root', '', 'pacientes');
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Hacemos un JOIN para obtener los nombres en lugar de los IDs
    $query = "
        SELECT p.id, p.numero_documento, p.nombre1, p.nombre2, p.apellido1, p.apellido2, 
               td.nombre AS tipo_documento_id, g.nombre AS genero_id, d.nombre AS departamento_id, 
               m.nombre AS municipio_id, p.foto
        FROM paciente p
        JOIN tipos_documento td ON p.tipo_documento_id = td.id
        JOIN genero g ON p.genero_id = g.id
        JOIN departamentos d ON p.departamento_id = d.id
        JOIN municipios m ON p.municipio_id = m.id";

    $resultado = $conexion->query($query);
    
    $pacientes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $pacientes[] = $fila;
    }
    
    $conexion->close();
    return $pacientes;
}

function eliminarPaciente($id) {
    $conexion = new mysqli('localhost', 'root', '', 'pacientes');
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    $query = "DELETE FROM paciente WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    
    $stmt->close();
    $conexion->close();
}



function obtenerPacientePorId($id) {
    $conexion = new mysqli('localhost', 'root', '', 'pacientes');
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $query = "
        SELECT p.id, p.numero_documento, p.nombre1, p.nombre2, p.apellido1, p.apellido2, 
               td.nombre AS tipo_documento, g.nombre AS genero, d.nombre AS departamento, 
               m.nombre AS municipio, p.foto
        FROM paciente p
        JOIN tipos_documento td ON p.tipo_documento_id = td.id
        JOIN genero g ON p.genero_id = g.id
        JOIN departamentos d ON p.departamento_id = d.id
        JOIN municipios m ON p.municipio_id = m.id
        WHERE p.id = ?";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $paciente = $resultado->fetch_assoc();
    
    $stmt->close();
    $conexion->close();
    return $paciente;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=pacientes', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Conexión fallida: ' . $e->getMessage();
    exit; // Asegúrate de salir si no puedes conectar
}

function agregarPaciente($tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $foto) {
    global $pdo; // Asegúrate de que la conexión PDO esté disponible

    $query = "INSERT INTO paciente (tipo_documento_id, numero_documento, nombre1, nombre2, apellido1, apellido2, genero_id, departamento_id, municipio_id, foto) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $tipo_documento_id);
    $stmt->bindParam(2, $numero_documento);
    $stmt->bindParam(3, $nombre1);
    $stmt->bindParam(4, $nombre2);
    $stmt->bindParam(5, $apellido1);
    $stmt->bindParam(6, $apellido2);
    $stmt->bindParam(7, $genero_id);
    $stmt->bindParam(8, $departamento_id);
    $stmt->bindParam(9, $municipio_id);
    $stmt->bindParam(10, $foto, PDO::PARAM_LOB); // Especificar que se trata de un LOB

    if ($stmt->execute()) {
        return true; // Paciente agregado con éxito
    } else {
        return false; // Error al agregar el paciente
    }
}


function editarPacienteConFoto($id, $tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $foto) {
    global $pdo;
    $query = "UPDATE paciente SET tipo_documento_id = ?, numero_documento = ?, nombre1 = ?, nombre2 = ?, apellido1 = ?, apellido2 = ?, genero_id = ?, departamento_id = ?, municipio_id = ?, foto = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $foto, $id]);
}

// En tu archivo paciente_model.php
function obtenerTiposDocumento() {
    $conexion = new mysqli('localhost', 'root', '', 'pacientes');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $query = "SELECT id, nombre FROM tipos_documento";
    $resultado = $conexion->query($query);
    $tipos_documento = [];

    while ($fila = $resultado->fetch_assoc()) {
        $tipos_documento[] = $fila;
    }

    $conexion->close();
    return $tipos_documento;
}
// En tu archivo paciente_model.php
function obtenerDepartamentos() {
    $conexion = new mysqli('localhost', 'root', '', 'pacientes');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $query = "SELECT id, nombre FROM departamentos";
    $resultado = $conexion->query($query);
    $departamentos = [];

    while ($fila = $resultado->fetch_assoc()) {
        $departamentos[] = $fila;
    }

    $conexion->close();
    return $departamentos;
}

function editarPaciente($id, $tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id) {
    $conexion = new mysqli('localhost', 'root', '', 'pacientes');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta SQL para actualizar todos los campos, excluyendo la foto
    $query = "UPDATE paciente SET tipo_documento_id = ?, numero_documento = ?, nombre1 = ?, nombre2 = ?, apellido1 = ?, apellido2 = ?, genero_id = ?, departamento_id = ?, municipio_id = ? WHERE id = ?";
    
    // Prepara la declaración
    $stmt = $conexion->prepare($query);
    
    // Corrige la cadena de tipos
    $stmt->bind_param('issssssssi', $tipo_documento_id, $numero_documento, $nombre1, $nombre2, $apellido1, $apellido2, $genero_id, $departamento_id, $municipio_id, $id);

    // Verifica que la ejecución se realizó correctamente
    if ($stmt->execute()) {
        echo "Paciente actualizado exitosamente.";
    } else {
        echo "Error al actualizar paciente: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}









?>
