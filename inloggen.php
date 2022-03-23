<?php
//start session
session_start();

//if user has autologin enabled, log user automatically in
if (isset($_SESSION['userLoggedIn'])) {
    setcookie("autologin", 1, time() + (86400 * 366), "/", "", true, true);
    header("location: /admin/");
}
?>
<!DOCTYPE html>
<html lang="nl-NL" class="inloggen">
    <head>
        <title>Inloggen - Ons Deventer</title>
        <?php require "head.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <!--inloggen-->
        <div class="centeredContainer">
            <div class="form">
                <a href="/">
                    <img src="img/logoTransparentSm.svg" alt="Ons Deventer logo" />
                </a>
                <?php
                    $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
                    $_SESSION['csrfToken'] = $csrfToken;
                ?>
                <div class="logIn">
                    <h2 class="title">Inloggen</h2>
                    <input type="hidden" class="csrfToken" value="<?php echo $csrfToken; ?>" />
                    <input type="hidden" class="hiddenField" />
                    <input type="text" class="inputField email" placeholder="E-mailadres" />
                    <input type="password" class="inputField psw" placeholder="Wachtwoord" />
                    <span class="material-icons showPswToggle">visibility</span>
                    <a class="link pswReset">Wachtwoord vergeten?</a>
                    <div class='checkbox'>
                        <label for='autologin'>
                            <input type='checkbox' class='autologin' />Ingelogd blijven
                        </label>
                    </div>
                    <button class="primaryBtn loginBtn">Inloggen</button>
                    <div class="status">
                        <?php
                        if (isset($_GET['loggedOut'])) {
                            if ($_GET['loggedOut'] == 1) {
                                echo "<p class='primaryTxt error'><i class='material-icons'>close</i> Je bent automatisch uitgelogd, omdat je IP-adres gewijzigd is en daarom word u verdacht van session hijacking.</p>";
                            } else if ($_GET['loggedOut'] == 2) {
                                echo "<p class='primaryTxt error'><i class='material-icons'>close</i> Je bent automatisch uitgelogd, omdat je een uur lang geen interactie hebt gemaakt met je account. Je kan hieronder gewoon weer inloggen.</p>";
                            }
                        }                        
                        ?>
                    </div>
                </div>
                <div class="pswReset">
                    <h2 class="title">Wachtwoord herstellen</h2>
                    <a class="link back"><span class="material-icons">arrow_back</span> Terug naar inloggen</a>
                    <input type="hidden" class="csrfToken" value="<?php echo $csrfToken; ?>" />
                    <input type="hidden" class="hiddenField" />
                    <input type="text" class="inputField email" placeholder="E-mailadres" />
                    <button class="primaryBtn pswResetBtn">Herstel link aanvragen</button>
                    <div class="status">
                        <?php
                        if (isset($_GET['loggedOut'])) {
                            if ($_GET['loggedOut'] == 1) {
                                echo "<p class='primaryTxt error'><i class='material-icons'>close</i> Je bent automatisch uitgelogd, omdat je IP-adres gewijzigd is en daarom word u verdacht van session hijacking.</p>";
                            } else if ($_GET['loggedOut'] == 2) {
                                echo "<p class='primaryTxt error'><i class='material-icons'>close</i> Je bent automatisch uitgelogd, omdat je een uur lang geen interactie hebt gemaakt met je account. Je kan hieronder gewoon weer inloggen.</p>";
                            }
                        }                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>