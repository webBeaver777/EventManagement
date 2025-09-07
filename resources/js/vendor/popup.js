export function showPopup(message) {
    let popup = document.getElementById("popupError");
    if (!popup) {
        popup = document.createElement('div');
        popup.id = "popupError";
        popup.style.position = "fixed";
        popup.style.top = "30px";
        popup.style.right = "30px";
        popup.style.zIndex = 9999;
        popup.style.minWidth = "250px";
        popup.style.maxWidth = "400px";
        popup.style.background = "#dc3545";
        popup.style.color = "#fff";
        popup.style.padding = "20px 30px";
        popup.style.borderRadius = "8px";
        popup.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
        popup.style.fontSize = "1.1em";
        popup.style.display = "none";
        document.body.appendChild(popup);
    }
    popup.textContent = message;
    popup.style.display = "block";
    popup.style.opacity = 1;
    setTimeout(() => {
        popup.style.transition = "opacity 0.4s";
        popup.style.opacity = 0;
        setTimeout(() => { popup.style.display = "none"; }, 400);
    }, 4000);
}
