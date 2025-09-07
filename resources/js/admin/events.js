import { apiFetch } from '../../js/auth/api';

function renderEvents(events, tbodyId) {
    const tbody = document.getElementById(tbodyId);
    if (!tbody) return;
    tbody.innerHTML = events.length
        ? events.map(event => `<tr><td><a href="/admin/events/${event.id}">${event.title}</a></td></tr>`).join('')
        : '<tr><td class="text-muted">Нет событий</td></tr>';
}

function fetchAllEvents() {
    apiFetch('/api/events')
        .then(res => res.json())
        .then(data => renderEvents(data.result || [], 'all-events-tbody'))
        .catch(() => renderEvents([], 'all-events-tbody'));
}

function fetchMyEvents() {
    apiFetch('/api/events/my')
        .then(res => res.json())
        .then(data => renderEvents(data.result || [], 'my-events-tbody'))
        .catch(() => renderEvents([], 'my-events-tbody'));
}

document.addEventListener('DOMContentLoaded', () => {
    fetchAllEvents();
    fetchMyEvents();
    setInterval(fetchAllEvents, 30000);
    setInterval(fetchMyEvents, 30000);
});
