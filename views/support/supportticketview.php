<?php

// echo "<pre>"; print_r($ticketsData); exit;
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <title>Sample Request Form-Dashboard</title>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/table_sorter/blue/style.css" />
        <link type="image/x-icon" href="<?=SITE_URL?>views/images/favicon.ico" rel="icon"/>
        <link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.css" />
        <script type="text/javascript">
            var SITE_URL = "<?= SITE_URL ?>";
        </script>
        
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.0.min.js"></script>  
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/jquery-1.11.1.validate.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/css/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/loadingoverlay.min.js"></script>
     
        <!--support Js file-->
        <script type="text/javascript" src="<?= SITE_URL ?>views/js/support.js"></script> 
        
        <script type="text/javascript">
            $(document).ready(function() {
                // hide error and success message after 5 seconds
                setTimeout(function(){ 
                    $(".fail, .success").html("");
                }, 5000);
                 $.LoadingOverlay("show");
          
            $('#comment_submit_form').validate({
        errorClass: "error",
        focusInvalid: true,
        errorPlacement: function (error, element) {
//            console.log(element);
            error.insertAfter(element);
            switch (element.attr("name")) {
                case 'comment_text':
                    error.insertAfter("#comment_text_error");
                    break;
                default:
                    error.insertAfter(element);
                    break;
        }
    },
    onfocusout: false,
    invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {                    
            validator.errorList[0].element.focus();
        }
    },
        rules: {
            "comment_text": {required: true, maxlength:254}
        },
        messages: {
            "comment_text": {required: "Please enter Comment"}
        },
        ignore: []
    });  
    
            $("#comment_submit").click(function () {
//            alert(123456);
            if($('#comment_submit_form').valid()){
                $("#comment_submit").attr("disabled", "disabled");
//                alert("true");
                $("#comment_submit_form").submit();
            }else{
//                alert("eerer");

                return false;
            }
        });
            });
        </script>
        
        <style>
    .support-body {
        position: relative !important;
    }
    .support-head {
        position: fixed !important;
        top: 0 !important;;
    }
    .ticket-main-container {
        margin:0px 50px;
    }
</style>
<link type="text/css" rel="stylesheet" href="<?= SITE_URL ?>views/css/support_popup.css" />
    </head>
    <body>

<style>
    body {
        font-family: Roboto Condensed;
        background: #fff;
        margin: 0 auto;
    }
     
    .ui-dialog .ui-dialog-title {
        width: 100%;
        text-align: center;
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
        padding: 3px;
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
        min-width: 80px;
        height: auto;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        /*right:4px;*/
    }

    .dropdown-content a {
        color: #000;
        padding: 0px 10px;
        font-size: 14px;
        text-decoration: none;
        display: block;
        text-align: left;
        cursor: pointer;
        /*font-family: Roboto Bold Condensed;*/
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
        font-weight: bold;
    }
    .ui-selectmenu-button span.ui-selectmenu-text{
        /*padding:7px;*/
        /*text-align: center;*/
    }
    @media only screen and (max-width: 1920px) {
        .searchdate { 
            font-size:15px;
            line-height: 27px;
        }

    }

    /*    .ui-selectmenu-menu #globle_search_select-menu{
            z-index: 99 !important;
            
        }*/
    .ui-selectmenu-menu{
        z-index: 1 !important;
        /*position: fixed;*/
    }
    .search-position{
        z-index: 99 !important;
        position: fixed;
    }
    #globle_search_select-menu{
        height:auto !important;
        /*padding-top: 3px !important;*/
        /*position: fixed;*/

    }

    #frm_global_search  .ui-selectmenu-menu{
        z-index: 1 !important;
    }

    /*    #globle_search_select-button .ui-selectmenu-text{
            
            padding: 0.4em 2.1em 0.4em 0.2em !important;
        }*/
    .createnewrequest{ 
        /*display:block; */
        text-decoration: none;
        cursor:pointer;
        float:right;
        margin-top:-2%; 
        /*padding:0px;*/
        font-size: 20px;
        color: black;
        font-weight: bold;
        margin-right:1%; 
    }
    
    .divsearch
    {
        max-height: 70px;
        letter-spacing: 1px; 
        background-color: #E5E5E5; 
        padding-top: 4px;
        /*padding:0.5% 15% 0.5% 15%;*/ 
        padding-bottom: 10px;
    }
