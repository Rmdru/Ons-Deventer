<?php require "sessions.php"; ?>
<!--navigation-->
<nav class="navbar">
    <div class="wrapper">
        <div>
            <a href="/">
                <img src="../img/logoWhiteTransparent.svg" alt="Ons Deventer logo" />
            </a>
        </div>
        <div class="navbarLinks desktopOnly">
            <a href="/admin/" class="link" data-link="blog">Blog</a>
            <a href="wachtwoord-wijzigen" class="link" data-link="wachtwoord-wijzigen">Wachtwoord wijzigen</a>
        </div>
        <div class="desktopOnly">
            <div class="userInfo"></div>
        </div>
        <div class="mobileOnly">
            <div class="hamburgerIcon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="hiddenMenu">
                <div class="navbarLinks">
                    <a href="/admin/" class="link" data-link="blog">Blog</a>
                    <a href="wachtwoord-wijzigen" class="link" data-link="wachtwoord-wijzigen">Wachtwoord wijzigen</a>
                    <div class="userInfo"></div>
                </div>
            </div>
        </div>
    </div>
</nav>