<html>
    <head>
        <link rel="icon" href="<?= SITE_URL ?>views/images/favicon.ico" type="image/x-icon"/>
        <title>ERP Service Tickets Portal - Forgot Password</title>
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
            span.form-field {
                display: block;
                margin-top: 10px;
            }
            .make-red {
                color: red !important;
                display: block;
                font-size: 12pt !important;
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
        <div class="fulldiv">
            <a href="<?= SITE_URL ?>backadmin">
                <img style="margin: auto; display: block;padding-top: 30px;" src="<?= SITE_URL ?>views/images/login/incipio_group_logo.png" />
            </a>
            <div class="hedertext"> ERP SERVICE TICKET PORTAL </div>
            <div class="messenger" style="">
                <?php if (isset($_SESSION['message'])) { ?>
                    <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>
            </div>

            <div class="headerdiv">
                <div class="titletext">FORGOT PASSWORD</div>
                <form autocomplete="off"  name = "frm_login" id="forgor-password" action="" method="post" novalidate="novalidate">

                    <div class="labeltext" style="">Enter User Name</div>
                    <div><input type="text" required="" class="required txtfield" id="ccustomername" name="username" placeholder="Enter User Name"></div>              

                    <div class="buttondiv">
                        <div style="margin: 20px 0 5px 0;">
                            <input type="button" class="submit-buttons" style="cursor: pointer;" value="BACK" onclick="window.location.href = '<?= SITE_URL ?>backadmin'" />
                        </div>
                        <div style="margin: 20px 0 5px 0;">
                            <input class="submit-buttonss" type="submit" value="SUBMIT" />                       

                        </div>                      
                    </div>
                </form>
            </div>
        </div>
        <div class="footer" >
            <p> &copy; <?=date('Y')?> Incipio, LLC</p>
        </div>
    </body></html>
