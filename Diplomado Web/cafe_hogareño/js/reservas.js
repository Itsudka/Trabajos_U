document.addEventListener('DOMContentLoaded', () => {
  const mesas = document.querySelectorAll('.table-slot');
  const texto = document.getElementById('mesa-seleccionada');
  const inputMesaResumen = document.getElementById('mesa-resumen');
  const btnAbrirReserva = document.getElementById('btn-abrir-reserva');
  const btnConfirmarReserva = document.getElementById('btn-confirmar-reserva');

  // Selección de mesas
  mesas.forEach((mesa) => {
    mesa.addEventListener('click', () => {
      if (mesa.classList.contains('reserved')) return; // no seleccionar reservadas

      mesas.forEach(m => m.classList.remove('selected'));
      mesa.classList.add('selected');

      const nombre = mesa.dataset.table;
      const zona = mesa.dataset.zone;
      const capacidad = mesa.dataset.capacity || '2 personas';

      texto.textContent = `${nombre} seleccionada · ${capacidad} · ${zona}`;
    });
  });

  // Al abrir el modal, llenar el input con la mesa seleccionada
  btnAbrirReserva.addEventListener('click', () => {
    const seleccionada = document.querySelector('.table-slot.selected');

    if (!seleccionada) {
      texto.textContent = 'Por favor selecciona una mesa antes de hacer la reserva.';
      inputMesaResumen.value = '';
      // El modal igual se abre, pero sin mesa cargada
      return;
    }

    const nombre = seleccionada.dataset.table;
    const zona = seleccionada.dataset.zone;
    const capacidad = seleccionada.dataset.capacity || '2 personas';

    inputMesaResumen.value = `${nombre} · ${capacidad} · ${zona}`;
  });

  // Botón de "Confirmar reserva" (solo muestra un alert para el prototipo)
  btnConfirmarReserva.addEventListener('click', async () => {
    const seleccionada = document.querySelector('.table-slot.selected');
    if (!seleccionada) {
      alert('Selecciona una mesa.');
      return;
    }

    const payload = {
      table_code: seleccionada.dataset.table,
      table_zone: seleccionada.dataset.zone,
      table_type: seleccionada.dataset.type,
      capacity: seleccionada.dataset.capacity,

      customer_name: document.getElementById('nombreReserva').value.trim(),
      email: document.getElementById('correoReserva').value.trim(),
      reserve_date: document.getElementById('fechaReserva').value,
     

      start_time: document.getElementById('horaInicio').value,
      end_time: document.getElementById('horaFin').value,

      comments: document.getElementById('comentariosReserva').value.trim(),
      phone: ""
    };

    // validación rápida
    if (!payload.customer_name || !payload.email || !payload.reserve_date || !payload.start_time || !payload.end_time) {
      alert('Completa nombre, correo, fecha y hora inicio/fin.');
      return;
    }

    if (payload.end_time <= payload.start_time) {
      alert('La hora final debe ser mayor a la hora inicial.');
      return;
    }

    const resp = await fetch('../backend/api/reservations_create.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });

    const data = await resp.json();

    if (!resp.ok) {
      alert(data.error || 'Error al reservar.');
      return;
    }

    alert('Reserva creada con éxito.');
    // marca la mesa como reservada visualmente
    seleccionada.classList.remove('selected', 'available');
    seleccionada.classList.add('reserved');
  });

  // Activar tooltips de Bootstrap
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.forEach((tooltipTriggerEl) => {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });

  const dateInput = document.getElementById('filter-date');
  const hourSlider = document.getElementById('hour-slider');
  const hourLabel = document.getElementById('hour-label');

  function pad2(n) { return String(n).padStart(2, '0'); }
  function sliderToTime(value) { return `${pad2(value)}:00`; }

  function setDefaultDate() {
    const now = new Date();
    const yyyy = now.getFullYear();
    const mm = pad2(now.getMonth() + 1);
    const dd = pad2(now.getDate());
    dateInput.value = `${yyyy}-${mm}-${dd}`;
  }
  setDefaultDate();

  function updateHourLabel() {
    hourLabel.textContent = sliderToTime(hourSlider.value);
  }

  async function refreshReservedTables() {
    const date = dateInput.value;
    const time = sliderToTime(hourSlider.value);

    updateHourLabel();

    // Limpia estados visuales (solo afecta "reserved" y evita tocar selected del usuario)
    const all = document.querySelectorAll('.table-slot');
    all.forEach(btn => {
      // deja selected como está, pero recalcula si debe ser reserved
      if (btn.classList.contains('reserved')) btn.classList.remove('reserved');
      if (!btn.classList.contains('selected')) {
        btn.classList.add('available');
      }
    });

    try {
      const resp = await fetch(`../backend/api/reservations_list.php?date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}`);
      const data = await resp.json();

      if (!data.ok) throw new Error(data.error || 'API error');

      // Marca como reservadas
      const reserved = new Set(data.reservedTables || []);
      all.forEach(btn => {
        const code = btn.dataset.table; // asegúrate que sea "M1", "M2", etc.
        if (reserved.has(code)) {
          btn.classList.remove('available', 'selected');
          btn.classList.add('reserved');
        }
      });

    } catch (e) {
      console.error(e);
      // no interrumpimos UX, solo log
    }
  }

  dateInput.addEventListener('change', refreshReservedTables);
  hourSlider.addEventListener('input', refreshReservedTables);

  // Primer render
  refreshReservedTables();

});
