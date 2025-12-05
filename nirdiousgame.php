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
    </head>
    
    <body>
        <?php require_once (__DIR__ . '/header.php'); ?>
        <h2 class="titleGame">NIRDIOUS GAME</h2>
        <div class="row">
            <div class="game">
                <div class="gameHead">

                </div>
                <div class="mainGame">
                    <div class="apps">

                    </div>
                    <div class="window">
                        
                    </div>
                    <div class="window2">

                    </div>
                </div>
                <div class="footGame">

                </div>
            </div>
            <div class="levels">
                <div class="row"></div>
                <div class="row"></div>
                <div class="row"></div>
                <div class="row"></div>
            </div>
        </div>
        <?php require_once (__DIR__ . '/footer.php'); ?>
    </body>