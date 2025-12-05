<?php
header('Content-Type: image/svg+xml');

$width = 1400;
$height = 900;

// Couleurs professionnelles
$primary = '#2C3E50';
$secondary = '#3498DB';
$accent = '#E74C3C';
$gold = '#F39C12';
$silver = '#95A5A6';
?>
<?xml version="1.0" encoding="UTF-8"?>
<svg width="<?php echo $width; ?>" height="<?php echo $height; ?>" xmlns="http://www.w3.org/2000/svg">
    
    <!-- Définitions pour les dégradés et filtres -->
    <defs>
        <!-- Dégradé métallique -->
        <linearGradient id="metalGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#B8C5D6;stop-opacity:1" />
            <stop offset="50%" style="stop-color:#7F8C8D;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#4A5568;stop-opacity:1" />
        </linearGradient>
        
        <!-- Dégradé or -->
        <linearGradient id="goldGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#F9D423;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#E65C00;stop-opacity:1" />
        </linearGradient>
        
        <!-- Dégradé bleu -->
        <linearGradient id="blueGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#667EEA;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#764BA2;stop-opacity:1" />
        </linearGradient>
        
        <!-- Ombre portée -->
        <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="4"/>
            <feOffset dx="2" dy="4" result="offsetblur"/>
            <feComponentTransfer>
                <feFuncA type="linear" slope="0.3"/>
            </feComponentTransfer>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
            </feMerge>
        </filter>
        
        <!-- Lueur -->
        <filter id="glow">
            <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
            <feMerge>
                <feMergeNode in="coloredBlur"/>
                <feMergeNode in="SourceGraphic"/>
            </feMerge>
        </filter>
    </defs>
    
    <!-- Fond avec dégradé -->
    <rect width="<?php echo $width; ?>" height="<?php echo $height; ?>" fill="url(#blueGrad)"/>
    
    <!-- Grille de fond subtile -->
    <?php for ($i = 0; $i < $width; $i += 50): ?>
        <line x1="<?php echo $i; ?>" y1="0" x2="<?php echo $i; ?>" y2="<?php echo $height; ?>" 
              stroke="#FFFFFF" stroke-width="0.5" opacity="0.1"/>
    <?php endfor; ?>
    <?php for ($i = 0; $i < $height; $i += 50): ?>
        <line x1="0" y1="<?php echo $i; ?>" x2="<?php echo $width; ?>" y2="<?php echo $i; ?>" 
              stroke="#FFFFFF" stroke-width="0.5" opacity="0.1"/>
    <?php endfor; ?>
    
    <!-- Titre avec ombre -->
    <text x="<?php echo $width/2; ?>" y="50" text-anchor="middle" 
          font-family="Arial, sans-serif" font-size="42" font-weight="bold" 
          fill="#FFFFFF" filter="url(#shadow)">
        SYSTÈME CINÉTIQUE AVANCÉ
    </text>
    
    <!-- STRUCTURE 1: Rampe de lancement -->
    <g filter="url(#shadow)">
        <path d="M 80,120 L 320,220" stroke="url(#metalGrad)" stroke-width="8" 
              fill="none" stroke-linecap="round"/>
        <path d="M 80,135 L 320,235" stroke="url(#metalGrad)" stroke-width="8" 
              fill="none" stroke-linecap="round"/>
        <!-- Supports -->
        <?php for ($i = 0; $i < 5; $i++): 
            $x = 80 + $i * 60;
            $y = 120 + $i * 25;
        ?>
            <line x1="<?php echo $x; ?>" y1="<?php echo $y; ?>" 
                  x2="<?php echo $x; ?>" y2="<?php echo $y + 80; ?>" 
                  stroke="#34495E" stroke-width="4"/>
        <?php endfor; ?>
    </g>
    
    <!-- STRUCTURE 2: Engrenages précis (versions statiques qui disparaissent) -->
    <g filter="url(#shadow)">
        <!-- Grand engrenage -->
        <circle cx="380" cy="320" r="80" fill="url(#metalGrad)" stroke="#2C3E50" stroke-width="3">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <circle cx="380" cy="320" r="65" fill="#34495E">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <circle cx="380" cy="320" r="20" fill="url(#goldGrad)">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <?php for ($i = 0; $i < 16; $i++): 
            $angle = $i * 22.5;
            $rad = deg2rad($angle);
            $x1 = 380 + 70 * cos($rad);
            $y1 = 320 + 70 * sin($rad);
            $x2 = 380 + 85 * cos($rad);
            $y2 = 320 + 85 * sin($rad);
        ?>
            <line x1="<?php echo $x1; ?>" y1="<?php echo $y1; ?>" 
                  x2="<?php echo $x2; ?>" y2="<?php echo $y2; ?>" 
                  stroke="url(#goldGrad)" stroke-width="8" stroke-linecap="round">
                <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
            </line>
        <?php endfor; ?>
        
        <!-- Engrenage moyen -->
        <circle cx="520" cy="320" r="55" fill="url(#metalGrad)" stroke="#2C3E50" stroke-width="3">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <circle cx="520" cy="320" r="45" fill="#34495E">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <circle cx="520" cy="320" r="15" fill="url(#goldGrad)">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <?php for ($i = 0; $i < 12; $i++): 
            $angle = $i * 30;
            $rad = deg2rad($angle);
            $x1 = 520 + 48 * cos($rad);
            $y1 = 320 + 48 * sin($rad);
            $x2 = 520 + 58 * cos($rad);
            $y2 = 320 + 58 * sin($rad);
        ?>
            <line x1="<?php echo $x1; ?>" y1="<?php echo $y1; ?>" 
                  x2="<?php echo $x2; ?>" y2="<?php echo $y2; ?>" 
                  stroke="url(#goldGrad)" stroke-width="6" stroke-linecap="round">
                <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
            </line>
        <?php endfor; ?>
        
        <!-- Petit engrenage -->
        <circle cx="640" cy="320" r="40" fill="url(#metalGrad)" stroke="#2C3E50" stroke-width="3">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <circle cx="640" cy="320" r="32" fill="#34495E">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <circle cx="640" cy="320" r="12" fill="url(#goldGrad)">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
        </circle>
        <?php for ($i = 0; $i < 10; $i++): 
            $angle = $i * 36;
            $rad = deg2rad($angle);
            $x1 = 640 + 35 * cos($rad);
            $y1 = 320 + 35 * sin($rad);
            $x2 = 640 + 43 * cos($rad);
            $y2 = 320 + 43 * sin($rad);
        ?>
            <line x1="<?php echo $x1; ?>" y1="<?php echo $y1; ?>" 
                  x2="<?php echo $x2; ?>" y2="<?php echo $y2; ?>" 
                  stroke="url(#goldGrad)" stroke-width="5" stroke-linecap="round">
                <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="2.8s" fill="freeze"/>
            </line>
        <?php endfor; ?>
    </g>
    
    <!-- STRUCTURE 3: Bras pivotant (version statique qui disparaît) -->
    <g filter="url(#shadow)">
        <circle cx="720" cy="320" r="15" fill="#2C3E50">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="4.8s" fill="freeze"/>
        </circle>
        <rect x="720" y="315" width="180" height="10" fill="url(#metalGrad)" rx="5">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="4.8s" fill="freeze"/>
        </rect>
        <circle cx="900" cy="320" r="12" fill="url(#goldGrad)">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="4.8s" fill="freeze"/>
        </circle>
    </g>
    
    <!-- STRUCTURE 4: Rails incurvés -->
    <g filter="url(#shadow)">
        <path d="M 900,330 Q 1000,450 950,580" stroke="url(#metalGrad)" 
              stroke-width="8" fill="none" stroke-linecap="round"/>
        <path d="M 915,330 Q 1015,450 965,580" stroke="url(#metalGrad)" 
              stroke-width="8" fill="none" stroke-linecap="round"/>
    </g>
    
    <!-- STRUCTURE 5: Pendule (version statique qui disparaît) -->
    <g filter="url(#shadow)">
        <line x1="960" y1="580" x2="960" y2="480" stroke="#2C3E50" stroke-width="3">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="7.5s" fill="freeze"/>
        </line>
        <circle cx="960" cy="480" r="25" fill="url(#goldGrad)" stroke="#2C3E50" stroke-width="2">
            <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="7.5s" fill="freeze"/>
        </circle>
    </g>
    
    <!-- STRUCTURE 6: Dominos élégants (versions statiques qui disparaissent) -->
    <?php for ($i = 0; $i < 6; $i++): 
        $x = 1050 + $i * 35;
        $delay = 10.5 + $i * 0.25;
    ?>
        <g filter="url(#shadow)">
            <rect x="<?php echo $x; ?>" y="730" width="12" height="60" 
                  fill="url(#metalGrad)" rx="2">
                <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="<?php echo $delay; ?>s" fill="freeze"/>
            </rect>
            <rect x="<?php echo $x + 2; ?>" y="735" width="8" height="50" 
                  fill="#2C3E50" rx="1">
                <animate attributeName="opacity" from="1" to="0" dur="0.1s" begin="<?php echo $delay; ?>s" fill="freeze"/>
            </rect>
        </g>
    <?php endfor; ?>
    
    <!-- STRUCTURE 7: Bouton final -->
    <g filter="url(#shadow)">
        <rect x="1280" y="750" width="80" height="40" fill="#34495E" rx="5"/>
        <circle cx="1320" cy="755" r="20" fill="<?php echo $accent; ?>" filter="url(#glow)">
            <animate attributeName="fill" 
                     values="<?php echo $accent; ?>;#C0392B;<?php echo $accent; ?>" 
                     dur="1s" repeatCount="indefinite"/>
        </circle>
    </g>
    
    <!-- ANIMATIONS -->
    
    <!-- Boule 1: Descente rampe -->
    <circle r="18" fill="url(#goldGrad)" filter="url(#shadow)">
        <animateMotion dur="2s" fill="freeze">
            <mpath href="#path1"/>
        </animateMotion>
    </circle>
    <path id="path1" d="M 80,127 L 320,227" fill="none"/>
    
    <!-- Boule 1: Chute vers engrenage -->
    <circle r="18" fill="url(#goldGrad)" filter="url(#shadow)">
        <animateMotion dur="0.8s" begin="2s" fill="freeze">
            <mpath href="#path2"/>
        </animateMotion>
    </circle>
    <path id="path2" d="M 320,227 L 380,240" fill="none"/>
    
    <!-- Rotation engrenage 1 (apparaît quand le statique disparaît) -->
    <g transform="translate(380, 320)" opacity="0">
        <animate attributeName="opacity" from="0" to="1" dur="0.1s" begin="2.8s" fill="freeze"/>
        <circle cx="0" cy="0" r="80" fill="url(#metalGrad)" stroke="#2C3E50" stroke-width="3"/>
        <circle cx="0" cy="0" r="65" fill="#34495E"/>
        <circle cx="0" cy="0" r="20" fill="url(#goldGrad)"/>
        <?php for ($i = 0; $i < 16; $i++): 
            $angle = $i * 22.5;
            $rad = deg2rad($angle);
            $x1 = 70 * cos($rad);
            $y1 = 70 * sin($rad);
            $x2 = 85 * cos($rad);
            $y2 = 85 * sin($rad);
        ?>
            <line x1="<?php echo $x1; ?>" y1="<?php echo $y1; ?>" 
                  x2="<?php echo $x2; ?>" y2="<?php echo $y2; ?>" 
                  stroke="url(#goldGrad)" stroke-width="8" stroke-linecap="round">
                <animateTransform attributeName="transform" type="rotate"
                                  from="0 0 0" to="360 0 0" dur="2s" begin="2.8s" fill="freeze"/>
            </line>
        <?php endfor; ?>
    </g>
    
    <!-- Rotation engrenage 2 (inverse) (apparaît quand le statique disparaît) -->
    <g transform="translate(520, 320)" opacity="0">
        <animate attributeName="opacity" from="0" to="1" dur="0.1s" begin="2.8s" fill="freeze"/>
        <circle cx="0" cy="0" r="55" fill="url(#metalGrad)" stroke="#2C3E50" stroke-width="3"/>
        <circle cx="0" cy="0" r="45" fill="#34495E"/>
        <circle cx="0" cy="0" r="15" fill="url(#goldGrad)"/>
        <?php for ($i = 0; $i < 12; $i++): 
            $angle = $i * 30;
            $rad = deg2rad($angle);
            $x1 = 48 * cos($rad);
            $y1 = 48 * sin($rad);
            $x2 = 58 * cos($rad);
            $y2 = 58 * sin($rad);
        ?>
            <line x1="<?php echo $x1; ?>" y1="<?php echo $y1; ?>" 
                  x2="<?php echo $x2; ?>" y2="<?php echo $y2; ?>" 
                  stroke="url(#goldGrad)" stroke-width="6" stroke-linecap="round">
                <animateTransform attributeName="transform" type="rotate"
                                  from="0 0 0" to="-360 0 0" dur="2s" begin="2.8s" fill="freeze"/>
            </line>
        <?php endfor; ?>
    </g>
    
    <!-- Rotation engrenage 3 (apparaît quand le statique disparaît) -->
    <g transform="translate(640, 320)" opacity="0">
        <animate attributeName="opacity" from="0" to="1" dur="0.1s" begin="2.8s" fill="freeze"/>
        <circle cx="0" cy="0" r="40" fill="url(#metalGrad)" stroke="#2C3E50" stroke-width="3"/>
        <circle cx="0" cy="0" r="32" fill="#34495E"/>
        <circle cx="0" cy="0" r="12" fill="url(#goldGrad)"/>
        <?php for ($i = 0; $i < 10; $i++): 
            $angle = $i * 36;
            $rad = deg2rad($angle);
            $x1 = 35 * cos($rad);
            $y1 = 35 * sin($rad);
            $x2 = 43 * cos($rad);
            $y2 = 43 * sin($rad);
        ?>
            <line x1="<?php echo $x1; ?>" y1="<?php echo $y1; ?>" 
                  x2="<?php echo $x2; ?>" y2="<?php echo $y2; ?>" 
                  stroke="url(#goldGrad)" stroke-width="5" stroke-linecap="round">
                <animateTransform attributeName="transform" type="rotate"
                                  from="0 0 0" to="360 0 0" dur="2s" begin="2.8s" fill="freeze"/>
            </line>
        <?php endfor; ?>
    </g>
    
    <!-- Rotation bras pivotant (apparaît quand le statique disparaît) -->
    <g opacity="0">
        <animate attributeName="opacity" from="0" to="1" dur="0.1s" begin="4.8s" fill="freeze"/>
        <circle cx="720" cy="320" r="15" fill="#2C3E50" filter="url(#shadow)"/>
        <rect x="720" y="315" width="180" height="10" fill="url(#metalGrad)" rx="5" filter="url(#shadow)">
            <animateTransform attributeName="transform" type="rotate"
                              from="0 720 320" to="-60 720 320" dur="1.5s" begin="4.8s" fill="freeze"/>
        </rect>
        <circle cx="900" cy="320" r="12" fill="url(#goldGrad)" filter="url(#shadow)">
            <animateTransform attributeName="transform" type="rotate"
                              from="0 720 320" to="-60 720 320" dur="1.5s" begin="4.8s" fill="freeze"/>
        </circle>
    </g>
    
    <!-- Boule 2: Projection par bras -->
    <circle r="16" fill="#E74C3C" filter="url(#shadow)">
        <animateMotion dur="1.2s" begin="6.3s" fill="freeze">
            <mpath href="#path3"/>
        </animateMotion>
    </circle>
    <path id="path3" d="M 900,260 Q 920,300 950,340 Q 980,400 960,480" fill="none"/>
    
    <!-- Balancement pendule (apparaît quand le statique disparaît) -->
    <g transform="translate(960, 580)" opacity="0">
        <animate attributeName="opacity" from="0" to="1" dur="0.1s" begin="7.5s" fill="freeze"/>
        <line x1="0" y1="0" x2="0" y2="-100" stroke="#2C3E50" stroke-width="3">
            <animateTransform attributeName="transform" type="rotate"
                              values="0 0 0; 45 0 0; -45 0 0; 0 0 0"
                              dur="2s" begin="7.5s" fill="freeze"/>
        </line>
        <circle cx="0" cy="-100" r="25" fill="url(#goldGrad)" stroke="#2C3E50" stroke-width="2" filter="url(#shadow)">
            <animateTransform attributeName="transform" type="rotate"
                              values="0 0 0; 45 0 0; -45 0 0; 0 0 0"
                              dur="2s" begin="7.5s" fill="freeze"/>
        </circle>
    </g>
    
    <!-- Boule 3: Libérée par pendule -->
    <circle r="15" fill="<?php echo $gold; ?>" filter="url(#shadow)">
        <animateMotion dur="1s" begin="9.5s" fill="freeze">
            <mpath href="#path4"/>
        </animateMotion>
    </circle>
    <path id="path4" d="M 1000,580 L 1050,735" fill="none"/>
    
    <!-- Chute des dominos -->
    <?php for ($i = 0; $i < 6; $i++): 
        $x = 1050 + $i * 35;
        $delay = 10.5 + $i * 0.25;
    ?>
        <g filter="url(#shadow)">
            <rect x="<?php echo $x; ?>" y="730" width="12" height="60" 
                  fill="url(#metalGrad)" rx="2">
                <animateTransform attributeName="transform" type="rotate"
                                  from="0 <?php echo $x + 6; ?> 790"
                                  to="60 <?php echo $x + 6; ?> 790"
                                  dur="0.3s" begin="<?php echo $delay; ?>s" fill="freeze"/>
            </rect>
        </g>
    <?php endfor; ?>
    
    <!-- Activation bouton final -->
    <circle cx="1320" cy="755" r="20" fill="<?php echo $accent; ?>" filter="url(#glow)">
        <animate attributeName="cy" from="755" to="770" dur="0.2s" begin="12s" fill="freeze"/>
        <animate attributeName="r" from="20" to="18" dur="0.2s" begin="12s" fill="freeze"/>
    </circle>
    
    <!-- Effet final: Explosion de lumière -->
    <circle cx="<?php echo $width/2; ?>" cy="<?php echo $height/2; ?>" r="50" fill="#FFFFFF" opacity="0">
        <animate attributeName="opacity" values="0;0.8;0" dur="1s" begin="12.2s"/>
        <animate attributeName="r" from="50" to="600" dur="1s" begin="12.2s"/>
    </circle>
    
    <!-- Texte final -->
    <text x="<?php echo $width/2; ?>" y="<?php echo $height/2; ?>" 
          text-anchor="middle" font-family="Arial, sans-serif" 
          font-size="64" font-weight="bold" fill="#FFFFFF" 
          opacity="0" filter="url(#glow)">
        SÉQUENCE COMPLÉTÉE
        <animate attributeName="opacity" values="0;1;1;0" dur="3s" begin="12.2s"/>
    </text>
    
    <text x="<?php echo $width/2; ?>" y="<?php echo $height/2 + 60; ?>" 
          text-anchor="middle" font-family="Arial, sans-serif" 
          font-size="32" fill="#F39C12" opacity="0">
        ✓ Mission Réussie
        <animate attributeName="opacity" values="0;1;1;0" dur="3s" begin="12.5s"/>
    </text>
    
</svg>