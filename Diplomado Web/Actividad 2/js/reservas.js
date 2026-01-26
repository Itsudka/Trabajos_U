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
  btnConfirmarReserva.addEventListener('click', () => {
    alert('Reserva enviada (solo prototipo). ¡Gracias por reservar en Café Hogareño!');
  });

  // Activar tooltips de Bootstrap
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.forEach((tooltipTriggerEl) => {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
