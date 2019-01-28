<html>
    <head>
	<link rel="icon" href="<?=SITE_URL?>views/images/favicon.ico" type="image/x-icon"/>
        <title>Forgot Password</title>
        <link href="<?=SITE_URL?>views/css/login.css" rel="stylesheet"/>
	<link href="<?=SITE_URL?>views/css/licensing.css" rel="stylesheet"/>
	 
	 <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>
	 <script type="text/javascript" src="<?=SITE_URL?>views/js/jquery-1.11.1.validate.js"></script>

<style>
span.form-field {
    display: block;
    margin-top: 10px;
}
</style>
<script language="javascript">
     $(document).ready(function () {
        $('#forgor-password').validate({
	    
            errorClass: "make-red",
            highlight: function (element, errorClass, validClass) {
                $(element.form).find("label[for=" + element.name + "]").addClass("error");
            },
            rules: {
                "username": {required: true},
            },
            messages: {
                "username": {required: "Please enter username"},
            },
            ignore: []
        });
    });

</script>

    </head>
    <body>
	<div id="header" align="left">
            <img src="<?=SITE_URL?>views/images/login/Incipio-Development-Support-Logo.png" alt="Incipio Design Support" id="incipio-logo"/>
        </div>
        
        <form id="forgor-password" action="" method="post" novalidate="novalidate">
	    <div class="error" style="text-align: center;">
		<?php if(isset($_SESSION['error'])) { ?>
		<span class="error" style="color:red;"><?php echo $_SESSION['error']; ?></span>
		<?php unset($_SESSION['error']); } ?>
	    </div>
	    <?php include_once 'views/messenger.php'; ?>
            <div id="form-holder">                
                <div align="center">		    
		     <span class="form-field">
			<!--<p class="contact"><label for="email"> Email</label></p>--> 
			<input type="text" class="required txtfield" placeholder="Enter username" id="ccustomername" name="username">
		    </span>

		    <span class="form-field">
                        <input type="submit" class="acive-button" name="submit" style="/*border: none; padding: 4px; */cursor: pointer;" value="Submit" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" class="acive-button" style="cursor: pointer;" value="Back" onclick="window.location.href='<?=SITE_URL?>backadmin'" />
<!--			<input type="submit" class="acive-button" name="submit" style="border: none; padding: 4px; cursor: pointer;" value="Submit" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="<?=SITE_URL?>backadmin" style="border: medium none; background: #f1f1f1;color: #000;font-size: 12px; padding: 4px 10px;text-decoration: none;">Back</a>-->
		    </span>
            </div></div>
        </form>
	
    </body></html>
