<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-3/4 max-w-6xl overflow-hidden"> <!-- Cambiado a w-3/4 y max-w-6xl -->
        <h2 class="text-2xl font-bold text-center mb-6">Pacientes</h2>
        <div class="flex justify-between mb-4">
            <a href="paciente_controller.php?action=create" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Crear nuevo paciente
            </a>
            <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded transition duration-200 flex items-center">
              
                Cerrar sesión
            </a>
        </div>

       
       
<div class="form-group">
    <label for="cliente">
        <i class="fas fa-users"></i> Buscar Paciente por Documento
    </label>
    <select id="cliente" class="form-control" name="cliente">
        <option value="">Seleccione un paciente</option>
        <?php foreach ($pacientes as $paciente): ?>
            <option value="<?php echo $paciente['id']; ?>">
                <?php echo $paciente['numero_documento']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>



<br>


        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre Completo</th>
                        <th class="py-2 px-4 border-b">Tipo de Documento</th>
                        <th class="py-2 px-4 border-b">Número de Documento</th>
                        <th class="py-2 px-4 border-b">Género</th>
                        <th class="py-2 px-4 border-b">Departamento</th>
                        <th class="py-2 px-4 border-b">Municipio</th>
                        <th class="py-2 px-4 border-b">Foto</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $paciente): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo $paciente['id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $paciente['nombre1'] . ' ' . $paciente['nombre2'] . ' ' . $paciente['apellido1'] . ' ' . $paciente['apellido2']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $paciente['tipo_documento_id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $paciente['numero_documento']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $paciente['genero_id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $paciente['departamento_id']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $paciente['municipio_id']; ?></td>
                        
                        <td class="py-2 px-4 border-b">
                            <?php if ($paciente['foto']): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($paciente['foto']); ?>" alt="Foto de <?php echo $paciente['nombre1']; ?>" class="w-70 h-20 rounded-full object-cover mx-auto"> <!-- Ajustado a w-32 y h-32 -->
                            <?php else: ?>
                                <span class="inline-block w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center">Sin foto</span>
                            <?php endif; ?>
                        </td>

                        <td class="py-2 px-4 border-b">
                            <a href="paciente_controller.php?action=edit&id=<?php echo $paciente['id']; ?>" class="text-blue-600 hover:text-blue-700">Modificar</a> |
                            <a href="paciente_controller.php?action=delete&id=<?php echo $paciente['id']; ?>" class="text-red-600 hover:text-red-700" onclick="return confirm('¿Seguro que deseas eliminar este paciente?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="../panel.php" class="text-blue-600 hover:text-blue-700">Volver al panel</a>
        </div>
    </div>
</body>
</html>

<script>$(document).ready(function() {
    $('#cliente').select2({
        placeholder: 'Seleccione un paciente',
        allowClear: true
    });
});
</script>