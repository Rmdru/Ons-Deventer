<!DOCTYPE html>
<html lang="nl-NL" data-page="wie-wij-zijn">
    <head>
        <title>Wie wij zijn - Ons Deventer</title>
        <?php require "head.php"; ?>
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--Wie wij zijn-->
            <div class="section">
                <h2 class="title section-1-primary-title"></h2>
                <p class="primaryTxt section-1-txt-1-paragraph-1"></p>
                <hr class="primaryDivider" />
                <p class="primaryTxt section-1-txt-1-paragraph-2"></p>
            </div>
            <div class="section">
                <h2 class="title section-2-primary-title"></h2>
                <p class="primaryTxt section-2-txt-1-paragraph-1"></p>
            </div>
            <div class="section team">
                <h2 class="title section-3-primary-title"></h2>
                <div class="grid">
                    <div class="gridItem">
                        <img src="img/bitemojiLotte.png" alt="Bitemoji Lotte" width='100' height='100' />
                        <h2 class="title section-3-person-1-name"></h2>
                        <p class="primaryTxt section-3-person-1-txt"></p>
                    </div>
                    <div class="gridItem">
                        <img src="img/bitemojiGijs.png" alt="Bitemoji Gijs" width='100' height='100' />
                        <h2 class="title section-3-person-2-name"></h2>
                        <p class="primaryTxt section-3-person-2-txt"></p>
                    </div>
                    <div class="gridItem">
                        <img src="img/bitemojiMarjolein.png" alt="Bitemoji Marjolein" width='100' height='100' />
                        <h2 class="title section-3-person-3-name"></h2>
                        <p class="primaryTxt section-3-person-3-txt"></p>
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>