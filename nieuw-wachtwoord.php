<?php require "functions/functions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="nieuw-wachtwoord" data-page="nieuw-wachtwoord">
    <head>
        <title>Nieuw wachtwoord aanmaken - Ons Deventer</title>
        <?php require "head.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <!--nieuw wachtwoord aanvragen-->
        <div class="centeredContainer">
            <div class="form">
                <a href="/">
                    <img src="img/logoTransparentSm.svg" alt="Ons Deventer logo" />
                </a>
                <h2 class="title">Nieuw wachtwoord aanmaken</h2>
                <?php
                //check if verification token is correct
                $verificationTokenUrl = $_GET["verificationToken"];
                $verificationTokenSession = $_SESSION["verificationToken"];

                if (!empty($verificationTokenSession) AND $verificationTokenSession == $verificationTokenUrl) {
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
                    <?php
                } else {
                    ?>
                    <p class="txt error"><span class="material-icons">close</span> Verificatie token onjuist! Probeer het opnieuw!</p>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>