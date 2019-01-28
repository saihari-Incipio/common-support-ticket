<html>
    <head>
        <link rel="icon" href="<?=SITE_URL?>views/images/favicon.ico" type="image/x-icon"/>
        <title>ERP Service Tickets Portal</title>
        <link href="<?=SITE_URL?>views/css/newlogin.css" rel="stylesheet"/>
        <style>
            .form {
                text-align: center;
                height: 89%;
            }
            .login_form {
                width: 39%;
                margin: auto;
                padding: 20px;
                background-color: #141414;
                border-radius: 8px;
                margin-top: 38px;
                font-family: Roboto Condensed;
            }
            .make-red {
                color: red;
                margin-left: 12px;
            }
            
        </style>
        <script language="javascript">

            function checkf()
            {


                var user, pass;
                with (window.document.frm_login)
                {
                    user = ccustomername;
                    pass = cpassword;
                }

                if (trim(user.value) == '')
                {
                    alert('Please enter your User Name');
                    user.focus();
                    return false;
                } else if (trim(pass.value) == '')
                {
                    alert('Please enter Password');
                    pass.focus();
                    return false;
                } else
                {
                    return true;
                }
            }

            function trim(str)
            {
                return str.replace(/^\s+|\s+$/g, '');
            }

        </script>
        
        <style>
            input::-webkit-input-placeholder {
                font-size: 16px;
                font-weight: normal;
                /*                line-height: 3;*/
            }

            ::-moz-placeholder {  /* Firefox 19+ */
                font-size: 16px!important;
                font-weight: normal!important;
            }
            :-ms-input-placeholder {
                font-size: 16px!important;
                font-weight: normal!important;
            }
            /* - Internet Explorer 10–11
            - Internet Explorer Mobile 10-11 */
            

        </style>
    </head>
    <body>
        <div class="fulldiv"style=" ">            
            <!--<a href="<?= SITE_URL ?>">-->
                <img style="margin: auto; display: block;padding-top: 30px;cursor: pointer;" src="<?= SITE_URL ?>views/images/login/incipio_group_logo.png" onClick="window.location.reload(true)"/>
            <!--</a>-->
            <div class="hedertext"> ERP SERVICE TICKETS PORTAL </div>
            <div class="messenger" style="">
                <?php if (isset($_SESSION['message'])) { ?>
                    <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>
            </div>
            <div class="messenger" style="">
                <?php if (isset($_REQUEST['type'])) { ?>
                <p class="pwdupdate">Password changed successfully.</p>
                    <?php
                   // unset($_REQUEST['type']);
                }
                ?>
            </div>
            

            <div class="headerdiv"style="">
                <!--<div class="titletext">ADMIN LOGIN</div>-->
                <form autocomplete="off" name="frm_login" method="POST" action="<?=SITE_URL?>front/login">

                    <div class="labeltext">User Name</div>
                    <div><input type="text" required="" id="ccustomername" name = 'username' <?php if (isset($_COOKIE['rememberme_username'])) { ?> value="<?= $_COOKIE['rememberme_username']; ?>"<?php } ?> size=15 placeholder="Enter User Name"></div>    

                    <div class="labeltext">Password</div>
                    <div><input type = 'password' name = 'password' <?php if (isset($_COOKIE['rememberme_password'])) { ?> value="<?= $_COOKIE['rememberme_password']; ?>"<?php } ?> size=15 id="cpassword" placeholder="Enter Password"></div>

                    <div style="margin: 11px 0px;">
                        <input type="checkbox" name = 'rememberme' id="rememberme" <?php if (isset($_COOKIE['rememberme']) && $_COOKIE['rememberme'] == "YES") { ?> checked="checked" <?php } ?> value="YES" class="inputche"/><label class="txtsize" for="rememberme"> Remember Me</label>
                        <a style="float: right; color: #fff;" href="<?=SITE_URL?>requesterforgotpassword">Forgot Password</a>
                    </div>

                    <div style="margin: 20px 0 5px 0;">
                        <input class="submit-button" type="submit" value="LOGIN" name="login" onClick="return checkf()" />
                    </div>
                </form>
            </div>
        </div>
        <div class="footer" >
            <p> &copy; <?=date('Y')?> Incipio, LLC</p>
        </div>
    </body></html>