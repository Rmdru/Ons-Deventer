<?php require "functions/functions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="blog-detail">
    <head>
        <title class="blogTitle"></title>
        <!--charset-->
        <meta charset="utf-8" />
        <!--author-->
        <meta name="author" content="Ons Deventer" />
        <!--viewport-->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--favicon-->
        <link href="../img/favicon.png" rel="icon" type="img/png" />
        <!--jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!--google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
        <!--google material icons-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <!--font awesome icons-->
        <script src="https://use.fontawesome.com/releases/v5.0.12/js/all.js" integrity="sha384-Voup2lBiiyZYkRto2XWqbzxHXwzcm4A5RfdfG6466bu5LqjwwrjXCMBQBLMWh7qR" crossorigin="anonymous"></script>
        <!--swiper.js css-->
        <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
        <!--quill.js css-->
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <!--css files-->
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <!--navigation-->
        <nav class="navbar">
            <div class="wrapper">
                <div>
                    <a href="/">
                        <img src="../img/logoWhiteTransparent.svg" alt="Ons Deventer logo" width='100' height='100' class="relativeUrl" />
                    </a>
                </div>
                <div class="navbarLinks desktopOnly">
                    <a href="../" class="link" data-link="home">Home</a>
                    <a href="../blog" class="link" data-link="blog">Blog</a>
                    <a href="../wie-wij-zijn" class="link" data-link="wie-wij-zijn">Wie wij zijn</a>
                    <a href="../sociale-media" class="link" data-link="sociale-media">Sociale media</a>
                    <a href="../contact" class="link" data-link="contact">Contact</a>
                </div>
                <div class="mobileOnly">
                    <div class="hamburgerIcon">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <div class="hiddenMenu">
                        <div class="navbarLinks">
                            <a href="../" class="link" data-link="home">Home</a>
                            <a href="../blog" class="link" data-link="blog">Blog</a>
                            <a href="../wie-wij-zijn" class="link" data-link="wie-wij-zijn">Wie wij zijn</a>
                            <a href="../sociale-media" class="link" data-link="sociale-media">Sociale media</a>
                            <a href="../contact" class="link" data-link="contact">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <?php
            $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
            $_SESSION['csrfToken'] = $csrfToken;
        ?>
        <input type="hidden" id="csrfToken" value="<?php echo $csrfToken; ?>" />
        <!--blog detail-->
        <div class="viewBlogDetail"></div>
        <!--footer-->
        <footer class="footer">
            <div class="row justifySpaceBetween">
                <div>
                    <a class="socialIcon" href="https://www.instagram.com/ons.deventer/" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <a class="socialIcon" href="https://wa.me/message/4V4DMCESYEYFH1" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                    <a class="socialIcon" href="mailto:onsdeventer0570@gmail.com" target="_blank" rel="noopener"><i class="material-icons">mail</i></a>
                    <a class="socialIcon" href="tel:+31 6 26666104"><i class="material-icons">phone</i></a>
                </div>
                <div>
                    <p class="secondaryTxt">© Ons Deventer <?php echo date("Y"); ?></p>
                </div>
                <div>
                    <a href="privacyverklaring" class="link">Privacyverklaring</a>
                </div>
            </div>
        </footer>
        <!--swiper.js-->
        <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
        <!--quill.js-->
        <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
        <!--js files-->
        <script src="../js/script.js"></script>
        <script src="../js/blog.js"></script>
        <script src="../js/comment.js"></script>
        <script src="../js/contact.js"></script>
        <script src="../js/user.js"></script>
        <script src="../js/whoWeAre.js"></script>
        <script src="../js/404.js"></script>
    </body>
</html>