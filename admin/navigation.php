<?php require "sessions.php"; ?>
<!--navigation-->
<nav class="navbar">
    <div class="wrapper">
        <div>
            <a href="/">
                <img src="../img/logoWhiteTransparent.svg" alt="Ons Deventer logo" />
            </a>
        </div>
        <div class="navbarLinks">
            <a href="/admin/" class="link" data-link="dashboard">Overzicht</a>
            <a href="blog" class="link" data-link="blog">Blog</a>
            <a href="statistieken" class="link" data-link="statistieken">Statistieken</a>
            <a href="site-instellingen" class="link" data-link="site-instellingen">Site instellingen</a>
            <a href="account-instellingen" class="link" data-link="account-instellingen">Account instellingen</a>
        </div>
        <div>
            <div class="userInfo"></div>
        </div>
    </div>
</nav>