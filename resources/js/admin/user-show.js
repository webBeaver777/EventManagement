import { apiFetch } from '../../js/auth/api';
import { formatDate } from './events-utils';

function getUserIdFromUrl() {
    const match = window.location.pathname.match(/\/admin\/users\/(\d+)/);
    return match ? match[1] : null;
}

function renderUser(user) {
    document.getElementById('user-id').textContent = user.id || '-';
    document.getElementById('user-login').textContent = user.login || '-';
    document.getElementById('user-first-name').textContent = user.first_name || '-';
    document.getElementById('user-last-name').textContent = user.last_name || '-';
    document.getElementById('user-registered-at').textContent = user.registered_at ? formatDate(user.registered_at) : '-';
    document.getElementById('user-birth-date').textContent = user.birth_date ? formatDate(user.birth_date) : '-';
    document.getElementById('user-fullname').textContent = `${user.first_name || ''} ${user.last_name || ''}`.trim() || '-';
}

document.addEventListener('DOMContentLoaded', () => {
    const userId = getUserIdFromUrl();
    if (userId) {
        apiFetch(`/api/users/${userId}`)
            .then(res => res.json())
            .then(data => {
                if (data.result) {
                    renderUser(data.result);
                }
            })
            .catch(() => {
                document.getElementById('user-fullname').textContent = 'Ошибка загрузки';
            });
    }
});
