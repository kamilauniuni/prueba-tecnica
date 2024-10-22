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

$departamentos = [];
$query = "SELECT * FROM departamentos";
$result = $pdo->query($query);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $departamentos[] = $row;
}

// Cargar los municipios para el paciente actual (si se está editando)
$municipios = [];
if (isset($paciente['departamento_id'])) {
    $query = "SELECT * FROM municipios WHERE departamento_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $paciente['departamento_id'], PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $municipios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-3/4 max-w-2xl">
        <h2 class="text-2xl font-bold text-center mb-6">Actualizar </h2>
        <form action="paciente_controller.php?action=update" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo isset($paciente['id']) ? $paciente['id'] : ''; ?>">

            <div>
                <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de Documento:</label>
                <select name="tipo_documento_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                    <option value="">Seleccione...</option>
                    <?php if (isset($tipos_documento)): ?>
                        <?php foreach ($tipos_documento as $tipo): ?>
                            <option value="<?php echo $tipo['id']; ?>" <?php echo isset($paciente['tipo_documento_id']) && $tipo['id'] == $paciente['tipo_documento_id'] ? 'selected' : ''; ?>>
                                <?php echo $tipo['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay tipos de documento disponibles</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="numero_documento" class="block text-sm font-medium text-gray-700">Número de Documento:</label>
                <input type="text" name="numero_documento" value="<?php echo isset($paciente['numero_documento']) ? $paciente['numero_documento'] : ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div>
                <label for="nombre1" class="block text-sm font-medium text-gray-700">Primer Nombre:</label>
                <input type="text" name="nombre1" value="<?php echo isset($paciente['nombre1']) ? $paciente['nombre1'] : ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div>
                <label for="nombre2" class="block text-sm font-medium text-gray-700">Segundo Nombre:</label>
                <input type="text" name="nombre2" value="<?php echo isset($paciente['nombre2']) ? $paciente['nombre2'] : ''; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div>
                <label for="apellido1" class="block text-sm font-medium text-gray-700">Primer Apellido:</label>
                <input type="text" name="apellido1" value="<?php echo isset($paciente['apellido1']) ? $paciente['apellido1'] : ''; ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div>
                <label for="apellido2" class="block text-sm font-medium text-gray-700">Segundo Apellido:</label>
                <input type="text" name="apellido2" value="<?php echo isset($paciente['apellido2']) ? $paciente['apellido2'] : ''; ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
            </div>

            <div>
                <label for="genero_id" class="block text-sm font-medium text-gray-700">Género:</label>
                <select name="genero_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                    <option value="">Seleccione...</option>
                    <option value="1" <?php echo isset($paciente['genero_id']) && $paciente['genero_id'] == 1 ? 'selected' : ''; ?>>Femenino</option>
                    <option value="2" <?php echo isset($paciente['genero_id']) && $paciente['genero_id'] == 2 ? 'selected' : ''; ?>>Masculino</option>
                </select>
            </div>

            <div>
                <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento:</label>
                <select name="departamento_id" id="departamento_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                    <option value="">Seleccione...</option>
                    <?php if (isset($departamentos)): ?>
                        <?php foreach ($departamentos as $departamento): ?>
                            <option value="<?php echo $departamento['id']; ?>" <?php echo isset($paciente['departamento_id']) && $departamento['id'] == $paciente['departamento_id'] ? 'selected' : ''; ?>>
                                <?php echo $departamento['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label for="municipio_id" class="block text-sm font-medium text-gray-700">Municipio:</label>
                <select name="municipio_id" id="municipio_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                    <option value="">Seleccione...</option>
                    <?php if (isset($municipios)): ?>
                        <?php foreach ($municipios as $municipio): ?>
                            <option value="<?php echo $municipio['id']; ?>" <?php echo isset($paciente['municipio_id']) && $municipio['id'] == $paciente['municipio_id'] ? 'selected' : ''; ?>>
                                <?php echo $municipio['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay municipios disponibles</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
        <label for="foto" class="block text-sm font-medium text-gray-700">Foto del Paciente:</label>
        <input type="file" name="foto" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
        <?php if (isset($paciente['foto']) && !empty($paciente['foto'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($paciente['foto']); ?>" alt="Foto del paciente" class="mt-2 w-32 h-32 object-cover rounded">
        <?php endif; ?>
    </div>
            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200 w-full">Actualizar Paciente</button>
        </form>
    </div>

    <script>
        // Script para cargar los municipios según el departamento seleccionado
        document.getElementById('departamento_id').addEventListener('change', function() {
            const departamentoId = this.value;

            // Hacer una solicitud AJAX para obtener los municipios
            fetch('get_municipios.php?departamento_id=' + departamentoId)
                .then(response => response.json())
                .then(data => {
                    const municipioSelect = document.getElementById('municipio_id');
                    municipioSelect.innerHTML = '<option value="">Seleccione...</option>'; // Limpia las opciones existentes

                    data.forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio.id;
                        option.textContent = municipio.nombre;
                        municipioSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al obtener los municipios:', error));
        });
    </script>
</body>
</html>
