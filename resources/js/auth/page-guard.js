(function() {
    const path = window.location.pathname;
    if (["/admin/login", "/admin/register"].some(p => path.startsWith(p))) return;
    const token = sessionStorage.getItem("auth_token");
    if (!token) return window.location.href = "/admin/login";
    fetch("/api/check-token", {
        headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" }
    }).then(r => {
        if (!r.ok) {
            sessionStorage.removeItem("auth_token");
            window.location.href = "/admin/login";
        }
    }).catch(() => {
        sessionStorage.removeItem("auth_token");
        window.location.href = "/admin/login";
    });
})();
