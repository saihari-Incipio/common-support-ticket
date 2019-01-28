<html>
    <head>
        <link rel="icon" href="<?=SITE_URL?>views/images/favicon.ico" type="image/x-icon"/>
        <title>Admin Panel</title>
        <link href="<?=SITE_URL?>views/css/login.css" rel="stylesheet"/>
    </head>
    <body>
        <div id="header" align="left">
            <img src="<?=SITE_URL?>views/images/login/Incipio-Development-Support-Logo.png" alt="Incipio Design Support" id="incipio-logo"/>
        </div>
	
        <form autocomplete="off" name="frm_login" method="POST">
	    <div class="error">
		<?php
                if (isset($_SESSION['login_error'])) { echo $_SESSION['login_error'];unset($_SESSION['login_error']); } ?>
	    <?php if(isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']); } ?>
	    </div>
                <?php include_once 'views/messenger.php'; ?>
	    <div class="messenger" style="text-align: center;">
		<?php if(isset($_REQUEST['status']) == 1){ ?>
		<span class="success" style="color: green;"> Password Changed Successfully</span>
		<?php }else{} ?>
	    </div>
            <div id="form-holder">                
                <div align="center">
                <table>
                    <tbody>
			<tr>
                            <td><input type="text" required="" id="ccustomername" name="username"></td>
                        </tr>
                        <tr>
                            <td><input type="password" required="" id="cpassword" name="password"></td>
                        </tr>
			<tr>
                            <td> <a href="<?=SITE_URL?>forgotpassword" style="float: right;">Forgot Password</a> </td>
                        </tr>
                    </tbody>
                </table>
                </div><br>
                <div align="center"><input type="submit" onclick="return checkf()" value="Login" name="login"></div>
            </div>
        </form>

    </body></html>