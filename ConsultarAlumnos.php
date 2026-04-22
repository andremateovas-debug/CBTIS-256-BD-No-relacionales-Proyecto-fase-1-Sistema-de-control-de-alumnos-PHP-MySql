<?php
include("Conexion.php");

$sql = "SELECT * FROM alumnos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consultas</title>
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


.card {
    background: #161b22; border: 1px solid #21262d;
    border-radius: 8px; padding: 20px; margin-bottom: 20px;
}
.card h2 { font-size: 0.95rem; color: #e6edf3; margin-bottom: 14px; letter-spacing: 0.3px; }


table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
th {
    background: #0d1117; padding: 9px 12px; text-align: left;
    border-bottom: 2px solid #21262d; color: #8b949e;
    font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.6px;
}
td { padding: 9px 12px; border-bottom: 1px solid #1c2128; vertical-align: middle; }
tr:hover td { background: #1c2128; }




a.btn {
    padding: 8px 16px; border: none; border-radius: 6px;
    cursor: pointer; font-weight: 600; font-size: 0.88rem;
    transition: opacity .15s, transform .1s; white-space: nowrap;
    text-decoration: none; display: inline-block;
}
.btn-gray   { background: #21262d; color: #c9d1d9; border: 1px solid #30363d; }
</style>
</head>
<body>
<div class="container">

  <div class="top-bar">
    <h1>Consultas</h1>
    <a href="index.php" class="btn-gray">Volver al menú</a>
  </div>

  <div class="card">
    <h2>Listado de Alumnos</h2>
    <table>
        <tr>
            <th>Folio</th>
            <th>Número de Control</th>
            <th>Nombre</th>
            <th>Especialidad</th>
            <th>Edad</th>
            <th>Promedio</th>
            <th>Dirección</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['folio']}</td>
                        <td>{$row['numero_control']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['especialidad']}</td>
                        <td>{$row['edad']}</td>
                        <td>{$row['promedio']}</td>
                        <td>{$row['direccion']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay registros</td></tr>";
        }
        $conn->close();
        ?>
    </table>
  </div>

</div>
</body>
</html>