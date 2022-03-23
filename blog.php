<!DOCTYPE html>
<html lang="nl-NL" data-page="blog">
    <head>
        <title>Blog - Ons Deventer</title>
        <?php require "head.php"; ?>
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--blog-->
            <div class="section blog">
                <h2 class="title">Blogs</h2>
                <div class="inputGroup">
                    <p class="txt">Sorteren op:</p>
                    <select class="inputField sortBySelect">
                        <option value="dateTimeDesc">Datum nieuw - oud</option>
                        <option value="dateTimeAsc">Datum oud - nieuw</option>
                        <option value="viewsDesc">Populariteit aflopend</option>
                        <option value="viewsAsc">Populariteit oplopend</option>
                        <option value="readTimeDesc">Leestijd aflopend</option>
                        <option value="readTimeAsc">Leestijd oplopend</option>
                        <option value="titleAsc">A - Z</option>
                        <option value="titleDesc">Z - A</option>
                    </select>
                </div>
                <div class="viewBlogOverview"></div>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>