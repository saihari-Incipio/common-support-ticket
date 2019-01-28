<html>
    <head>
        <link rel="icon" href="<?= SITE_URL ?>views/images/favicon.ico" type="image/x-icon"/>
        <title>ERP Service Tickets Portal Reset Password</title>
        <link href="<?= SITE_URL ?>views/css/newlogin.css" rel="stylesheet"/>
         <!--<link href="<?= SITE_URL ?>views/css/licensing.css" rel="stylesheet"/>-->

        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>
         <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.1.validate.js"></script>
        <!--<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>-->
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
                /*margin-left: 12px;*/
            }
        </style>
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
            .make-red {
                color: red !important;
                display: block;
                font-size: 12pt !important;
                text-align: left;
                width: 503px;
                margin-top: 10px;
                font-weight:normal;
            }
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
        <script language="javascript">
            $(document).ready(function () {

                var passworderror = "Password should be alphanumeric, have minimum 1 uppercase, 1 lowercase, 1 special character and 6 to 20 characters long. (Special characters are !@#$%^&*)";

                $.validator.addMethod("pwcheckspechars", function (value) {
                    return /[!@#$Â£%^&*()_=\[\]{};':"\\|,.<>\/?+-]/.test(value)
                }, passworderror);

                //            $.validator.addMethod("pwcheckconsecchars", function (value) {
                //            return ! (/(.)\1\1/.test(value)) // does not contain 3 consecutive identical chars
                //        }, "The password must not contain 3 consecutive identical characters");

                $.validator.addMethod("pwchecklowercase", function (value) {
                    return /[a-z]/.test(value) // has a lowercase letter
                }, passworderror);

                $.validator.addMethod("pwcheckuppercase", function (value) {
                    return /[A-Z]/.test(value) // has an uppercase letter
                }, passworderror);

                $.validator.addMethod("pwchecknumber", function (value) {
                    return /\d/.test(value) // has a digit
                }, passworderror);

                $('#forgor-password').validate({
                    errorClass: "make-red",
                    highlight: function (element, errorClass, validClass) {
                        $(element.form).find("label[for=" + element.id + "]").addClass("error");
                    },
                    rules: {
                        "newpassword": {
                            required: true,
                            pwchecklowercase: true,
                            pwcheckuppercase: true,
                            pwchecknumber: true,
                            //pwcheckconsecchars: true,
                            pwcheckspechars: true,
                            minlength: 6,
                            maxlength: 20
                        },
                        "confirmnewpassword": {
                            required: true,
                            equalTo: "#new_password"
                        },
                    },
                    messages: {
                        "newpassword": {required: "Please enter New Password"},
                        "confirmnewpassword": {required: "Please enter Confirm Password",
                            equalTo: "Please enter the same password as above"
                        },
                    },
                    ignore: []
                });
            });

        </script>

    </head>
    <body>
        <div class="fulldiv"style=" ">            
            <a href="<?= SITE_URL ?>backadmin">
                <img style="margin: auto; display: block;padding-top: 30px;" src="<?= SITE_URL ?>views/images/login/incipio_group_logo.png" />
            </a>
            <div class="hedertext">ERP SERVICE TICKET PORTAL </div>
            <div class="messenger" style="">
                <?php if (isset($_SESSION['message'])) { ?>
                    <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>
            </div>

            <div class="headerdiv"style="">
                <div class="titletext">RESET PASSWORD</div>
                <form autocomplete="off" name="frm_login" method="POST" id="forgor-password">

                    <div class="labeltext">New Password</div>
                    <div><input type="password" required="" class="password" id="new_password" name = 'newpassword' size=15 placeholder="Enter New Password"></div>    

                    <div class="labeltext">Confirm Password</div>
                    <div><input type = 'password' required="" name = 'confirmnewpassword' class="password" size=15 id="confirm_password" placeholder="Enter Confirm Password"></div>
                    <div style="margin: 11px 0px;">
                        <input type="checkbox" id="showHide" name = 'rememberme'  <?php if (isset($_COOKIE['rememberme']) && $_COOKIE['rememberme'] == "YES") { ?> checked="checked" <?php } ?> value="YES" class="inputche"/><label class="txtsize" for="showHide">Show Password</label>
                        <!--<a style="float: right; color: #fff;font-size: 14px;" href="<?= SITE_URL ?>forgotpassword">Forgot Password</a>-->
                    </div>



                    <div style="margin: 20px 0 5px 0;">
                        <input class="submit-button" type="submit" value="SUBMIT" name="login"  />
                    </div>
                </form>
            </div>
        </div>
        <div class="footer" >
            <p> &copy; <?=date('Y')?> Incipio, LLC</p>
        </div>

    </body></html>

<script type="text/javascript">
    $(document).ready(function () {
        $("#showHide").click(function () {
            if ($(".password").attr("type") == "password") {
                $(".password").attr("type", "text");
            } else {
                $(".password").attr("type", "password");
            }

        });
    });
</script>