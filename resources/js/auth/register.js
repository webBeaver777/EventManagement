import { showPopup } from '../vendor/popup';
import flatpickr from '../vendor/flatpickr';
import { apiFetch } from '../auth/api';

$(function() {
    const registerForm = $('#registerForm');
    if (!registerForm.length) return;
    if ($('#birth_date').length && typeof flatpickr === 'function') {
        flatpickr('#birth_date', {
            dateFormat: 'Y-m-d',
            maxDate: 'today',
            allowInput: false
        });
    }
    registerForm.on('submit', function(e) {
        e.preventDefault();
        const data = {
            first_name: $(this).find('[name=first_name]').val(),
            last_name: $(this).find('[name=last_name]').val(),
            login: $(this).find('[name=login]').val(),
            password: $(this).find('[name=password]').val(),
            password_confirmation: $(this).find('[name=password_confirmation]').val(),
            birth_date: $(this).find('[name=birth_date]').val(),
        };
        apiFetch('/api/register', {
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
                let msg = (response.error) ? response.error : (response.message || 'Ошибка регистрации');
                showPopup(msg);
            }
        })
        .catch(err => {
            let msg = err && err.message ? err.message : 'Ошибка регистрации';
            showPopup(msg);
        });
    });
});
