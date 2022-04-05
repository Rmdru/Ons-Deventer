<?php require "sessions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="wachtwoord-wijzigen" data-page="wachtwoord-wijzigen">
    <head>
        <title>Wachtwoord wijzigen - Ons Deventer</title>
        <?php require "head.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <!--nieuw wachtwoord aanvragen-->
        <div class="centeredContainer">
            <div class="form">
                <a href="/">
                    <img src="../img/logoTransparentSm.svg" alt="Ons Deventer logo" />
                </a>
                <h2 class="title">Wachtwoord wijzigen</h2>
                <?php
                $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
                $_SESSION['csrfToken'] = $csrfToken;
                ?>
                <input type="hidden" class="csrfToken" value="<?php echo $csrfToken; ?>" />
                <input type="hidden" class="hiddenField" />
                <input type="password" class="inputField psw" placeholder="Wachtwoord" />
                <div class="inputIcons">
                    <span class="material-icons generateRandomPswBtn inputIcon">shuffle</span>
                    <span class="material-icons showPswToggle inputIcon">visibility</span>
                </div>
                <input type="password" class="inputField pswRepeat" placeholder="Wachtwoord herhalen" />
                <button class="primaryBtn newPswBtn">Nieuw wachtwoord aanmaken</button>
                <div class="status"></div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>