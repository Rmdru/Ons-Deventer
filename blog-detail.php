<?php require "functions/functions.php"; ?>
<!DOCTYPE html>
<html lang="nl-NL">
    <head>
        <title class="blogTitle"></title>
        <?php require "head.php"; ?>
        <?php include "metaTags.php"; ?>
    </head>
    <body>
        <?php require "main.php"; ?>
        <?php require "navigation.php"; ?>
        <?php
            $csrfToken = bin2hex(openssl_random_pseudo_bytes(32));
            $_SESSION['csrfToken'] = $csrfToken;
        ?>
        <input type="hidden" id="csrfToken" value="<?php echo $csrfToken; ?>" />
        <!--blog detail-->
        <div class="viewBlogDetail"></div>
        <?php require "footer.php"; ?>
    </body>
</html>