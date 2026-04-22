<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menú Principal</title>
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
.top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
h1 { font-size: 1.4rem; color: #58a6ff; letter-spacing: 0.5px; }
.menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
.menu-card {
    background: #161b22; border: 1px solid #21262d;
    border-radius: 8px; padding: 24px 20px; text-align: center;
    transition: transform .15s, border-color .15s;
}
.menu-card:hover { transform: translateY(-2px); border-color: #58a6ff; }
.menu-card h2 { font-size: 1.1rem; color: #c9d1d9; margin-bottom: 8px; }
.menu-card p { font-size: 0.85rem; color: #8b949e; margin-bottom: 16px; }
button, a.btn {
    padding: 8px 16px; border: none; border-radius: 6px;
    cursor: pointer; font-weight: 600; font-size: 0.88rem;
    transition: opacity .15s, transform .1s; white-space: nowrap;
    text-decoration: none; display: inline-block;
}
button:hover:not(:disabled), a.btn:hover { opacity: .85; }
button:active:not(:disabled), a.btn:active { transform: scale(.97); }
.btn-blue   { background: #1f6feb; color: #fff; }
.btn-green  { background: #238636; color: #fff; }
.btn-red    { background: #b62324; color: #fff; }
.btn-yellow { background: #d29922; color: #000; }
.btn-gray   { background: #21262d; color: #c9d1d9; border: 1px solid #30363d; }
</style>
</head>
<body>
<div class="container">
  <div class="top-bar">
    <h1>Sistema de Alumnos</h1>
  </div>
  <div class="menu-grid">
    <div class="menu-card">
      <h2>Altas</h2>
      <p>Registrar nuevo alumno</p>
      <a href="GuardarDatos.php" class="btn-blue">Ir a Altas</a>
    </div>
    <div class="menu-card">
      <h2>Bajas</h2>
      <p>Eliminar alumno</p>
      <a href="BorrarAlumno.php" class="btn-red">Ir a Bajas</a>
    </div>
    <div class="menu-card">
      <h2>Cambios</h2>
      <p>Modificar datos</p>
      <a href="Cambios.php" class="btn-yellow">Ir a Cambios</a>
    </div>
    <div class="menu-card">
      <h2>Consultas</h2>
      <p>Ver listado de alumnos</p>
      <a href="ConsultarAlumnos.php" class="btn-blue">Ir a Consultas</a>
    </div>
    <div class="menu-card">
      <h2>Evaluaciones</h2>
      <p>Gestión de evaluaciones</p>
      <a href="Evaluaciones.php" class="btn-green">Ir a Evaluaciones</a>
    </div>
  </div>
</div>
</body>
</html>