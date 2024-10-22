<?php

$host = 'localhost';
$dbname = 'pacientes';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

if (isset($_GET['departamento_id'])) {
    $departamento_id = $_GET['departamento_id'];

    $query = "SELECT * FROM municipios WHERE departamento_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $departamento_id, PDO::PARAM_INT);
    $stmt->execute();

    $municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($municipios);
} else {
    echo json_encode([]);
}
?>