/* dropdown */
.dropbtn {   
    color: #000;    
    font-size: 16px;
    border: none;
}

.dropdown-menu {
    /*position: relative;*/
    display: inline-block;
    float:right;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    /*min-width: 160px;*/
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    /*margin-top: 10px;*/
}

.dropdown-content a {
    color: black;
    padding: 10px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown-menu:hover .dropdown-content {display: block;}
.menu-border {
    border-right: 2px solid #000;  
   padding-left:20px;
font-weight:bold;
}
</style>
<script>
    $(document).ready(function () {

        $("#globle_search_select-menu").parent().addClass('search-position');
//     alert('jaihanuman');
        // $.LoadingOverlay("show");

        // Hide it after 3 seconds
//    setTimeout(function () {
//            $.LoadingOverlay("hide");
//    }, 1000);

    });
    $(window).load(function () {
        $.LoadingOverlay("hide");
    });

</script>
<div style="background: #000;width: 100%; position: fixed;top: 0;max-height:20%;">
    <table style="width: 100%; height: 60px;" >
        <tr>
            <td style="width: 150px; vertical-align: middle;">
                <a href=""><img src="<?php echo SITE_URL; ?>views/images/IncipioLogo-209x53.png" class="logo-sales"></a></td>
            <td style="width: 2px;text-align: center; vertical-align: middle;"><div class="vertical-line-sales"></div></td>
            <td style="vertical-align: middle;"><span class="head-text-sales"><?= $projJiraData['project_name'] ?></span></td>

<?php 
if ($_SESSION['common_requester_display_name'] != '') { ?>
                <td style="vertical-align: middle;">

                    <div class="head-customer-text"> 
                         
                        <span onclick="supportIframe('Requester-Dashboard');"><a href="#"  style="text-decoration: none; color: #fff;margin-left: 5px;">Support</a>
                        <img   style="cursor: pointer;margin-bottom: 0px;" id="sort-view" src="<?php echo SITE_URL; ?>views/images/support_new.png" /> 
                        </span>
                    <span class="vertical-line-second"></span>
                    <div class="dropdown" style="margin-left: 5px;">
                            <a href="#" style="text-decoration: none; color: #fff;"><?= $_SESSION['common_requester_display_name'] ?> 
                               
                        </div>


                        <span class="vertical-line-second"></span>
                        <span><a href="<?php echo SITE_URL; ?>front/login/logout" style="text-decoration: none; color: #fff;margin-left: 5px;">Logout</a></span>
                    </div></td>
<?php } ?>
        </tr>
    </table>
    <div style="width: 100%;background:#E5E5E5; color:#000;text-align: center;letter-spacing: 2px;position:fixed;padding: 1px;"><span>Logged in as Requester</span>
    </div>

    <table  style="margin-top: 22px; background-color: #fff; width: 100%; padding-bottom: 3px;">
        <tr>
            <td width="25%">
                
                   <a href="<?= $projectPath ?>front/dashboard">         
                <table><tr>
                        <td><img class="header-icons" src="<?= SITE_URL ?>views/images/back.png" /></td>
                        <td style="padding-top: 0px; padding-left: 5px;">Back to Dashboard</td>
                    </tr></table>

            </a>
            </td>
            <td width="50%" style="text-align: center;"> <?php include_once DOC_ROOT_PATH . '/views/messenger.php'; ?>
            </td>
            
<!--            <td width="15%" >
                    <div class="dropdown-menu">
                        <p class="dropbtn" style="text-decoration: underline; font-weight: bold; margin: 0; font-size: 18px;" >Instructions<span class="menu-border"></span></p>
                      <div class="dropdown-content">
                        <a onclick="readPdfInstructions();" href="#">PDF </a>
                        <a  onclick="instructionsVideo();" href="#">Video</a>
                      </div>
                    </div>

                   </td>-->
            <td style="width: 140px;">      
<!--                <div style="width: 100%; margin-top: 3%; background-color: #fff;">
                            <a href="<?php echo SITE_URL; ?>" class="createnewrequest"  title="Add New">Create New  <img src="<?= SITE_URL ?>views/images/plus.png" style="max-width: 30px; vertical-align: text-top;"/></a>

                </div>-->
            </td>

        </tr>
    </table>
      </div>
        
        <div style="margin:70px 80px 0px;">
                     
              <div class="ticket-info-container">
            <div class="ticket_data_div" >
                <div class="sub-heading">Ticket ID:  <?= $ticketsData['key'] ?> </div>
                <div style="text-align: left;font-size: 18px; font-weight: bold;">
                <?= $ticketsData['fields']['summary'] ?>
                </div>
                <div class="info-details">
                    <table class="ticket_info_table">
                        <tr class="table_rows_two">
                            <td width="15%">Status </td>
                            <!--<td>logs </td>-->
                            <td width="25%">Created Time </td>
                            <td width="25%">Last Updated Time </td>
                            <td width="35%">Severity</td>
                            <td width="35%">Resolution</td>
                        </tr>
                        
                        <tr>
                            <!--<td width="15%"><span class="done">Closed</span> </td>-->
                             <td width="20%"><span class="<?= strtolower(str_replace(" ", "", $ticketsData['fields']['status']['statusCategory']['name'])); ?>" ><?= $ticketsData['fields']['status']['name'] ?></span> </td>
                           <!--<td><a href="#" onclick="viewlog()">View logs</a> </td>-->
                            <td width="25%"> <?= Utility::getConvertTimeToPst($ticketsData['fields']['created'])->format('m/d/Y h:i:s A') ?></td>
                            <td width="25%"><?=  Utility::getConvertTimeToPst($ticketsData['fields']['updated'])->format('m/d/Y h:i:s A') ?></td>
                            <td width="35%"><?= trim($ticketsData['fields']['priority']['name']) ?>  </td>
                            <?php 
                            if(!empty($ticketsData['fields']['resolution']['name'])){
                            ?>
                            <td width="35%"><?= trim($ticketsData['fields']['resolution']['name']) ?> </td>
                            <?php }else{
                                echo ' <td width="35%">NA</td>';
                            } ?>
                        </tr>
                        
                        <tr class="spaceUnder table_rows_two" >
                            <td width="15%">Service Type </td>
                            <td width="25%">Requester Name </td>
                            <td width="25%">Requester Email </td>                       
                            <td width="35%">Additional CC's</td>

                        </tr>
                             <?php
                        if ($ticketsData['fields']['customfield_11021'] != '') {
                            $AdditionalCCs = $ticketsData['fields']['customfield_11021'];
                        } else {
                            $AdditionalCCs = 'NA';
                        }
                        ?>
                        <tr>  
                            <td width="15%"><div style="word-wrap: break-word;width:150px;"><?= trim($ticketsData['fields']['issuetype']['name']) ?> </div></td>
                            <td width="25%"><div style="word-wrap: break-word;width:250px;"><?= isset($ticketsData['fields']['customfield_11020']) ? trim($ticketsData['fields']['customfield_11020']) : ''; ?></div></td>
                            <td width="25%"><div style="word-wrap: break-word;width:250px;"><?= trim($ticketsData['fields']['customfield_11018']) ?></div></td>
                            <td width="35"><div style="word-wrap: break-word;width:350px;"><?= trim($AdditionalCCs) ?></div></td>                        
                         
                          </tr>  
                       
                    </table>
                </div>
                <div class="description_div">
                    <div class="sub-heading">DESCRIPTION</div>
                    <div><?= htmlspecialchars_decode(nl2br($ticketsData['fields']['description'])); ?></div>
                </div>

                <div class="attachment_div">
                    <div class="sub-heading" >ATTACHMENTS</div>
 <?php
                    if (!empty($ticketsData['fields']['attachment'])) {


                        foreach ($ticketsData['fields']['attachment'] as $attachment) {

                            print_r(Utility::getTicketAttachmentPreview($attachment['content'], $attachment['size'], $attachment['id'], $ticketsData['key'], 'VIEW', $_REQUEST['proj_jira_code']));
                        }
                    } else {
                        echo "<div style='padding:20px;'>No Attachments  </div>";
                    }
                    ?>
   </div>            
            </div>    
            <div class="comment_section" id="comment_log_section">
                <div style="border-bottom: 2px solid #E3E2E2;">
                    <table class="tabmenu" style="vertical-align: baseline !important;">
                        <tr>
                            <td class="active_tabitem">
                                <div id="logs_show_button" class="tabitem_select" >Comments</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="comments" id="comments_div">

                    <div class="sub-heading">ALL COMMENTS </div>
                    <div class="comments_div" >
                      <?php
                        $comments = $ticketsData['fields']['comment']['comments'];
                        if (!empty($comments)) {
                            foreach ($comments as $comment) {
                                ?>


                                <div style="padding: 15px 0px 5px;"><span style="color: #0089FF;  float:left;"><?= $comment['author']['displayName'] ?></span>
                                    <span class="comment_date_section">   <?= Utility::getConvertTimeToPst($comment['updated'])->format('m/d/Y h:i:s A') ?> </span>
        <!--                                    <span style="float:right;">
                                        <img  class="comment-icons" id="edit_comment" src="<?= SITE_URL ?>views/images/icons/edit_comment.png" />
                                        <img  class="comment-icons" id="delete_comment"src="<?= SITE_URL ?>views/images/icons/delete_comment.png" />
                                    </span>-->
                                </div>
                                <div class="comment_body" ><?= htmlspecialchars_decode(nl2br($comment['body'])); ?></div>
                                <p style="border-bottom:3px solid #fff;"></p>

                                <?php
//                            $dateeee = Utility::getPSTCurrentTime($comment['updated'])->format('m/d/Y h:i:s A');
                            }
                        } else {
                            ?>
                            <div class="comment_body" >No Comments found </div>
                            <?php
                        }
                        ?>
                        <div id="add_comment_div">
                            <form id="comment_submit_form" method="POST" action="<?= SITE_URL ?>support/addcomment?proj_jira_code=<?= $_REQUEST['proj_jira_code'] ?>" novalidate="novalidate"  >
                                <input type="hidden" id="key" name="key" value="<?= $ticketsData['key'] ?>" />
                                <input type="hidden" id="type" name="type" value="front" />
                                 <span class="error" id="comment_text_error"></span>
                                <textarea id="comment_text" name="comment_text" style="width: 100%; height: 120px;" required="required"></textarea>
                                <div style="padding-top: 15px;">
                                    <input type="button" class="buttton_black" id="comment_submit" value="Add Comment" />
                                    <!--                                <a id="add_comment_file_div" >
                                                                        <input type="file" id="comment_file" name="comment_file" style="display: none;" />
                                                                        <img style="padding-left: 5px; margin-bottom: -8px; width:20px;"  src="<?= SITE_URL ?>views/images/icons/add_files.png" /><span style="margin-bottom: -4px; padding-left: 5px;  text-decoration: none;">Add Files</span>
                                                                    </a>-->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
            
        </div>
     <div  id="support_popup_dialog" name="support" class="support-user-dialog" title="CREATE SUPPORT TICKET" style="display: none;">
   <div id="support_container"></div>
   <iframe id="support_iframe"  src="<?=SITE_URL.'support/support?dashboard_type=Requester-Dashboard&proj_jira_code='.$_REQUEST['proj_jira_code'] ?>" width="100%" style="font-family: Roboto Condensed !important;height:98%; margin: auto;border:0;" ></iframe>
</div>   
        
   </body>
</html>