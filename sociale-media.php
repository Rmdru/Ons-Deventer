<!DOCTYPE html>
<html lang="nl-NL" class="socialMedia" data-page="sociale-media">
    <head>
        <title>Sociale media - Ons Deventer</title>
        <?php require "head.php"; ?>
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--blog-->
            <div class="section social">
                <div class="flex wrap space-between">
                    <div class="column">
                        <h2 class="title">Volg ons op Instagram</h2>
                        <a href="https://www.instagram.com/ons.deventer/" target="_blank" rel="noopener" class="primaryBtn animated"><i class="fab fa-instagram"></i>Bekijk ons Instagram<i class="material-icons">keyboard_arrow_right</i></a>
                    </div>
                    <div class="column">
                        <h2 class="title">Deel deze website</h2>
                        <div class="grid">
                            <a class='socialIcon' onclick="copyLink();" data-url="https://onsdeventer.nl/">
                                <span class='material-icons'>link</span>
                                <p class="primaryTxt">Link kopiëren</p>
                            </a>
                            <a class='socialIcon' href='mailto:?body=https://onsdeventer.nl/' target='_blank'>
                                <span class='material-icons'>email</span>
                                <p class="primaryTxt">E-mail</p>
                            </a>
                            <a class='socialIcon' href='https://wa.me/?text=https://onsdeventer.nl/' target='_blank'>
                                <span class='fab fa-whatsapp'></span>
                                <p class="primaryTxt">WhatsApp</p>
                            </a>
                            <a class='socialIcon' href='http://www.facebook.com/sharer/sharer.php?u=https://onsdeventer.nl/' target='_blank'>
                                <span class='fab fa-facebook'></span>
                                <p class="primaryTxt">Facebook</p>
                            </a>
                            <a class='socialIcon' href='https://twitter.com/intent/tweet?url=https://onsdeventer.nl/' target='_blank'>
                                <span class='fab fa-twitter'></span>
                                <p class="primaryTxt">Twitter</p>
                            </a>
                            <a class='socialIcon' href='https://www.linkedin.com/cws/share?url=https://onsdeventer.nl/' target='_blank'>
                                <span class='fab fa-linkedin'></span>
                                <p class="primaryTxt">LinkedIn</p>
                            </a>
                            <button class='socialIcon shareSiteBttn' data-title="Ons Deventer" data-url="https://onsdeventer.nl/">
                                <i class="material-icons">share</i>
                                <p class="primaryTxt">Delen op een andere manier</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>