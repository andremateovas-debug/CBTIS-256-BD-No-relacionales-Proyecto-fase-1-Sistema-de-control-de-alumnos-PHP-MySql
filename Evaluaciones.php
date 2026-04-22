<?php
require __DIR__ . '/Conexion.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset('utf8mb4');

$result = $conn->query("SELECT numero_control, nombre, promedio FROM alumnos ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Evaluaciones</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Segoe UI', sans-serif;
    background: #0d1117;
    color: #c9d1d9;
    min-height: 100vh;
    padding: 20px 16px 60px;
}

.container { max-width: 980px; margin: 0 auto; }

.top-bar {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px; flex-wrap: wrap; gap: 10px;
}

h1 { font-size: 1.4rem; color: #58a6ff; letter-spacing: 0.5px; }

table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }

th {
    background: #0d1117; padding: 9px 12px; text-align: left;
    border-bottom: 2px solid #21262d; color: #8b949e;
    font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.6px;
}

td { padding: 9px 12px; border-bottom: 1px solid #1c2128; }

tr:hover td { background: #1c2128; }

a.btn {
    padding: 8px 16px; border-radius: 6px;
    font-weight: 600; font-size: 0.88rem;
    text-decoration: none;
}

.btn-gray {
    background: #21262d; color: #c9d1d9;
    border: 1px solid #30363d;
}
</style>
</head>
<body>

<div class="container">

  <div class="top-bar">
    <h1>Evaluaciones</h1>
    <a href="index.php" class="btn btn-gray">Volver al menú</a>
  </div>

  <table>
    <thead>
        <tr>
            <th>Número de Control</th>
            <th>Nombre</th>
            <th>Promedio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['numero_control']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['promedio']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
  </table>

</div>

</body>
</html>

<?php
$conn->close();
?>