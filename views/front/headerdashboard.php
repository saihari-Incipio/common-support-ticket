<style>
    body {
        font-family: Roboto Condensed;
        background: #fff;
        margin: 0 auto;
    }
    .container-sales{
        width: 100%;

    }
    .head-text-sales{
        color: #fff;
        margin-top: 2px;
        float: left;
        font-size: 22px;
        margin-left: 5px;
        text-transform:uppercase;
    }

    .doc-message {
        background: #ccc;
        text-align: center;
        margin: 30px auto;
        width: 90%;
        height: 485px;
    }
    .text-message{
        text-align: center;

    }

    .vertical-line-sales{
        border-left: 2px solid #fff;
        height: 40px;
        color: #fff;
        float: left;
        margin-top: 5px;

    }
    .vertical-line-second{
        border-left: 2px solid #fff;
        height: 40px;
        color: #fff;
        /*float: left;*/
        margin-top: 5px;
        margin-left:5px;

    }

    .head-customer-text{
        color: #fff;
        font-size: 18px;
        float: right;
        margin-right: 50px;
    }
    .head-text{
        font-size:25px;
    }
    .logo-sales{
        width: 150px;
        margin: 15px 0;
        margin-left: 15px;
        padding-right:10px;
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
        color:#000;
        background:#fff;

    }
    .litebox_input{
        background-image: url('<?php echo SITE_URL; ?>views/images/magnifying-search-lenses-tool.png');
        background-repeat: no-repeat;
        background-position:right;
        background-size: 25px;
    }
    #date_type{
        border-radius: 4px;
        background-color: #E3E2E2;
        /*width: 28%;*/       
        font-weight: bold;
        padding-right: 22px;
    }
    .dropdown {
        position: relative;
        display: inline-block;     
        /*padding-top: 20px;*/
        /*padding: 20px 10px 30px 30px;*/
        /*z-index: 999;*/


    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #E3E2E2;
        /*border-radius: 10px 1px 10px 10px;*/
        min-width: 200px;
        height: 73px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        right:4px;
    }

    .dropdown-content a {
        color: #000;
        padding: 0px 10px;
        font-size: 14px;
        text-decoration: none;
        display: block;
        text-align: left;
        cursor: pointer;
    }
    .dropdown-content p {
        color: #000;
        padding: 0px 10px;
        font-size: 14px;
        text-decoration: none;
        display: block;
        text-align: left;
        cursor: pointer;
    }

    .dropdown-content a:hover {
        /*background-color: #f1f1f1*/
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        /*background-color: #3e8e41;*/
    }
    .tablesorterer .ui-selectmenu-button {
        width: 100%!important;
        border-radius: 6px;
        background: #fff;
        color: #000;
        border: 1px solid #e3e2e2;
        /*font-weight: bold;*/
    }
    .ui-selectmenu-button span.ui-selectmenu-text{
        padding:7px;
    }
    .ui-widget {
        font: inherit;
        /*top: 13px !important;*/
    }
    .ui-selectmenu-menu{
           z-index: 1 !important;
           font-family: roboto-medium !important;
           /*position: fixed;*/
     }
     ::-webkit-input-placeholder {
        font-style: italic;
    }
    :-moz-placeholder {
        font-style: italic;  
    }
    ::-moz-placeholder {
        font-style: italic;  
    }
    :-ms-input-placeholder {  
        font-style: italic; 
    }
    .tablesorterer .ui-selectmenu-button span.ui-selectmenu-text {
    padding: 5px 7px;
    /* text-align: center; */
} 
.tablesorterer .ui-selectmenu-text {
    font-family: roboto-medium !important;
    font-size: 14px !important;
    letter-spacing: 1px !important;
}
 .sort_fields_div .ui-dropdownchecklist-text{
        letter-spacing: 1px !important;      
        font-size: 14px !important;     
    }
    .sort_fields_div .ui-dropdownchecklist-selector{
        font-family: roboto-medium !important;
        color: #000 !important;
        width :184px !important;
        background-color: #e3e2e2 !important;
        border:1px solid #e3e2e2 !important;
    }
     .list-view-filter .ui-dropdownchecklist-item label {       
        display: block;
        margin-top: -22px;
        margin-left: 20px;
    }
    .messenger{
        text-align:center;
    }
