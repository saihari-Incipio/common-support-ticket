<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        
        <title>Sample Request Form</title>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>public/css/table_sorter/blue/style.css" />
        <link type="image/x-icon" href="<?=SITE_URL?>public/images/favicon.ico" rel="icon"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>public/css/jquery-ui/jquery-ui.min.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>public/css/design.css" />
<link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>public/css/customScroll_div.css" />
        <script type="text/javascript">
            var SITE_URL_MODULE = "<?= SITE_URL_MODULE ?>";
            var SITE_PUBLIC_URL = "<?= SITE_PUBLIC_URL ?>";
            var UNITED_STATES_COUNTRY_ID = "<?=UNITED_STATES_COUNTRY_ID?>";
            var UK_COUNTRY_ID = "<?=UK_COUNTRY_ID?>";
            var SITE_URL = "<?= SITE_URL ?>";
        </script>
        
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/tavikportal.js"></script> 
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/jquery-1.11.1.validate.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>public/css/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/dropdownchecklist/ui.dropdownchecklist.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/front.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/loadingoverlay.min.js"></script>
	<script type="text/javascript" src="<?= SITE_URL ?>public/js/security.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>public/js/customScroll_div.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                // hide error and success message after 5 seconds
                setTimeout(function(){ 
                    $(".fail, .success").html("");
                }, 5000);
                
            });
        </script>
    </head>
    <body>
        <!-- include header -->

        <?php //  GLOBAL $router; $controller =  strtolower($router->getController());
//        $controller = basename(str_replace('\\', DS, $controller));
//        if ($controller=='dashboard') {
//            include_once dirname(__FILE__) .'/header_dashboard.php';  
//        } else { 
            include_once dirname(__FILE__) .'/header.php'; 
//        } ?>
        <!-- end header -->

        <?php include_once DOC_ROOT_PATH.'/modules/common/views/messenger.php'; ?>

        <!-- include content -->
        <?php include_once $templatePath; ?>
        <!-- end content -->

        <!-- include footer -->
        <?php include_once dirname(__FILE__) .'/footer.php'; ?>
        <!-- end footer -->

    </body>
</html>