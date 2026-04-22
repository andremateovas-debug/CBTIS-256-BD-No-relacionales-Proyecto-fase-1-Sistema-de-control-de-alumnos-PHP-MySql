<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cbtis256";




$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?> 




<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Eliminar Alumno de la lista</title>
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


label { display: block; font-size: 0.8rem; color: #8b949e; margin-bottom: 4px; }
input[type="text"] {
    background: #0d1117; border: 1px solid #30363d; color: #c9d1d9;
    padding: 8px 12px; border-radius: 6px; width: 100%; outline: none;
    transition: border-color .15s; font-size: 0.9rem;
}
input:focus { border-color: #58a6ff; }






button, a.btn {
    padding: 8px 16px; border: none; border-radius: 6px;
    cursor: pointer; font-weight: 600; font-size: 0.88rem;
    transition: opacity .15s, transform .1s; white-space: nowrap;
    text-decoration: none; display: inline-block;

}
button:hover:not(:disabled), a.btn:hover { opacity: .85; }
button:active:not(:disabled), a.btn:active { transform: scale(.97); }
.btn-red    { background: #b62324; color: #fff; }
.btn-gray   { background: #21262d; color: #c9d1d9; border: 1px solid #30363d; }
.mensaje { margin-top: 20px; font-weight: bold; padding: 12px; border-radius: 6px; background: #161b22; border: 1px solid #21262d; }
</style>
</head>
<body>
<div class="container">

  <div class="top-bar">
    <h1>Eliminar Alumno</h1>
    <a href="index.php" class="btn-gray">Volver al menú</a>
  </div>

  <div class="card">
    <h2>Esto elimina el almuno de la lista</h2>
    <form method="GET" action="">
      <label>CAPTURA EL NÚMERO DE CONTROL</label>
      <input type="text" name="numero_control" required>
      <button type="submit" class="btn-red" style="margin-top:16px;">Eliminar</button>
    </form>
  </div>

  <div class="mensaje">
<?php
if (isset($_GET['numero_control'])) {
    $numero_control = $_GET['numero_control'];

    $sql = "DELETE FROM alumnos WHERE numero_control = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $numero_control);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "El alumno con número de control <b>$numero_control</b> ha sido eliminado correctamente.";
        } else {
            echo "No se encontró ningún alumno con el número de control <b>$numero_control</b>.";
        }
    } else {
        echo "Error al eliminar el registro: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
  </div>

</div>
</body>
</html>