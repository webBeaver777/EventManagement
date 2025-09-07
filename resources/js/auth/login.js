import $ from 'jquery';
import { showPopup } from '../vendor/popup';
import { apiFetch } from '../auth/api';

$(function() {
    const loginForm = $('#loginForm');
    if (!loginForm.length) return;
    loginForm.on('submit', function(e) {
        e.preventDefault();
        const data = {
            login: $(this).find('[name=login]').val(),
            password: $(this).find('[name=password]').val(),
        };
        apiFetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            let token = response.extra && response.extra.token ? response.extra.token : (response.token ? response.token : null);
            if (token) {
                sessionStorage.setItem('auth_token', token);
                window.location.href = '/admin/events/';
            } else {
                let msg = (response.error) ? response.error : (response.message || 'Ошибка авторизации');
                showPopup(msg);
            }
        })
        .catch(err => {
            let msg = err && err.message ? err.message : 'Ошибка авторизации';
            showPopup(msg);
        });
    });
});
