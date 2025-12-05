const editor = document.getElementById('editor');
const header = document.getElementById('editorHeader');
const closeBtn = document.getElementById('editorClose');

// Fermer l'éditeur
closeBtn.addEventListener('click', () => {
    editor.style.display = 'none';
});

// Drag & drop
let dragging = false;
let offsetX, offsetY;

header.addEventListener('mousedown', (e) => {
    dragging = true;
    offsetX = e.clientX - editor.offsetLeft;
    offsetY = e.clientY - editor.offsetTop;
    e.preventDefault();
});

document.addEventListener('mousemove', (e) => {
    if (dragging) {
        editor.style.left = (e.clientX - offsetX) + 'px';
        editor.style.top = (e.clientY - offsetY) + 'px';
    }
});

document.addEventListener('mouseup', () => {
    dragging = false;
});

// Support tactile
header.addEventListener('touchstart', (e) => {
    dragging = true;
    const t = e.touches[0];
    offsetX = t.clientX - editor.offsetLeft;
    offsetY = t.clientY - editor.offsetTop;
}, { passive: true });

document.addEventListener('touchmove', (e) => {
    if (dragging) {
        const t = e.touches[0];
        editor.style.left = (t.clientX - offsetX) + 'px';
        editor.style.top = (t.clientY - offsetY) + 'px';
    }
}, { passive: true });

document.addEventListener('touchend', () => {
    dragging = false;
});