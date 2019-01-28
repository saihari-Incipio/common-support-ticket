<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ERP Service Ticket Generation</title>
        <link type="image/x-icon" href="<?=SITE_URL?>views/images/favicon.ico" rel="icon"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/licensing.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/timepicker/jquery-ui-timepicker-addon.css"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/style.css" />
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>  
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/lightbox.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.1.validate.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/dropdownchecklist/ui.dropdownchecklist.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/front.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/selectize.js"></script>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/selectize.default.css" />
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/loadingoverlay.min.js"></script>
        <script type="text/javascript">
            var SITE_URL = "<?= SITE_URL ?>";
             $(document).ready(function () {
        $(".messenger").delay(3000).fadeOut(400);
    });
        </script>
    </head>
    <body>
        <!-- include header -->
        <?php include_once 'views/front/header.php'; ?>
        <!-- end header -->

        <div class="messenger">
            <?php if(isset($_SESSION['message'])) { ?>
                 <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
            <?php unset($_SESSION['message']); } ?>
         </div>

        
        <!-- include content -->
        <?php include_once $templatePath; ?>
        <!-- end content -->

        <!-- include footer -->
        <?php include_once 'views/front/footer.php'; ?>
        <!-- end footer -->
    </body>
</html>