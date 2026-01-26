document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contact-form');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
      full_name: document.getElementById('nombre').value.trim(),
      email: document.getElementById('email').value.trim(),
      phone: document.getElementById('telefono').value.trim(),
      subject: document.getElementById('asunto').value.trim(),
      message: document.getElementById('mensaje').value.trim(),
    };

    // Validación rápida
    if (!payload.full_name || !payload.email || !payload.subject || !payload.message) {
      alert('Completa nombre, correo, asunto y mensaje.');
      return;
    }

    try {
      const resp = await fetch('../backend/api/contact_create.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });

      const text = await resp.text();
      let data = {};
      try { data = JSON.parse(text); } catch {}

      if (!resp.ok) {
        alert(data.error || text || 'Error enviando el mensaje.');
        return;
      }

      alert('Mensaje enviado. ¡Gracias por contactarnos!');
      form.reset();
    } catch (err) {
      console.error(err);
      alert('Error de red. Revisa que XAMPP esté encendido.');
    }
  });
});
