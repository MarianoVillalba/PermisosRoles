<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'company_db';
$user = 'mariano'; // Usar tu usuario 'mariano'
$password = '123'; // Tu contraseña

try {
    // Conectar a la base de datos
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos como mariano.<br>";

    // Paso 1: Intentar realizar una consulta SELECT
    $stmt = $pdo->query("SELECT * FROM employees");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Datos de la Tabla Employees:</h2>";
    foreach ($rows as $row) {
        echo "ID: " . $row['id'] . ", Nombre: " . $row['nombre'] . ", Apellido: " . $row['apellido'] . ", Departamento: " . $row['departamento'] . "<br>";
    }

    // Paso 2: Intentar realizar una operación de escritura (INSERT)
    try {
        $pdo->exec("INSERT INTO employees (nombre, apellido, departamento) VALUES ('Carlos', 'López', 'Finance')");
    } catch (PDOException $e) {
        echo "Error al intentar insertar datos: " . $e->getMessage(); // Esto debería mostrar un error de permisos
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de Permisos Granulares</title>
</head>
<body>
    <h1>Verificación de Permisos para read_user</h1>
    <p>Comprobando los permisos de lectura y escritura.</p>
</body>
</html>
