<!DOCTYPE html>
<html lang="nl-NL" data-page="home">
    <head>
        <title>Home - Ons Deventer</title>
        <?php require "head.php"; ?>
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <!--header slider with swiper.js-->
        <header class="header">
            <div class="swiper headerSlider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="img/headerImg1.jpg" alt="Deventer" class="headerImg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="img/headerImg2.jpg" alt="Deventer" class="headerImg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="img/headerImg3.jpg" alt="Deventer" class="headerImg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="img/headerImg4.jpg" alt="Deventer" class="headerImg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="img/headerImg5.jpg" alt="Deventer" class="headerImg" />
                    </div>
                    <div class="swiper-slide">
                        <img src="img/headerImg6.jpg" alt="Deventer" class="headerImg" />
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </header>
        <!--highlighted section-->
        <div class="highlightedSection">
            <h2 class="title">Coming soon</h2>
            <p class="primaryTxt">Wij zijn achter de schermen nog druk bezig! Maar neem alvast een kijkje ;)<br />Volg ons Instagram account om up-to-date te blijven.</p>
            <a href="https://www.instagram.com/ons.deventer/" target="_blank" rel="noopener" class="primaryBtn animated"><i class="fab fa-instagram"></i>Bekijk ons Instagram<i class="material-icons">keyboard_arrow_right</i></a>
        </div>
        <div class="wrapper">
            <!--about section-->
            <div class="section row">
                <div class="column65">
                    <h2 class="title">Wie zijn wij?</h2>
                    <p class="primaryTxt">Wij zijn Ons Deventer. Een drietal scholieren en een tweetal studenten uit Deventer met een doel: we willen onze stem laten horen. We willen laten zien wie wij zijn en wat wij kunnen. We zijn niet 'maar' een paar tieners: wij zijn een paar tieners uit Deventer met oren en ogendie in staat zijn die te gebruiken door bijvoorbeeld ondernemers uit onze omgeving te helpen en om de wereld te laten zien hoe mooi onze stad is.</p>
                    <a href="wie-wij-zijn" class="primaryBtn">Kom meer te weten over ons</a>
                </div>
                <div class="column30">
                    <img src="img/aboutTeamImg1.jpg" alt="Deventer" class="img" />
                </div>
            </div>
            <!--blog section-->
            <div class="section blog">
                <h2 class="title">Recente blogs</h2>
                <div class="viewBlogOverviewSm"></div>
                <a href="blog" class="primaryBtn">Bekijk alle blogs</a>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>