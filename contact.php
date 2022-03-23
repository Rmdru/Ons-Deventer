<?php require "functions/functions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="contact" data-page="contact">
    <head>
        <title>Contact - Ons Deventer</title>
        <?php require "head.php"; ?>
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--blog-->
            <div class="section contact">
                <h2 class="title">Contact</h2>
                <div class="flex wrap space-between">
                    <div class="column">
                        <div class="grid">
                            <a class='socialIcon' href="https://wa.me/message/4V4DMCESYEYFH1" target="_blank">
                                <span class='fab fa-whatsapp'></span>
                                <p class="primaryTxt">WhatsApp</p>
                            </a>
                            <a class='socialIcon' href='mailto:onsdeventer0570@gmail.com' target='_blank'>
                                <span class='material-icons'>email</span>
                                <p class="primaryTxt">E-mail</p>
                            </a>
                            <a class='socialIcon' href='tel:+31 6 26666104' target='_blank'>
                                <span class='material-icons'>phone</span>
                                <p class="primaryTxt">Telefoon</p>
                            </a>
                        </div>
                    </div>
                    <div class="column">
                        <div class="form">
                            <?php
                                $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
                                $_SESSION['csrfToken'] = $csrfToken;
                            ?>
                            <input type="hidden" id="csrfToken" value="<?php echo $csrfToken; ?>" />
                            <input type="hidden" id="hiddenField" />
                            <input type="text" class="inputField" placeholder="Naam" id="name" />
                            <input type="text" class="inputField" placeholder="E-mailadres" id="email" />
                            <input type="text" class="inputField" placeholder="Onderwerp" id="subject" />
                            <textarea class="inputField" placeholder="Bericht" id="msg" rows="5"></textarea>
                            <div class="flex alignCenter">
                                <img src="" alt="CAPTCHA" class="captchaImg" id="captchaImg" />
                                <button class="secondaryBtn captchaReloadBtn" id="captchaReloadBtn"><span class="material-icons">refresh</span></button>
                            </div>
                            <input type="text" class="inputField" id="captcha" placeholder="CAPTCHA" />
                            <button class="primaryBtn submitContactForm">Verzenden</button>
                            <div class="status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>