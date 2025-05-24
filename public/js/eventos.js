export async function actualizarEvento(evento) {
    const res = await fetch('/controllers/EventosController.php?action=actualizar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(evento)
    });

    const data = await res.json();
    if (!res.ok) {
        alert(data.error || 'Error desconocido');
        return;
    }

    alert('Evento actualizado con éxito');
}
