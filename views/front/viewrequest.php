<?php
include_once 'views/front/headerdashboard.php';
//App::pre($logResult);
?>

<div class="ticket-main-container">
    <div class="header-actions">
        <a href="<?= SITE_URL ?>front/dashboard">
            <span style="float:left;">
                <img class="header-icons" src="<?= SITE_URL ?>views/images/icons/back.png" /> Back to Dashboard</span>
        </a>
        <?php if($ticketsData['fields']['status']['statusCategory']['name'] == 'To Do'){ ?>
        <a href="<?= SITE_URL ?>front/editrequest?key=<?= base64_encode($ticketsData['key']) ?>">
            <span style="float:right;    margin-right: 85px;">
                Edit  <img class="header-icons" src="<?= SITE_URL ?>views/images/icons/edit.png" /> </span>
        </a>
        <?php } ?>
    </div>
    <div class="ticket-info-container">
        <div class="ticket_data_div" >
            <div class="sub-heading">Ticket ID: <?= $ticketsData['key'] ?></div>
            <div style="text-align: left;font-size: 18px; font-weight: bold;">
                <?= $ticketsData['fields']['summary'] ?>
            </div>
            <div class="info-details">
                <table class="ticket_info_table">
                    <tr class="table_rows_two">
                        <td>Status </td>
                        <td>logs </td>
                        <td>created Time </td>
                        <td>Last Updated Time </td>
                    </tr>
                    <tr >
                        <td><span class="<?= strtolower(str_replace(" ", "", $ticketsData['fields']['status']['statusCategory']['name'])); ?>" ><?= $ticketsData['fields']['status']['statusCategory']['name'] ?></span> </td>
                        <td><a href="#" onclick="viewlog()">View logs</a> </td>
                        <td><?= Utility::getFormatedDate($ticketsData['fields']['created']) ?> </td>
                        <td><?= Utility::getFormatedDate($ticketsData['fields']['updated']) ?> </td>
                    </tr>
                    <tr class="table_rows_two spaceUnder" >
                        <td>Platform </td>
                        <td>Track/Module </td>
                        <td>Sub Track/Sub Module </td>
                        <td>Instance </td>
                        <td>Phase </td>
                    </tr>
                    <tr>
                        <td><?= trim($ticketsData['fields']['customfield_11304']['value']) ?> </td>
                        <td><a><?= trim($ticketsData['fields']['customfield_11305']['value']) ?></a> </td>
                        <td><?= trim($ticketsData['fields']['customfield_11306']['value']) ?> </td>
                        <td><?= trim($ticketsData['fields']['customfield_11307']['value']) ?></td>
                        <td><?= trim($ticketsData['fields']['customfield_11308']['value']) ?></td>
                    </tr>
                    <tr class="spaceUnder table_rows_two" >
                        <td>Service Type </td>
                        <td>Requester Email </td>
                        <td>Requester Name </td>
                    </tr>
                    <tr>
                        <td><?= trim($ticketsData['fields']['customfield_11309']['value']) ?> </td>
                        <td><?= trim($ticketsData['fields']['customfield_11310']) ?> </td>
                        <td><?= trim($ticketsData['fields']['customfield_11312']) ?></td>
                    </tr>
                </table>
            </div>
            <div class="description_div">
                <div class="sub-heading">DESCRIPTION</div>
                <?= htmlspecialchars_decode(nl2br($ticketsData['fields']['description'])); ?>
            </div>

            <div class="attachment_div">
                <div class="sub-heading" >ATTACHMENTS</div>
                
               
                <?php
                if (!empty($ticketsData['fields']['attachment'])) {


                    foreach ($ticketsData['fields']['attachment'] as $attachment) {

                        print_r(UtilityHtml::getAttachmentPreviewHtml($attachment['content'], $attachment['size'],  $attachment['id'], $ticketsData['key'], 'VIEW'));
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
                        <td class="active_tabitem">
                            <div id="files_show_button" class="tabitem" >Logs</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="comments" id="comments_div">
                <div id="add_comment_div">
                    <form id="comment_submit_form" method="POST" action="<?= SITE_URL ?>front/addcomment" >
                        <input type="hidden" id="key" name="key" value="<?= $ticketsData['key'] ?>" />
                        <textarea id="comment_text" name="comment_text" style="width: 100%; height: 120px;" required="required"></textarea>
                        <div style="padding-top: 15px;">
                            <button type="submit" class="buttton_black" id="comment_submit" >Add Comment</button>
                            <!--                                <a id="add_comment_file_div" >
                                                                <input type="file" id="comment_file" name="comment_file" style="display: none;" />
                                                                <img style="padding-left: 5px; margin-bottom: -8px; width:20px;"  src="<?= SITE_URL ?>views/images/icons/add_files.png" /><span style="margin-bottom: -4px; padding-left: 5px;  text-decoration: none;">Add Files</span>
                                                            </a>-->
                        </div>
                    </form>
                </div>
                <div class="sub-heading">ALL COMMENTS </div>
                <div class="comments_div" >
                    <?php
                    $comments = $ticketsData['fields']['comment']['comments'];
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            ?>

                           
                                <div style="padding: 15px 0px 5px;"><span style="color: #0089FF;  float:left;"><?= $comment['author']['displayName'] ?></span>
                                    <span class="comment_date_section">   <?= Utility::getFormatedDate($comment['updated']) ?> </span>
        <!--                                    <span style="float:right;">
                                        <img  class="comment-icons" id="edit_comment" src="<?= SITE_URL ?>views/images/icons/edit_comment.png" />
                                        <img  class="comment-icons" id="delete_comment"src="<?= SITE_URL ?>views/images/icons/delete_comment.png" />
                                    </span>-->
                                </div>
                                <div class="comment_body" ><?= htmlspecialchars_decode(nl2br($comment['body'])); ?></div>
                                <p style="border-bottom:3px solid #fff;"></p>
                           
                            <?php
                        }
                    }else{ ?>
                        <div class="comment_body" >No Comments found </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            
            
            <div class="logs" id="log_view" >                
                <div class="ticket-log-container">
                      <?php foreach($logResult as $logs){
                       if($logs['items'][0]['field'] != 'Request language'){   
                          ?>
                     
                    <div style="margin-top:10px;"><span style="float:left;font-weight:bold;color:#000;"><?= $logs['author']['displayName'] ?></span> <span style="float:right; color: #919191;
    font-size: 14px;
    line-height: 2"><?= Utility::getFormatedDate($logs['created']) ?> </span></div><br/>
           <div class="log">             
    <?php 
                            foreach ($logs['items'] as $log ){
                               $logMessage = 'No Logs Found';
                                if($log['field'] == 'Attachment'){
                                    if($log['toString'] != ''){
                                    $logMessage = $log['field'].':  Uploaded '. $log['toString'];
                                    }else{
                                        $logMessage = $log['field'].':  Deleted '. $log['fromString'];
                                    }
                                }else if($log['field'] != 'Request language'){
                                    $logMessage = $log['field'].': Updated from '. $log['fromString'] .' to '.$log['toString'];
                                }
    ?>
               <div><?php echo $logMessage; ?> </div>
                   
                            <?php }  ?>
                            </div>
                          <?php  }
                      }?>
                
            </div>
        </div>
    </div>
</div>
