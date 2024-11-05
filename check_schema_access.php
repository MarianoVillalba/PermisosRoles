<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'company_db';
$user = 'admin_user '; // Usar tu usuario 'mariano'
$password = 'admin_password'; // Tu contraseña

try {
    // Conectar a la base de datos
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos como $user .<br>";

    // Probar acceso a la tabla employee_info en el esquema hr
    echo "<h2>Accediendo a employee_info en el esquema hr:</h2>";
    $stmt_hr = $pdo->query("SELECT * FROM hr.employee_info");
    $rows_hr = $stmt_hr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows_hr as $row) {
        echo "ID: " . $row['id'] . ", Nombre: " . $row['nombre'] . ", Puesto: " . $row['puesto'] . "<br>";
    }

    // Probar acceso a la tabla sales_data en el esquema sales
    echo "<h2>Accediendo a sales_data en el esquema sales:</h2>";
    try {
        $stmt_sales = $pdo->query("SELECT * FROM sales.sales_data");
        $rows_sales = $stmt_sales->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows_sales as $row) {
            echo "ID: " . $row['id'] . ", Producto: " . $row['producto'] . ", Cantidad: " . $row['cantidad'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error al intentar acceder a sales_data: " . $e->getMessage(); // Esto debería mostrar un error de permisos
    }

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba de Acceso a Esquemas</title>
</head>
<body>
    <h1>Verificación de Acceso a Esquemas para read_user y admin_user</h1>
    <p>Comprobando el acceso a las tablas en los esquemas hr y sales.</p>
</body>
</html>
