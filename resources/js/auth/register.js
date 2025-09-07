import $ from 'jquery';
import { showPopup } from '../vendor/popup';
import flatpickr from '../vendor/flatpickr';
import { apiFetch } from '../auth/api';

$(function() {
    const registerForm = $('#registerForm');
    if (!registerForm.length) return;
    if ($('#birth_date').length) {
        flatpickr('#birth_date', {
            dateFormat: 'Y-m-d',
            maxDate: 'today',
            allowInput: false
        });
    }
    function extractToken(response) {
        if (response.extra && response.extra.token) return response.extra.token;
        if (response.token) return response.token;
        if (response.result && response.result.token) return response.result.token;
        if (response.data && response.data.token) return response.data.token;
        return null;
    }
    function extractErrorMsg(response) {
        if (response.errors && typeof response.errors === 'object') {
            // Laravel validation errors
            return Object.values(response.errors).flat().join('\n');
        }
        if (response.error) return response.error;
        if (response.message) return response.message;
        return 'Ошибка регистрации';
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
            const token = extractToken(response);
            if (token) {
                sessionStorage.setItem('auth_token', token);
                window.location.href = '/admin/events/';
            } else {
                showPopup(extractErrorMsg(response));
            }
        })
        .catch(err => {
            let msg = err && err.message ? err.message : 'Ошибка регистрации';
            showPopup(msg);
        });
    });
});
