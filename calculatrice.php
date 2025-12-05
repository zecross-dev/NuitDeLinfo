<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Calculatrice draggable</title>
        <link rel="stylesheet" href="calculatrice.css">
    </head>
    <body>

    <div class="calculator" id="calculator" aria-label="Calculatrice draggable">
        <div class="calc-header" id="dragHandle" aria-grabbed="false">
            <div class="window-dots">
                <div class="dot"></div><div class="dot"></div><div class="dot"></div>
            </div>
            Calculatrice
        </div>

        <div class="display" aria-live="polite">
            <div class="history" id="history"></div>
            <div class="screen" id="screen">0</div>
        </div>

        <div class="keys" role="group" aria-label="Touches de la calculatrice">
            <!-- Ligne 1 -->
            <button class="key action" data-action="clear">AC</button>
            <button class="key action" data-action="back">⌫</button>
            <button class="key action" data-action="percent">%</button>
            <button class="key op" data-op="divide">÷</button>

            <!-- Ligne 2 -->
            <button class="key" data-num="7">7</button>
            <button class="key" data-num="8">8</button>
            <button class="key" data-num="9">9</button>
            <button class="key op" data-op="multiply">×</button>

            <!-- Ligne 3 -->
            <button class="key" data-num="4">4</button>
            <button class="key" data-num="5">5</button>
            <button class="key" data-num="6">6</button>
            <button class="key op" data-op="minus">−</button>

            <!-- Ligne 4 -->
            <button class="key" data-num="1">1</button>
            <button class="key" data-num="2">2</button>
            <button class="key" data-num="3">3</button>
            <button class="key op" data-op="plus">+</button>

            <!-- Ligne 5 -->
            <button class="key zero" data-num="0">0</button>
            <button class="key" data-action="dot">.</button>
            <button class="key equal" data-action="equal">=</button>
        </div>
    </div>
    <script src="calculatrice.js"></script>
    </body>
</html>