<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'company_db';
$user = 'manager1'; // Usar el usuario 'manager1'
$password = 'manager1_password'; // Contraseña del usuario

try {
    // Conectar a la base de datos
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos como manager1.<br>";

    // Intentar realizar una consulta SELECT
    $stmt = $pdo->query("SELECT * FROM hr.employee_info");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Datos de la Tabla employee_info:</h2>";
    foreach ($rows as $row) {
        echo "ID: " . $row['id'] . ", Nombre: " . $row['nombre'] . ", Apellido: " . $row['apellido'] . ", Departamento: " . $row['departamento'] . "<br>";
    }

    // Intentar realizar una operación de UPDATE
    try {
        $pdo->exec("UPDATE hr.employee_info SET nombre = 'Nombre Actualizado' WHERE id = 1"); // Cambia 'Nombre Actualizado' y el id según tus datos
        echo "Registro actualizado correctamente.<br>";
    } catch (PDOException $e) {
        echo "Error al intentar actualizar datos: " . $e->getMessage(); // Esto debería mostrar un mensaje de éxito
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de Roles en Grupo</title>
</head>
<body>
    <h1>Verificación de Permisos para manager1</h1>
    <p>Comprobando los permisos de lectura y escritura en employee_info.</p>
</body>
</html>
