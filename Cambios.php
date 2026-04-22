<?php
require __DIR__ . '/Conexion.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset('utf8mb4');

$alumno  = null;
$mensaje = '';

if (isset($_GET['buscar'])) {
    $control = trim($_GET['control'] ?? '');
    if (!preg_match('/^\d{14}$/', $control)) {
        $mensaje = "⚠️ El número de control debe ser exactamente 14 dígitos.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM alumnos WHERE numero_control = ?");
        $stmt->bind_param("s", $control);
        $stmt->execute();
        $result = $stmt->get_result();
        $alumno = $result->fetch_assoc();
        if (!$alumno) {
            $mensaje = "⚠️ No se encontró ningún alumno con ese número de control.";
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    $control      = trim($_POST['control'] ?? '');
    $nombre       = trim($_POST['nombre'] ?? '');
    $especialidad = trim($_POST['especialidad'] ?? '');
    $edad         = (int) ($_POST['edad'] ?? 0);
    $sexo         = trim($_POST['sexo'] ?? '');
    $promedio     = (float) ($_POST['promedio'] ?? 0);
    $direccion    = trim($_POST['direccion'] ?? '');

    if (!preg_match('/^\d{14}$/', $control)) {
        $mensaje = "⚠️ Número de control inválido.";
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/u', $nombre)) {
        $mensaje = "⚠️ Nombre inválido.";
    } elseif ($edad < 10 || $edad > 99) {
        $mensaje = "⚠️ Edad inválida.";
    } elseif ($promedio < 0 || $promedio > 10) {
        $mensaje = "⚠️ Promedio inválido.";
    } else {
        $stmt = $conn->prepare("UPDATE alumnos SET nombre=?, especialidad=?, edad=?, sexo=?, promedio=?, direccion=? WHERE numero_control=?");
        $stmt->bind_param("ssisdss", $nombre, $especialidad, $edad, $sexo, $promedio, $direccion, $control);
        $stmt->execute();
        $mensaje = "✅ Datos actualizados correctamente.";
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cambios de Alumno</title>
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
.card {
    background: #161b22; border: 1px solid #21262d;
    border-radius: 8px; padding: 20px; margin-bottom: 20px;
}
.card h2 { font-size: 0.95rem; color: #e6edf3; margin-bottom: 14px; }
label { display: block; font-size: 0.8rem; color: #8b949e; margin-bottom: 4px; }
input[type="text"], input[type="number"], select {
    background: #0d1117; border: 1px solid #30363d; color: #c9d1d9;
    padding: 8px 12px; border-radius: 6px; width: 100%; outline: none;
    font-family: 'Segoe UI', sans-serif; font-size: 0.9rem;
}
select option { background: #161b22; }
input:focus, select:focus { border-color: #58a6ff; }
input.invalid, select.invalid { border-color: #f85149; }
input.valid, select.valid { border-color: #3fb950; }
input:disabled { opacity: 0.5; cursor: not-allowed; }
.field-wrap { margin-bottom: 14px; }
.error-msg { display: none; font-size: 0.75rem; color: #f85149; margin-top: 4px; }
.error-msg.show { display: block; }
.mensaje {
    padding: 10px 14px; border-radius: 6px; font-size: 0.88rem;
    margin-bottom: 16px; background: #161b22; border: 1px solid #21262d;
}
button {
    padding: 8px 16px; border: none; border-radius: 6px;
    cursor: pointer; font-weight: 600; font-size: 0.88rem;
    background: #1f6feb; color: #fff;
}
.btn-buscar { background: #9e6a03; color: #fff; }
.btn-buscar:hover { background: #bb8009; }
button:hover { opacity: 0.9; }
a.volver { color: #58a6ff; font-size: 0.85rem; text-decoration: none; }
a.volver:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
  <div class="top-bar">
    <h1>Cambios de Alumno</h1>
    <a href="index.php" class="volver">← Volver al menú</a>
  </div>

  <div class="card">
    <h2>Buscar alumno por número de control</h2>
    <form method="GET" action="" id="buscarForm" novalidate>
      <div class="field-wrap">
        <label>Número de Control</label>
        <input type="text" name="control" id="buscar_control" maxlength="14" inputmode="numeric"
               autocomplete="off" required value="<?= htmlspecialchars($_GET['control'] ?? '') ?>">
        <span class="error-msg" id="err_buscar_control">Debe ser exactamente 14 dígitos numéricos.</span>
      </div>
      <button type="submit" name="buscar" class="btn-buscar">Buscar</button>
    </form>
  </div>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
  <?php endif; ?>

  <?php if ($alumno): ?>
  <div class="card">
    <h2>Editar datos del alumno</h2>
    <form method="POST" action="" id="editarForm" novalidate>
      <input type="hidden" name="control" value="<?= htmlspecialchars($alumno['numero_control']) ?>">

      <div class="field-wrap">
        <label>Número de Control</label>
        <input type="text" value="<?= htmlspecialchars($alumno['numero_control']) ?>" disabled>
      </div>

      <div class="field-wrap">
        <label>Nombre</label>
        <input type="text" name="nombre" id="nombre" autocomplete="off" required
               value="<?= htmlspecialchars($alumno['nombre']) ?>">
        <span class="error-msg" id="err_nombre">Solo letras y espacios, sin números ni símbolos.</span>
      </div>

      <div class="field-wrap">
        <label>Especialidad</label>
        <select name="especialidad" id="especialidad" required>
          <option value="">-- Selecciona una especialidad --</option>
          <?php
          $especialidades = [
            'Técnico en Informática',
            'Técnico en Administración',
            'Técnico en Contabilidad',
            'Técnico en Electricidad',
            'Técnico en Electrónica',
            'Técnico en Mecánica',
            'Técnico en Enfermería',
            'Técnico en Turismo',
            'Otra',
          ];
          foreach ($especialidades as $esp):
            $sel = ($alumno['especialidad'] === $esp) ? 'selected' : '';
          ?>
            <option value="<?= htmlspecialchars($esp) ?>" <?= $sel ?>><?= htmlspecialchars($esp) ?></option>
          <?php endforeach; ?>
        </select>
        <span class="error-msg" id="err_especialidad">Selecciona una especialidad.</span>
      </div>

      <div class="field-wrap">
        <label>Edad</label>
        <input type="number" name="edad" id="edad" min="10" max="99" required
               value="<?= htmlspecialchars($alumno['edad']) ?>">
        <span class="error-msg" id="err_edad">Ingresa una edad válida (10–99).</span>
      </div>

      <div class="field-wrap">
        <label>Sexo</label>
        <select name="sexo" id="sexo" required>
          <option value="">-- Selecciona --</option>
          <option value="M" <?= $alumno['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
          <option value="F" <?= $alumno['sexo'] === 'F' ? 'selected' : '' ?>>Femenino</option>
        </select>
        <span class="error-msg" id="err_sexo">Selecciona un sexo.</span>
      </div>

      <div class="field-wrap">
        <label>Promedio</label>
        <input type="number" name="promedio" id="promedio" step="0.01" min="0" max="10" required
               value="<?= htmlspecialchars($alumno['promedio']) ?>">
        <span class="error-msg" id="err_promedio">Ingresa un promedio entre 0.00 y 10.00.</span>
      </div>

      <div class="field-wrap">
        <label>Dirección</label>
        <input type="text" name="direccion" id="direccion" required
               value="<?= htmlspecialchars($alumno['direccion']) ?>">
        <span class="error-msg" id="err_direccion">La dirección no puede estar vacía.</span>
      </div>

      <button type="submit" name="actualizar" style="margin-top:20px;">Guardar Cambios</button>
    </form>
  </div>
  <?php endif; ?>
</div>

<script>
document.getElementById('buscar_control').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 14);
});

document.getElementById('buscarForm').addEventListener('submit', function (e) {
    const input = document.getElementById('buscar_control');
    const err   = document.getElementById('err_buscar_control');
    const ok    = /^\d{14}$/.test(input.value);
    input.classList.toggle('invalid', !ok);
    input.classList.toggle('valid', ok);
    err.classList.toggle('show', !ok);
    if (!ok) e.preventDefault();
});

const editRules = {
    nombre:       { validate: v => v.trim().length >= 2 && /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/.test(v.trim()), errId: 'err_nombre' },
    especialidad: { validate: v => v !== '',                                                                errId: 'err_especialidad' },
    edad:         { validate: v => v !== '' && Number.isInteger(Number(v)) && Number(v) >= 10 && Number(v) <= 99, errId: 'err_edad' },
    sexo:         { validate: v => v !== '',                                                                errId: 'err_sexo' },
    promedio:     { validate: v => v !== '' && !isNaN(Number(v)) && Number(v) >= 0 && Number(v) <= 10,    errId: 'err_promedio' },
    direccion:    { validate: v => v.trim().length >= 3,                                                    errId: 'err_direccion' },
};

function validateEditField(id) {
    const input = document.getElementById(id);
    if (!input) return true;
    const rule = editRules[id];
    const ok   = rule.validate(input.value);
    input.classList.toggle('valid',   ok);
    input.classList.toggle('invalid', !ok);
    document.getElementById(rule.errId).classList.toggle('show', !ok);
    return ok;
}

const editarForm = document.getElementById('editarForm');
if (editarForm) {
    Object.keys(editRules).forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input',  () => validateEditField(id));
            el.addEventListener('blur',   () => validateEditField(id));
            el.addEventListener('change', () => validateEditField(id));
        }
    });

    editarForm.addEventListener('submit', function (e) {
        const allOk = Object.keys(editRules).map(id => validateEditField(id)).every(Boolean);
        if (!allOk) {
            e.preventDefault();
            const firstInvalid = editarForm.querySelector('.invalid');
            if (firstInvalid) firstInvalid.focus();
        }
    });
}
</script>
</body>
</html>