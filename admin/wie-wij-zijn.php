<?php require "sessions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="adminDashboard wieWijZijnBewerken" data-page="wie-wij-zijn">
    <head>
        <title>Wie wij zijn pagina bewerken - Ons Deventer</title>
        <?php require "head.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--add blog-->
            <div class="content">
                <h2>Wie wij zijn pagina bewerken</h2>
                <div class="form">
                    <p>Sectie 1 - primaire titel:</p>
                    <input type="text" class="inputField section-1-primary-title" />
                    <p>Sectie 1 - tekst 1 - alinea 1:</p>
                    <textarea type="text" class="inputField section-1-txt-1-paragraph-1" rows="5"></textarea>
                    <p>Sectie 1 - tekst 1 - alinea 2:</p>
                    <textarea type="text" class="inputField section-1-txt-1-paragraph-2" rows="5"></textarea>
                    <p>Sectie 2 - primaire titel:</p>
                    <input type="text" class="inputField section-2-primary-title" />
                    <p>Sectie 2 - tekst 1 - alinea 1:</p>
                    <textarea type="text" class="inputField section-2-txt-1-paragraph-1" rows="5"></textarea>
                    <p>Sectie 3 - primaire titel:</p>
                    <input type="text" class="inputField section-3-primary-title" />
                    <div id="team"></div>
                    <input type="hidden" class="inputField hiddenField" />
                    <button class="primaryBtn submitWhoWeAre edit" type="button">Bewerken</button>
                    <div class="status"></div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>