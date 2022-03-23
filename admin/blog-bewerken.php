<?php require "sessions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL" class="adminDashboard blogBewerken" data-page="blog">
    <head>
        <title>Blog bewerken - Ons Deventer</title>
        <?php require "head.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <div class="wrapper">
            <!--add blog-->
            <div class="content">
                <h2>Blog bewerken</h2>
                <form enctype="multipart/form-data" action="models/blog.php?action=editThumbnail" method="POST" class="form">
                    <?php
                        $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
                        $_SESSION['csrfToken'] = $csrfToken;
                    ?>
                    <input type="hidden" id="csrfToken" value="<?php echo $csrfToken; ?>" />
                    <input type="hidden" id="uuid" />
                    <p>Thumbnail (leeg laten om huidige te behouden):</p>
                    <label for="thumbnail" class="primaryBtn">
                        Foto uploaden
                        <input type="file" name="file" id="thumbnail" />
                    </label>
                    <input type="hidden" id="fileType" />
                    <span id="filename"></span>
                    <p>Titel:</p>
                    <input type="text" class="inputField title" />
                    <p>Bodytekst:</p>
                    <div class="quillWysiwyg bodyTxt"></div>
                    <p>URL:</p>
                    <input type="text" class="inputField url" />
                    <p>Auteur:</p>
                    <input type="text" class="inputField author" />
                    <p>Leestijd (minuten):</p>
                    <input type="number" class="inputField readTime" />
                    <div class="inputGroup">
                        <p class="txt">Zichtbaarheid:</p>
                        <select class="inputField visibility">
                            <option value="1">Openbaar</option>
                            <option value="0">Privé</option>
                        </select>
                    </div>
                    <input type="hidden" class="hiddenField" />
                    <button class="primaryBtn submitBlog edit" type="button">Bewerken</button>
                    <div class="status"></div>
                </form>
            </div>
        </div>
        <?php require "footer.php"; ?>
    </body>
</html>