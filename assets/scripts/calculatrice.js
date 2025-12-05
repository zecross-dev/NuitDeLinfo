// --- Logique calculatrice (Maths) ---
const screen = document.getElementById('screen');
const history = document.getElementById('history');
let a = null;            
let b = null;            
let op = null;           
let justEvaluated = false;

const fmt = (v) => {
    const s = String(v);
    return s.length > 18 ? Number(v).toExponential(6) : s;
};

const setScreen = (text) => { if(screen) screen.textContent = text; };

const updateHistory = () => {
    if(!history) return;
    const opMap = { '+':'+', '-':'−', '*':'×', '/':'÷' };
    if (a !== null && op) {
        history.textContent = `${fmt(a)} ${opMap[op] ?? op}`;
    } else {
        history.textContent = '';
    }
};

const inputDigit = (d) => {
    if (justEvaluated) {
        a = null; op = null; b = null; justEvaluated = false; 
        if(history) history.textContent = '';
    }
    if (b === null || (screen && screen.textContent === '0')) {
        b = d;
    } else {
        b = String(b) + d;
    }
    setScreen(b);
};

const inputDot = () => {
    if (justEvaluated) {
        a = null; op = null; b = '0'; justEvaluated = false; 
        if(history) history.textContent = '';
    }
    if (b === null) {
        b = '0.';
    } else if (!String(b).includes('.')) {
        b = String(b) + '.';
    }
    setScreen(b);
};

const setOperator = (newOp) => {
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
    setScreen('0'); 
    if(history) history.textContent = '';
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
    if(history) history.textContent = `${fmt(x)} ${({'+':'+' ,'-':'−','*':'×','/':'÷'})[op]} ${fmt(y)} =`;
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

/* =================================================================
   PARTIE MODIFIÉE : DRAG & DROP + FERMETURE
   ================================================================= */

// --- 1. Gestion de la Fermeture ---
const calcWindow = document.getElementById('calculator');
const closeBtn = document.getElementById('closeCalcBtn');

function closeWindow(event) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    if (calcWindow) calcWindow.style.display = 'none';
}

if (closeBtn) {
    closeBtn.addEventListener('click', closeWindow);
    // Empêche le drag de démarrer si on clique sur la croix
    closeBtn.addEventListener('mousedown', (e) => e.stopPropagation());
    closeBtn.addEventListener('touchstart', (e) => e.stopPropagation());
}

// --- 2. Drag & Drop (Correction "Saut" + Limites) ---
const handle = document.getElementById('dragHandle');

if (calcWindow && handle) {
    let isDragging = false;
    
    // Variables pour mémoriser les positions initiales
    let startMouseX = 0, startMouseY = 0;
    let startElemLeft = 0, startElemTop = 0;

    const onDragStart = (clientX, clientY) => {
        // Mémorise la souris
        startMouseX = clientX;
        startMouseY = clientY;
        
        // Mémorise la position de la div (C'est ça qui empêche le décalage !)
        startElemLeft = calcWindow.offsetLeft;
        startElemTop = calcWindow.offsetTop;

        isDragging = true;
        handle.setAttribute('aria-grabbed', 'true');
        handle.style.cursor = 'grabbing';
    };

    const onDragMove = (clientX, clientY) => {
        if (!isDragging) return;

        // Calcul du déplacement (Delta)
        const dx = clientX - startMouseX;
        const dy = clientY - startMouseY;

        // Application à la position d'origine
        let newLeft = startElemLeft + dx;
        let newTop = startElemTop + dy;

        // --- LIMITES (Reste dans le parent) ---
        // On récupère le conteneur parent (.mainGame)
        const container = calcWindow.offsetParent || document.body;
        
        const maxLeft = container.clientWidth - calcWindow.offsetWidth;
        const maxTop = container.clientHeight - calcWindow.offsetHeight;

        // Bloquer gauche/haut
        if (newLeft < 0) newLeft = 0;
        if (newTop < 0) newTop = 0;
        
        // Bloquer droite/bas
        if (newLeft > maxLeft) newLeft = maxLeft;
        if (newTop > maxTop) newTop = maxTop;

        // Appliquer
        calcWindow.style.left = newLeft + 'px';
        calcWindow.style.top = newTop + 'px';
    };

    const onDragEnd = () => {
        isDragging = false;
        handle.setAttribute('aria-grabbed', 'false');
        handle.style.cursor = 'grab';
    };

    // --- Événements Souris ---
    handle.addEventListener('mousedown', (e) => {
        // Clic gauche uniquement + ignore si sur bouton fermer
        if (e.button !== 0 || e.target.closest('#closeCalcBtn')) return;
        onDragStart(e.clientX, e.clientY);
        e.preventDefault();
    });

    window.addEventListener('mousemove', (e) => {
        if (isDragging) {
            onDragMove(e.clientX, e.clientY);
            e.preventDefault();
        }
    });

    window.addEventListener('mouseup', onDragEnd);

    // --- Événements Tactiles ---
    handle.addEventListener('touchstart', (e) => {
        if (e.target.closest('#closeCalcBtn')) return;
        const t = e.touches[0];
        onDragStart(t.clientX, t.clientY);
    }, { passive: false });

    window.addEventListener('touchmove', (e) => {
        if (isDragging) {
            const t = e.touches[0];
            onDragMove(t.clientX, t.clientY);
            if (e.cancelable) e.preventDefault();
        }
    }, { passive: false });

    window.addEventListener('touchend', onDragEnd);
    window.addEventListener('touchcancel', onDragEnd);
}
document.querySelector(".logoAppBtn").addEventListener("click", () => {
    document.querySelector(".window").style.display = "block";
});