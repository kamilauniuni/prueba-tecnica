<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Paciente</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold mb-4">Crear Paciente</h2>

    <form action="paciente_controller.php?action=store" method="POST" enctype="multipart/form-data">

        <div class="mb-4">
            <label for="tipo_documento_id" class="block text-sm font-medium text-gray-700">Tipo de Documento:</label>
            <select name="tipo_documento_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Seleccione...</option>
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

                // Obtener tipos de documento
                $tipos_documento = [];
                $query_tipos = "SELECT * FROM tipos_documento";
                $result_tipos = $pdo->query($query_tipos);
                while ($row = $result_tipos->fetch(PDO::FETCH_ASSOC)) {
                    $tipos_documento[] = $row;
                }

                if (isset($tipos_documento) && count($tipos_documento) > 0): 
                    foreach ($tipos_documento as $tipo): ?>
                        <option value="<?php echo $tipo['id']; ?>">
                            <?php echo $tipo['nombre']; ?>
                        </option>
                    <?php endforeach; 
                else: ?>
                    <option value="">No hay tipos de documento disponibles</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="numero_documento" class="block text-sm font-medium text-gray-700">Número de Documento:</label>
            <input type="text" name="numero_documento" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="nombre1" class="block text-sm font-medium text-gray-700">Primer Nombre:</label>
            <input type="text" name="nombre1" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="nombre2" class="block text-sm font-medium text-gray-700">Segundo Nombre:</label>
            <input type="text" name="nombre2" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="apellido1" class="block text-sm font-medium text-gray-700">Primer Apellido:</label>
            <input type="text" name="apellido1" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="apellido2" class="block text-sm font-medium text-gray-700">Segundo Apellido:</label>
            <input type="text" name="apellido2" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <div class="mb-4">
            <label for="genero_id" class="block text-sm font-medium text-gray-700">Género:</label>
            <select name="genero_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Seleccione...</option>
                <option value="1">Femenino</option>
                <option value="2">Masculino</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento:</label>
            <select name="departamento_id" id="departamento_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Seleccione...</option>
                <?php 
                // Obtener departamentos
                $departamentos = [];
                $query_departamentos = "SELECT * FROM departamentos";
                $result_departamentos = $pdo->query($query_departamentos);
                while ($row = $result_departamentos->fetch(PDO::FETCH_ASSOC)) {
                    $departamentos[] = $row;
                }

                if (isset($departamentos)): 
                    foreach ($departamentos as $departamento): ?>
                        <option value="<?php echo $departamento['id']; ?>">
                            <?php echo $departamento['nombre']; ?>
                        </option>
                    <?php endforeach; 
                endif; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="municipio_id" class="block text-sm font-medium text-gray-700">Municipio:</label>
            <select name="municipio_id" id="municipio_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">Seleccione...</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="foto" class="block text-sm font-medium text-gray-700">Foto del Paciente:</label>
            <input type="file" name="foto" accept="image/*" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded-md hover:bg-blue-600 transition duration-200">Crear Paciente</button>
    </form>
</div>

<script>
    document.getElementById('departamento_id').addEventListener('change', function() {
        const departamentoId = this.value;

        fetch('get_municipios.php?departamento_id=' + departamentoId)
            .then(response => response.json())
            .then(data => {
                const municipioSelect = document.getElementById('municipio_id');
                municipioSelect.innerHTML = '<option value="">Seleccione...</option>'; 

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
