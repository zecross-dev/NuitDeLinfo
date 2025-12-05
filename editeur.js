const editor = document.getElementById('editor');
const header = document.getElementById('editor-header');
const closeBtn = document.querySelector('.close');
const container = document.getElementById('container');

let offsetX, offsetY, isDragging = false;

header.addEventListener('mousedown', (e) => {
    isDragging = true;
    offsetX = e.clientX - editor.offsetLeft;
    offsetY = e.clientY - editor.offsetTop;
    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
});

function onMouseMove(e) {
    if (!isDragging) return;
    let newLeft = e.clientX - offsetX;
    let newTop = e.clientY - offsetY;

    // Limites pour rester dans le container
    const maxLeft = container.clientWidth - editor.offsetWidth;
    const maxTop = container.clientHeight - editor.offsetHeight;

    if (newLeft < 0) newLeft = 0;
    if (newTop < 0) newTop = 0;
    if (newLeft > maxLeft) newLeft = maxLeft;
    if (newTop > maxTop) newTop = maxTop;

    editor.style.left = newLeft + 'px';
    editor.style.top = newTop + 'px';
}

function onMouseUp() {
    isDragging = false;
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseup', onMouseUp);
}

// Fermer l'éditeur
closeBtn.addEventListener('click', () => {
    editor.style.display = 'none';
});