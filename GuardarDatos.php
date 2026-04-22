<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alta de Alumnos</title>
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
.field-wrap { margin-bottom: 14px; }
.error-msg {
    display: none; font-size: 0.75rem; color: #f85149;
    margin-top: 4px;
}
.error-msg.show { display: block; }
button {
    padding: 8px 16px; border: none; border-radius: 6px;
    cursor: pointer; font-weight: 600; font-size: 0.88rem;
    background: #1f6feb; color: #fff;
}
button:disabled { background: #21262d; color: #484f58; cursor: not-allowed; }
</style>
</head>
<body>
<div class="container">
  <div class="top-bar">
    <h1>Alta de Alumnos</h1>
    <a href="index.php" class="btn-gray">Volver al menú</a>
  </div>

  <div class="card">
    <h2>Dar de alta nuevo alumno</h2>
    <form action="Guardar.php" method="POST" id="altaForm" novalidate>

      <div class="field-wrap">
        <label>Número de Control</label>
        <input type="text" name="numero_control" id="numero_control"
               maxlength="14" inputmode="numeric" autocomplete="off" required>
        <span class="error-msg" id="err_control">Debe ser exactamente 14 dígitos numéricos.</span>
      </div>

      <div class="field-wrap">
        <label>Nombre del alumno</label>
        <input type="text" name="nombre" id="nombre" autocomplete="off" required>
        <span class="error-msg" id="err_nombre">Solo letras y espacios, sin números ni símbolos.</span>
      </div>

      <div class="field-wrap">
        <label>Especialidad</label>
        <select name="especialidad" id="especialidad" required>
          <option value="">-- Selecciona una especialidad --</option>
          <option value="">Tecnico en programamcion </option>
          <option value="Técnico en Informática">Logistica</option>
          <option value="Técnico en Administración">tecniso  en Administración de empresas</option>
          <option value="Técnico en Contabilidad">Técnico en Contabilidad</option>
          <option value="Técnico en Turismo">Turismo</option>
          <option value="Otra">Otra</option>
        </select>
        <span class="error-msg" id="err_especialidad">Selecciona una especialidad.</span>
      </div>

      <div class="field-wrap">
        <label>Edad</label>
        <input type="number" name="edad" id="edad" min="10" max="99" required>
        <span class="error-msg" id="err_edad">Ingresa una edad válida (10–99).</span>
      </div>

      <div class="field-wrap">
        <label>Promedio</label>
        <input type="number" step="0.01" name="promedio" id="promedio" min="0" max="10" required>
        <span class="error-msg" id="err_promedio">Ingresa un promedio entre 0.00 y 10.00.</span>
      </div>

      <div class="field-wrap">
        <label>Dirección</label>
        <input type="text" name="direccion" id="direccion" required>
        <span class="error-msg" id="err_direccion">La dirección no puede estar vacía.</span>
      </div>

      <button type="submit" id="submitBtn" style="margin-top:20px;">Guardar Alumno</button>
    </form>
  </div>
</div>

<script>
const rules = {
  numero_control: {
    validate: v => /^\d{14}$/.test(v),
    errId: 'err_control'
  },
  nombre: {
    validate: v => v.trim().length >= 2 && /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/.test(v.trim()),
    errId: 'err_nombre'
  },
  especialidad: {
    validate: v => v !== '',
    errId: 'err_especialidad'
  },
  edad: {
    validate: v => v !== '' && Number.isInteger(Number(v)) && Number(v) >= 10 && Number(v) <= 99,
    errId: 'err_edad'
  },
  promedio: {
    validate: v => v !== '' && !isNaN(Number(v)) && Number(v) >= 0 && Number(v) <= 10,
    errId: 'err_promedio'
  },
  direccion: {
    validate: v => v.trim().length >= 3,
    errId: 'err_direccion'
  }
};

function validateField(id) {
  const input = document.getElementById(id);
  const rule  = rules[id];
  const ok    = rule.validate(input.value);
  const err   = document.getElementById(rule.errId);

  input.classList.toggle('valid',   ok);
  input.classList.toggle('invalid', !ok);
  err.classList.toggle('show', !ok);

  return ok;
}

Object.keys(rules).forEach(id => {
  const el = document.getElementById(id);
  el.addEventListener('input',  () => validateField(id));
  el.addEventListener('blur',   () => validateField(id));
  el.addEventListener('change', () => validateField(id));
});

document.getElementById('numero_control').addEventListener('input', function () {
  this.value = this.value.replace(/\D/g, '').slice(0, 14);
});

document.getElementById('altaForm').addEventListener('submit', function (e) {
  const allOk = Object.keys(rules).map(id => validateField(id)).every(Boolean);
  if (!allOk) {
    e.preventDefault();
    const firstInvalid = document.querySelector('.invalid');
    if (firstInvalid) firstInvalid.focus();
  }
});
</script>
</body>
</html>