import { apiFetch } from '../../js/auth/api';

export function renderEvents(events, tbodyId, currentUserId = null) {
    const tbody = document.getElementById(tbodyId);
    if (!tbody) return;
    let filteredEvents = events;
    if (currentUserId && tbodyId === 'my-events-tbody') {
        filteredEvents = events.filter(event =>
            event.creator?.id === currentUserId ||
            (event.participants && event.participants.some(u => u.id === currentUserId))
        );
    }
    tbody.innerHTML = filteredEvents.length
        ? filteredEvents.map(event => `<tr><td><a href="/admin/events/${event.id}">${event.title}</a></td></tr>`).join('')
        : '<tr><td class="text-muted">Нет событий</td></tr>';
}

export function fetchEvents(url, tbodyId, currentUserId = null) {
    apiFetch(url)
        .then(res => res.json())
        .then(data => renderEvents(data.result || [], tbodyId, currentUserId))
        .catch(() => renderEvents([], tbodyId, currentUserId));
}

export function formatDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    if (isNaN(date)) return '-';
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
}
