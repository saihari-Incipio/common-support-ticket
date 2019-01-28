<html>
    <head>
	<link rel="icon" href="<?=SITE_URL?>views/images/favicon.ico" type="image/x-icon"/>
        <title>Forgot Password</title>
        <link href="<?=SITE_URL?>views/css/login.css" rel="stylesheet"/>
	 <link href="<?=SITE_URL?>views/css/licensing.css" rel="stylesheet"/>
	 
	 <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>
	 <script type="text/javascript" src="<?=SITE_URL?>views/js/jquery-1.11.1.validate.js"></script>
<style>
.txtfield
{
    border-radius:25px;
    background:white;
    border:2px solid #a1a1a1;
    height:28px;
    width:200px;
    outline: none;
    background-repeat:no-repeat;
    background-position:7px 4px;
    padding-left:10px;
}

span.form-field {
    display: block;
    margin-top: 10px;
}
</style>
<script language="javascript">
    setTimeout(
	function() { $(':password').val(''); },
	1000  //1,000 milliseconds = 1 second
    );
    
     $(document).ready(function () {
        $('#forgor-password').validate({
	    
            errorClass: "make-red",
            highlight: function (element, errorClass, validClass) {
                $(element.form).find("label[for=" + element.id + "]").addClass("error");
            },
            rules: {
		"new_password": {required: true},
                "confirm_password": {required: true},
            },
            messages: {
		"new_password": {required: "Please enter New Password"},
                "confirm_password": {required: "Please enter Confirm Code"},
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
			<input type="password" class="required txtfield" placeholder="Enter New Password" id="new_password" name="new_password">
		    </span>
		    <span class="form-field">
			<input type="password" class="required txtfield" placeholder="Enter Confirm Password" id="confirm_password" name="confirm_password">
		    </span>

    <span class="form-field">
	<input type="submit" class="acive-button" name="submit" style="/*border: none; padding: 4px;*/ cursor: pointer;" value="Submit" />
    </span>
            </div></div>
        </form>
	
    </body></html>

