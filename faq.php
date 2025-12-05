<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo"><img src="assets/logo nirdious.png" alt="logo nirdious" width="250px"></div>
            <ul class="nav-links">
                <li><a href="snake.html">Snake</a></li>
                <li><a href="#services">Femmes dans le numérique</a></li>
                <li><a href="#apropos">Nous Contacter</a></li>
                <li><a href="#contact">FAQ et Support</a></li>
                <li><a href="qcm.html">Nirdious Game</a></li>
            </ul>
            <button class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <main class="mainPage">
        <h1 class="pageTitle">FAQ et support</h1>

        <section class="textFAQ">

            <article class="articleFAQ">
                <h2 class="questionFAQ">
                    Pourquoi choisir Linux NIRD ?
                </h2>
                <p>Linux NIRD est un système d'exploitation fait par
                    l'enseignement et pour l'enseignement qui peut
                    être installé sûr tous types d'ordinateurs, même anciens. 
                    C'est une démarche fiable pour tous les aceurs du système 
                    éducatif et des territoires.
                </p>
            </article>
            
            <article class="articleFAQ">
                <h2 class="questionFAQ">
                Pourquoi Linux et pas Windows ?
                </h2>
                <p>Windows est un système d'exploitation payant et propriéraire,
                    ce qui veut dire qu'on ne peut pas modifier son fonctionnement
                    interne. De l'autre côté, Linux est gratuit et est open source,
                    donc bien plus personnalisable (c'est pourquoi Linux NIRD est 
                    dédié aux enseignants).
                    
                </p>
            </article>

            <article class="articleFAQ">
                <h2 class="questionFAQ">
                Comment installer Linux NIRD sûr mon ordinateur ?
                </h2>
                <p>Vous pouvez suivre les instructions du 
                    <a href="https://nird.forge.apps.education.fr/linux/" target="_blank">
                        site officiel de NIRD</a>
                    , dans la rubrique "Images à télécharger et graver sûr
                    clé USB"
                </p>
            </article>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 TechSolutions. Tous droits réservés.</p>
            <div class="social-links">
                <a href="#" aria-label="LinkedIn">LinkedIn</a>
                <a href="#" aria-label="Twitter">Twitter</a>
                <a href="#" aria-label="Facebook">Facebook</a>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>