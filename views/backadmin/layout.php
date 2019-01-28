<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>

        <link type="image/x-icon" href="<?=SITE_URL?>views/images/favicon.ico" rel="icon"/>
        <title>CES Meeting Portal</title>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/table_sorter/blue/style.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/lightbox.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/timepicker/jquery-ui-timepicker-addon.css"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/datepickr/datepickr.css"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/tavikportal.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/licensing.css" />
        
        <script type="text/javascript">
            var SITE_URL = "<?= SITE_URL ?>";
        </script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>  
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/lightbox.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.1.validate.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/tavikportal.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/datepickr/datepickr.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/backadmin.js"></script>

    </head>
    <body style="background: url('<?= SITE_URL ?>views/images/ListView-GrayBackground.jpg') repeat; ">

        <!-- include header -->
        <?php include_once 'views/backadmin/header.php'; ?>
        <!-- end header -->
	
	<div class="messenger" style="text-align: center;">
            <?php if(isset($_SESSION['message'])) { ?>
                 <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
            <?php unset($_SESSION['message']); } ?>
         </div>

        <!-- include content -->
        <?php include_once $templatePath; ?>
        <!-- end content -->

        <!-- include footer -->
        <?php include_once 'views/backadmin/footer.php'; ?>
        <!-- end footer -->


        <script type="text/javascript" src="<?= SITE_URL ?>views/js/dropdownchecklist/ui.dropdownchecklist.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/front.js"></script>


    </body>
</html>