import { fetchEvents, formatDate } from './events-utils';
import { apiFetch } from '../../js/auth/api';

function getEventIdFromUrl() {
    const match = window.location.pathname.match(/\/admin\/events\/(\d+)/);
    return match ? match[1] : null;
}

let currentUserId = null;

function renderEvent(event) {
    document.getElementById('event-title').textContent = event.title || '-';
    document.getElementById('event-description').textContent = event.description || '-';
    document.getElementById('event-date').textContent = event.created_at ? formatDate(event.created_at) : '-';
    const tbody = document.getElementById('event-participants');
    if (tbody) {
        tbody.innerHTML = event.participants && event.participants.length
            ? event.participants.map(u => `<tr><td><a href="/admin/users/${u.id}">${u.first_name} ${u.last_name}</a></td></tr>`).join('')
            : '<tr><td class="text-muted">Нет участников</td></tr>';
    }
    renderActionButton(event);
}

function renderActionButton(event) {
    const btnContainer = document.getElementById('event-action-btn');
    if (!btnContainer) return;
    if (!currentUserId) {
        btnContainer.innerHTML = '';
        return;
    }
    const isOwner = event.owner_id === currentUserId;
    const isParticipant = event.participants && event.participants.some(u => u.id === currentUserId);
    if (isOwner || isParticipant) {
        btnContainer.innerHTML = '<button class="btn btn-danger" id="leave-event-btn">Отказаться от участия</button>';
        document.getElementById('leave-event-btn').onclick = () => handleLeave(event.id);
    } else {
        btnContainer.innerHTML = '<button class="btn btn-success" id="join-event-btn">Принять участие</button>';
        document.getElementById('join-event-btn').onclick = () => handleJoin(event.id);
    }
}

function reloadEvent() {
    const eventId = getEventIdFromUrl();
    if (eventId) {
        apiFetch(`/api/events/${eventId}`)
            .then(res => res.json())
            .then(data => {
                if (data.result) {
                    renderEvent(data.result);
                }
            })
            .catch(() => {
                document.getElementById('event-title').textContent = 'Ошибка загрузки';
            });
    }
}

function initEventPage() {
    fetchEvents('/api/events', 'all-events-tbody');
    fetchEvents('/api/events/my', 'my-events-tbody', currentUserId);
    setInterval(() => fetchEvents('/api/events', 'all-events-tbody'), 30000);
    setInterval(() => fetchEvents('/api/events/my', 'my-events-tbody', currentUserId), 30000);
    const eventId = getEventIdFromUrl();
    if (eventId) {
        reloadEvent();
        setInterval(reloadEvent, 30000);
    }
}

function handleJoin(eventId) {
    apiFetch(`/api/events/${eventId}/join`, { method: 'POST' })
        .then(res => res.json())
        .then(() => {
            reloadEvent();
            fetchEvents('/api/events', 'all-events-tbody');
            fetchEvents('/api/events/my', 'my-events-tbody', currentUserId);
        });
}

function handleLeave(eventId) {
    apiFetch(`/api/events/${eventId}/leave`, { method: 'POST' })
        .then(res => res.json())
        .then(() => {
            reloadEvent();
            fetchEvents('/api/events', 'all-events-tbody');
            fetchEvents('/api/events/my', 'my-events-tbody', currentUserId);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    apiFetch('/api/me')
        .then(res => res.json())
        .then(data => {
            if (data && data.result && data.result.id) {
                currentUserId = data.result.id;
            }
            initEventPage();
        });
});