.success {
    color: green;
}
.fail{
    color: red;
}
</style>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <script type="text/javascript">
            var SITE_URL = "<?= SITE_URL ?>";
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>

        <link type="image/x-icon" href="<?= SITE_URL ?>views/images/favicon.ico" rel="icon"/>
        <title>ERP Service Ticket - Requester Dashboard</title>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/table_sorter/blue/style.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/lightbox.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/timepicker/jquery-ui-timepicker-addon.css"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/datepickr/datepickr.css"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/tavikportal.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/licensing.css" />
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/ticketview.css" />
        <!--<link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/uploadfile.css" />-->

        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>  
        <!--<script type="text/javascript" src="<?= SITE_URL ?>views/js/lightbox.min.js"></script>-->
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.1.validate.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/timepicker/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/tavikportal.js"></script>
        <!--<script type="text/javascript" src="<?= SITE_URL ?>views/js/utility.js"></script>-->
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/datepickr/datepickr.js"></script>

        <!--Daterange files--> 
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/daterange/moment.min.js"></script>
        <!--<link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/daterange/bootstrap.css" />-->
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/daterange/daterangepicker.js"></script>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/daterange/daterangepicker.css" />
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/loadingoverlay.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/front.js"></script>
        <script type="text/javascript" src="<?=SITE_URL?>views/js/jquery.uploadfile.min.js"></script> 
        <script type="text/javascript">
            var SITE_URL = "<?= SITE_URL ?>";
             $(document).ready(function () {
        $(".messenger").delay(3000).fadeOut(400);
    });
        </script>
    </head>
    <div style="background: #F6F7FB;width: 100%; position: fixed;top: 0;z-index: 99;">
                
        <table style="width: 100%; height: 60px;background: #000;" >
            <tr>
                <td style="width: 150px; vertical-align: middle;">
                    <a href=""><img src="<?php echo SITE_URL; ?>views/images/IncipioLogo-209x53.png" class="logo-sales"></a></td>
                <td style="width: 2px;text-align: center; vertical-align: middle;"><div class="vertical-line-sales"></div></td>
                <td style="vertical-align: middle;"><span class="head-text-sales"> ERP Service Ticket Portal</span></td>


                <td style="vertical-align: middle;">

                    <div class="head-customer-text"> 
<!--                        <span><a href="#" onclick="supportPopup();" style="text-decoration: none; color: #fff;margin-left: 5px;">Support</a>
                        <img  onclick="supportPopup();" style="margin-bottom: -4px;" id="sort-view" src="<?php echo SITE_URL; ?>views/images/support_new.png" />
                        </span>-->
                    
                        <!--<span class="vertical-line-second" style="padding-right:5px;"></span>-->
                        <div class="dropdown">
                            <a href="" style="text-decoration: none; color: #fff;cursor: default;"><?= (strlen($_SESSION['requester_display_name']) > 25) ? substr($_SESSION['requester_display_name'],0,25).'...' :$_SESSION['requester_display_name'] ?>   </a>
                        </div>

                        <span class="vertical-line-second"></span>
                        <span><a href="<?php echo SITE_URL; ?>front/frontlogout/" style="text-decoration: none; color: #fff;margin-left: 5px;">Logout</a></span>
                    </div></td>

            </tr>
        </table>

  
    <!--<div style="width: 100%;background:#F6F7FB; color:#000;text-align: center;letter-spacing: 2px;position:fixed;z-index: 1;height: 25px;"><span>Logged in as <?php echo ucfirst($_SESSION['admin_type']); ?></span></div>-->
  
                
        </div> 
      <div class="portal-bkadmin-content" > <!-- content div -->  
                      <div class="messenger">
            <?php if(isset($_SESSION['message'])) { ?>
                 <span class="<?php echo $_SESSION['message']['status']; ?>"><?php echo $_SESSION['message']['text']; ?></span>
            <?php unset($_SESSION['message']); } ?>
         </div>