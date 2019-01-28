<link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/style.css" />
<script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?=SITE_URL?>views/js/jquery-1.11.1.validate.js"></script>

<script language="javascript">
     $(document).ready(function () {
        $('#project-quotation').validate({
	    
            errorClass: "make-red",
            highlight: function (element, errorClass, validClass) {
                $(element.form).find("label[for=" + element.id + "]").addClass("error");
            },
            rules: {
                "current_password": {required: true},
		"change_password" : {required: true},
		"confirm_password":{ required:true },
            },
            messages: {
                "current_password": {required: "Please enter current password"},
		"change_password": {required: "Please enter new password"},
		"confirm_password": {required: "Please enter confirm password"},
            },
            ignore: []
        });
    });

        </script>  

<div class="messenger" style="text-align: center;">
    <?php if(isset($_SESSION['error'])) { ?>
    <span class="error" style="color:red;"><?php echo $_SESSION['error']; ?></span>
    <?php unset($_SESSION['error']); } ?>
</div>
<div class="form">
<form enctype="multipart/form-data" id="project-quotation" action="" method="post" novalidate="novalidate">
    <h2 style="text-align:center;">CHANGE PASSWORD</h2>
    
    <span class="form-field">
        <p class="contact"><label for="current_password"> Current Password</label></p> 
        <input type="password" class="required txtfield" placeholder="Enter Current Password" id="current_password" name="current_password">
    </span>
    
    <span class="form-field">
        <p class="contact"><label for="change_password"> New Password</label></p> 
        <input type="password" class="required txtfield" placeholder="Enter New Password" id="change_password" name="change_password">
    </span>
    
    <span class="form-field">
        <p class="contact"><label for="confirm_password"> Confirm Password</label></p> 
        <input type="password" class="required txtfield" placeholder="Enter Confirm Password" id="confirm_password" name="confirm_password">
    </span>
    
    <span class="form-field">
	<!--<input type="submit" class="acive-button" name="submit" style="border: none; padding: 4px; cursor: pointer;" value="" />-->
        <input type = "submit" name="submit" style="background-color: #231f20; color: white; width: 100px; border-radius: 16px;" value = "SUBMIT" >&nbsp;&nbsp;
        <input type="button" class="acive-button" style="background-color: #231f20; color: white; width: 100px; border-radius: 16px;" value="BACK" onclick="window.location.href='<?=SITE_URL?>backadmin'" />
	<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--	<a href="<?=SITE_URL?>backadmin" style="border: 1px solid #212121; background: #212121;color: #f4f4f4;border-radius: 10px;font-size: 14px; font-weight: bold;padding: 3px 20px;text-decoration: none;">BACK</a>-->
    </span>
  
</form>
	    
</div>