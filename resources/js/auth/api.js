export async function apiFetch(url, options = {}) {
    const isAuthPage = window.location.pathname.startsWith('/admin/login') || window.location.pathname.startsWith('/admin/register');
    if (!url.includes('/login') && !url.includes('/register')) {
        const token = sessionStorage.getItem('auth_token');
        if (!token) {
            sessionStorage.removeItem('auth_token');
            if (!isAuthPage) {
                window.location.href = '/admin/login';
            }
            throw new Error('Not authenticated');
        }
        const check = await fetch('/api/check-token', {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        if (!check.ok) {
            sessionStorage.removeItem('auth_token');
            if (!isAuthPage) {
                window.location.href = '/admin/login';
            }
            throw new Error('Token invalid');
        }
        options.headers = options.headers || {};
        options.headers['Authorization'] = `Bearer ${token}`;
        options.headers['Accept'] = 'application/json';
    }
    return fetch(url, options);
}
