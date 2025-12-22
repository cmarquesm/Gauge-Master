// --- Constantes físicas y materiales ---
const G = 386.4;
const K_PLAIN = 0.222;
const K_WOUND = 0.180;
const REF_SCALE = 25.5;

const tensionRef = { ligera: 85, media: 102, alta: 120 };

// --- Notas → frecuencia ---
function noteToFreq(note) {
  const notes = ['C','C#','D','D#','E','F','F#','G','G#','A','A#','B'];
  const name = note.replace(/[0-9]/g, '');
  const octave = parseInt(note.match(/\d+/)[0], 10);
  const semitone = notes.indexOf(name);
  const midi = semitone + (octave + 1) * 12;
  return 440 * Math.pow(2, (midi - 69) / 12);
}

// --- Calibre desde tensión ---
function gaugeFromTension(T, L, F) {
  let d = Math.sqrt((T * G) / (K_PLAIN * Math.pow(2 * L * F, 2)));
  let type = 'plain';
  if (d > 0.018) {
    d = Math.sqrt((T * G) / (K_WOUND * Math.pow(2 * L * F, 2)));
    type = 'wound';
  }
  return { diameter: d, type };
}

// --- Calcular tensión a partir de calibre ---
function tensionFromGauge(d, L, F) {
  const k = d > 0.018 ? K_WOUND : K_PLAIN;
  return k * Math.pow(d, 2) * Math.pow(2 * L * F, 2) / G;
}

// --- Cálculo principal ---
function calcularSet(afinacion, escala, nivel) {
  const Tref = tensionRef[nivel];
  const Ttotal = Tref * Math.pow(escala / REF_SCALE, 2);
  const Ti = Ttotal / afinacion.length;

  const resultado = afinacion.map(nota => {
    const F = noteToFreq(nota);
    const { diameter } = gaugeFromTension(Ti, escala, F);
    const dRounded = Math.round(diameter * 1000) / 1000;
    const Treal = tensionFromGauge(dRounded, escala, F);
    return {
      nota,
      frecuencia: F.toFixed(2),
      calibre: dRounded.toFixed(3),
      tension_lb: Treal.toFixed(1)
    };
  });

  const total = resultado.reduce((s, c) => s + parseFloat(c.tension_lb), 0);
  return { escala, total: total.toFixed(1), cuerdas: resultado };
}

// --- Render tabla editable ---
function renderTabla(afinacion, escala, nivel) {
  const tbody = document.getElementById('string-rows');
  tbody.innerHTML = '';

  const datos = calcularSet(afinacion, escala, nivel);

  const notasDisponibles = [];
  for (let oct = 1; oct <= 5; oct++) {
    ['C','C#','D','D#','E','F','F#','G','G#','A','A#','B'].forEach(n => {
      notasDisponibles.push(`${n}${oct}`);
    });
  }

  datos.cuerdas.forEach((cuerda, i) => {
    const tr = document.createElement('tr');
    const opciones = notasDisponibles
      .map(n => `<option value="${n}" ${n===cuerda.nota?'selected':''}>${n}</option>`)
      .join('');

    tr.innerHTML = `
      <td class="border p-1 text-center">${i + 1}</td>
      <td class="border p-1 text-center">
        <select class="nota-select border rounded p-1">${opciones}</select>
      </td>
      <td class="border p-1 text-center">
        <input type="number" value="${cuerda.calibre}" step="0.001" min="0.005" max="0.100" class="calibre-input border rounded p-1 w-20 text-center">
      </td>
      <td class="border p-1 text-center" data-tension>${cuerda.tension_lb}</td>
    `;
    tbody.appendChild(tr);
  });

  actualizarTensionTotal();
  activarRecalculo(escala);
}


// --- Recalcular tensiones al cambiar nota o calibre ---
function activarRecalculo(escala) {
  const filas = document.querySelectorAll('#string-rows tr');
  filas.forEach(fila => {
    const sel = fila.querySelector('.nota-select');
    const inp = fila.querySelector('.calibre-input');

    const recalcular = () => {
      const nota = sel.value;
      const calibre = parseFloat(inp.value);
      const F = noteToFreq(nota);
      const T = tensionFromGauge(calibre, escala, F);
      fila.querySelector('[data-tension]').textContent = T.toFixed(1);
      actualizarTensionTotal();
    };

    sel.addEventListener('change', recalcular);
    inp.addEventListener('input', recalcular);
  });
}


// --- Actualizar tensión total ---
function actualizarTensionTotal() {
  const tensiones = document.querySelectorAll('[data-tension]');
  const total = Array.from(tensiones).reduce((s, td) => s + parseFloat(td.textContent || 0), 0);
  document.getElementById('total-tension').textContent = total.toFixed(1);
}

// --- Inicialización ---
document.addEventListener('DOMContentLoaded', () => {
  const escalaInput = document.getElementById('scale');
  const tensionSel = document.getElementById('tension');
  const presetSel = document.getElementById('preset-tuning');
  const btn = document.getElementById('calc-btn');

  const afinaciones = {
    E_standard: ["E4", "B3", "G3", "D3", "A2", "E2"],
    Drop_D: ["E4", "B3", "G3", "D3", "A2", "D2"],
    Drop_B: ["F#4", "C#4", "A3", "E3", "B2", "B1"],
    Open_D: ["D4", "A3", "F#3", "D3", "A2", "D2"]
  };

  // inicial render
  renderTabla(afinaciones.E_standard, parseFloat(escalaInput.value), tensionSel.value);

  // cambiar preset
  presetSel.addEventListener('change', () => {
    renderTabla(afinaciones[presetSel.value], parseFloat(escalaInput.value), tensionSel.value);
  });

  // recalcular set completo
  btn.addEventListener('click', () => {
    renderTabla(afinaciones[presetSel.value], parseFloat(escalaInput.value), tensionSel.value);
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('save-tuning-form');
  if (!form) return;

  form.addEventListener('submit', () => {
    const notas = Array.from(document.querySelectorAll('.nota-select')).map(s => s.value);
    const calibres = Array.from(document.querySelectorAll('.calibre-input')).map(i => i.value);
    const tensiones = Array.from(document.querySelectorAll('[data-tension]')).map(td => td.textContent);
    const total = document.getElementById('total-tension').textContent;

    document.getElementById('tuning-notes').value = notas.join(',');
    document.getElementById('tuning-gauges').value = calibres.join(',');
    document.getElementById('tuning-tensions').value = tensiones.join(',');
    document.getElementById('tuning-total').value = total;
  });
});
