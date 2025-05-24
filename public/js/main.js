import { actualizarEvento } from './eventos.js';

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('btn-editar').addEventListener('click', () => {
        const evento = {
            ID_EVENTO: 1,
            TITULO: 'Nuevo Título desde main.js',
            DESCRIPCION: 'Descripción actualizada'
        };
        actualizarEvento(evento);
    });
});
// Aquí puedes agregar más código JavaScript para manejar otros eventos o funcionalidades


