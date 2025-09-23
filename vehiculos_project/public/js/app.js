const baseApi = '../api/vehiculos';

document.getElementById('vehForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const data = {
    tipo: form.tipo.value,
    placa: form.placa.value.trim(),
    marca: form.marca.value.trim(),
    modelo: form.modelo.value.trim(),
    costoBase: form.costoBase.value
  };

  const resultEl = document.getElementById('result');
  resultEl.innerHTML = 'Enviando...';

  try {
    const res = await fetch(`${baseApi}/create.php`, {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify(data)
    });
    const json = await res.json();
    if (json.success) {
      resultEl.innerHTML = `<strong>Vehículo creado (id: ${json.id})</strong><br>Matrícula: ${json.matricula}`;
      form.reset();
    } else {
      resultEl.innerHTML = `<span class="small">Error: ${json.error}</span>`;
    }
  } catch (err) {
    resultEl.innerHTML = `<span class="small">Error de comunicación: ${err.message}</span>`;
  }
});

document.getElementById('btnList').addEventListener('click', async () => {
  const listEl = document.getElementById('list');
  listEl.innerHTML = 'Cargando lista...';
  try {
    const res = await fetch(`${baseApi}/list.php`);
    const json = await res.json();
    if (json.success) {
      if (json.data.length === 0) {
        listEl.innerHTML = '<em class="small">No hay vehículos.</em>';
        return;
      }
      let html = '<table class="table"><thead><tr><th>Tipo</th><th>Placa</th><th>Marca</th><th>Modelo</th><th>Costo Base</th><th>Matrícula</th></tr></thead><tbody>';
      json.data.forEach(r => {
        html += `<tr><td>${r.tipo}</td><td>${r.placa}</td><td>${r.marca}</td><td>${r.modelo}</td><td>${parseFloat(r.costoBase).toFixed(2)}</td><td>${r.matricula !== null ? parseFloat(r.matricula).toFixed(2) : ''}</td></tr>`;
      });
      html += '</tbody></table>';
      listEl.innerHTML = html;
    } else {
      listEl.innerHTML = `<span class="small">Error: ${json.error}</span>`;
    }
  } catch (err) {
    listEl.innerHTML = `<span class="small">Error de comunicación: ${err.message}</span>`;
  }
});
