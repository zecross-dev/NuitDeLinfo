<?php 
session_start();
$titre = "Nirdious Game";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="assets/css/nirdiousgame.css">
    </head>
    
    <body>
        <div>
        <?php require_once (__DIR__ . '/header.php'); ?>
        </div>
        <h2>NIRDIOUS GAME</h2>
        <div class="row">
            <div class="game">
                <div class="gameHead">
                </div>
                <div class="mainGame">

                    <div class="apps">
                        <button class="logoAppBtn">
                            <img src="assets/image/logoCalculatrice.png" width="50px">
                        </button>
                    </div>

                    <div class="window">
                        <?php require_once(__DIR__ . '/calculatrice.php'); ?>
                    </div>
                </div>
                <div class="footGame">

                </div>
            </div>
            <div class="levels">
                <div class="row">
                    <div class="level"></div>
                    <div class="level"></div>
                </div>
                <div class="row">
                    <div class="level"></div>
                    <div class="level"></div>
                </div>
                <div class="row">
                    <div class="level"></div>
                    <div class="level"></div>
                </div>
                <div class="row">
                    <div class="level"></div>
                    <div class="level"></div>
                </div>
            </div>
        </div>
        <a href="/qcm.php">Accédez aux qcm</a>
        <footer class="footer">
            <div class="footer-base">
                <a href="nous contacter">Nous contacter</a>
                <a href="/snake.php">SSSSSSSSSS</a> 
                <div class="instagram">
                    <img src="Instagram_logo_2022.svg.png">
                </div>
            </div>
        </footer>
    </body>
