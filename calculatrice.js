// --- Logique calculatrice ---
const screen = document.getElementById('screen');
const history = document.getElementById('history');
let a = null;            // opérande A
let b = null;            // opérande B (courant)
let op = null;           // opérateur actuel: '+','-','*','/'
let justEvaluated = false;

const fmt = (v) => {
    const s = String(v);
    return s.length > 18 ? Number(v).toExponential(6) : s;
};

const setScreen = (text) => { screen.textContent = text; };

const updateHistory = () => {
    const opMap = { '+':'+', '-':'−', '*':'×', '/':'÷' };
    if (a !== null && op) {
        history.textContent = `${fmt(a)} ${opMap[op] ?? op}`;
    } else {
        history.textContent = '';
    }
};

const inputDigit = (d) => {
    if (justEvaluated) {
        a = null; op = null; b = null; justEvaluated = false; history.textContent = '';
    }
    if (b === null || screen.textContent === '0') {
        b = d;
    } else {
        b = String(b) + d;
    }
    setScreen(b);
};

const inputDot = () => {
    if (justEvaluated) {
        a = null; op = null; b = '0'; justEvaluated = false; history.textContent = '';
    }
    if (b === null) {
        b = '0.';
    } else if (!String(b).includes('.')) {
        b = String(b) + '.';
    }
    setScreen(b);
};

const setOperator = (newOp) => {
    // Si on a déjà a et b et un op, on calcule en chaîne
    if (op && a !== null && b !== null) {
        evaluate();
    }
    if (b !== null && a === null) {
        a = parseFloat(b);
        b = null;
    }
    op = newOp;
    justEvaluated = false;
    updateHistory();
};

const clearAll = () => {
    a = null; b = null; op = null; justEvaluated = false;
    setScreen('0'); history.textContent = '';
};

const backspace = () => {
    if (b !== null && !justEvaluated) {
        b = String(b).slice(0, -1);
        if (b === '' || b === '-') b = null;
        setScreen(b ?? '0');
    }
};

const percent = () => {
    if (b !== null) {
        const val = parseFloat(b);
        // Si un opérateur existe (ex: a + b%), calcule b% de a
        if (a !== null && op) {
            b = (a * val) / 100;
        } else {
            b = val / 100;
        }
        setScreen(fmt(b));
    }
};

const evaluate = () => {
    const x = a;
    const y = b !== null ? parseFloat(b) : null;
    if (x === null || y === null || !op) return;

    let r;
    switch (op) {
        case '+': r = x + y; break;
        case '-': r = x - y; break;
        case '*': r = x * y; break;
        case '/': r = y === 0 ? '∞' : x / y; break;
        default: return;
    }

    setScreen(fmt(r));
    history.textContent = `${fmt(x)} ${({'+':'+' ,'-':'−','*':'×','/':'÷'})[op]} ${fmt(y)} =`;
    a = (typeof r === 'number') ? r : null;
    b = null;
    op = null;
    justEvaluated = true;
};

// --- Mapping des boutons ---
document.querySelectorAll('button.key').forEach(btn => {
    btn.addEventListener('click', () => {
        const num = btn.getAttribute('data-num');
        const action = btn.getAttribute('data-action');
        const operator = btn.getAttribute('data-op');

        if (num !== null) inputDigit(num);
        else if (action === 'dot') inputDot();
        else if (action === 'clear') clearAll();
        else if (action === 'back') backspace();
        else if (action === 'percent') percent();
        else if (action === 'equal') evaluate();
        else if (operator) {
            const map = { plus: '+', minus: '-', multiply: '*', divide: '/' };
            setOperator(map[operator]);
        }
    });
});

// --- Raccourcis clavier ---
const keyMapOps = { '+': '+', '-': '-', '*': '*', '/': '/' };
window.addEventListener('keydown', (e) => {
    const k = e.key;
    if (/\d/.test(k)) inputDigit(k);
    else if (k === '.' || k === ',') inputDot();
    else if (k in keyMapOps) setOperator(keyMapOps[k]);
    else if (k === 'Enter' || k === '=') evaluate();
    else if (k === 'Backspace') backspace();
    else if (k.toLowerCase() === 'c') clearAll();
    else if (k === '%') percent();
});

// --- Drag & Drop (souris et tactile) ---
const calc = document.getElementById('calculator');
const handle = document.getElementById('dragHandle');
let dragging = false;
let startX = 0, startY = 0, startLeft = 0, startTop = 0;

const clamp = (val, min, max) => Math.min(Math.max(val, min), max);

const startDrag = (clientX, clientY) => {
    const rect = calc.getBoundingClientRect();
    startX = clientX;
    startY = clientY;
    startLeft = rect.left;
    startTop = rect.top;
    dragging = true;
    handle.setAttribute('aria-grabbed', 'true');
};

const moveDrag = (clientX, clientY) => {
    if (!dragging) return;
    const dx = clientX - startX;
    const dy = clientY - startY;

    const newLeft = startLeft + dx;
    const newTop  = startTop + dy;

    // Conserver l’élément dans la fenêtre
    const maxLeft = window.innerWidth - calc.offsetWidth;
    const maxTop  = window.innerHeight - calc.offsetHeight;

    calc.style.left = clamp(newLeft, 0, Math.max(0, maxLeft)) + 'px';
    calc.style.top  = clamp(newTop, 0, Math.max(0, maxTop)) + 'px';
};

const endDrag = () => {
    dragging = false;
    handle.setAttribute('aria-grabbed', 'false');
};

// Souris
handle.addEventListener('mousedown', (e) => {
    startDrag(e.clientX, e.clientY);
    e.preventDefault();
});
window.addEventListener('mousemove', (e) => moveDrag(e.clientX, e.clientY));
window.addEventListener('mouseup', endDrag);

// Tactile
handle.addEventListener('touchstart', (e) => {
    const t = e.touches[0];
    startDrag(t.clientX, t.clientY);
}, { passive: true });
window.addEventListener('touchmove', (e) => {
    if (!dragging) return;
    const t = e.touches[0];
    moveDrag(t.clientX, t.clientY);
}, { passive: true });
window.addEventListener('touchend', endDrag);
window.addEventListener('touchcancel', endDrag);