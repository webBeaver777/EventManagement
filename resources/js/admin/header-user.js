import { apiFetch } from '../auth/api';

document.addEventListener('DOMContentLoaded', () => {
    apiFetch('/api/me')
        .then(res => res.json())
        .then(data => {
            if (data && data.result) {
                const user = data.result;
                const name = `${user.first_name || ''} ${user.last_name || ''}`.trim() || user.login || 'Пользователь';
                const profileLink = `/admin/users/${user.id}`;
                const nameSpan = document.getElementById('user-profile-name');
                const link = document.getElementById('user-profile-link');
                if (nameSpan) nameSpan.textContent = name;
                if (link) link.setAttribute('href', profileLink);
            }
        });
});
