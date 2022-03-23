<?php require "sessions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="blog" data-page="blog">
    <head>
        <title>Blog - Ons Deventer</title>
        <?php require "head.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--blog-->
            <h2 class="title">Blog</h2>
            <a href="blog-toevoegen" class="primaryBtn"><span class="material-icons">add</span> Nieuwe blog</a>
            <div class="content"></div>
            <div class="popup deleteBlog">
                <div class="overlay"></div>
                <div class="window">
                    <span class='material-icons closeIcon' onclick="closePopup();">close</span></button>
                    <p>Weet je zeker dat je deze blog permanent wilt verwijderen?</p>
                    <div class="btnGroup">
                        <button class='primaryBtn error'><span class='material-icons'>delete</span> Verwijderen</button>
                        <button class='secondaryBtn' onclick="closePopup();"><span class='material-icons'>close</span> Annuleren</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>