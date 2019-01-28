<?php
include_once 'views/front/headerdashboard.php';
//App::pre($ticketsData);
?>

<div class="ticket-main-container">
    <div class="header-actions">
        <a href="<?= SITE_URL ?>front/dashboard">
            <span style="float:left;">
                <img class="header-icons" src="<?= SITE_URL ?>views/images/icons/back.png" /> Back to Dashboard</span>
        </a>
<!--        <span style="float:right;">
            Edit  <img class="header-icons" src="<?= SITE_URL ?>views/images/icons/edit.png" />
        </span>-->
    </div>
    <div class="ticket-info-container">
        <!--<form id="support-project-quotation" method="POST" name="edit_request_form" action="<?= SITE_URL ?>front/submiteditrequest" >--> 
       
                <form id="edit_request_form" name="edit_request_form" enctype="multipart/form-data"  > 

        <input type="hidden" id="key" name="key" value="<?= $ticketsData['key'] ?>" />
            
        <div class="ticket_data_div" >
            <div class="sub-heading">Ticket ID: <?= $ticketsData['key'] ?></div>
          
            <textarea class="tarea" id="title" name="title" ><?= trim($ticketsData['fields']['summary']) ?></textarea>
          
            <div class="info-details">
                <table class="ticket_info_table">
<!--                    <tr class="table_rows_two">
                        <td>Status </td>
                        <td>logs </td>
                        <td>created Time </td>
                        <td>Last Updated Time </td>
                    </tr>
                    <tr >
                        <td><span><?= $ticketsData['fields']['status']['statusCategory']['name'] ?></span> </td>
                        <td><a href="#">View logs</a> </td>
                        <td><?= Utility::getFormatedDate($ticketsData['fields']['created']) ?> </td>
                        <td><?= Utility::getFormatedDate($ticketsData['fields']['updated']) ?> </td>
                    </tr>-->
                    
                    <tr>
                        <td>
                    <p class="lable-name">Platform</p>
                        <select id="platform" class="request edit_dropdown" name="platform" required>
                                    <option value="" disabled="" selected="">Please select a Platform</option>
                                    <option <?php if($ticketsData['fields']['customfield_11304']['value'] == 'Concur' ){ echo " selected=selected ";}?> value="Concur">Concur</option>
                                    <option <?php if($ticketsData['fields']['customfield_11304']['value'] == 'Oracle' ){ echo " selected=selected ";}?> value="Oracle">Oracle</option>
                                    
                                </select>
                        </td>
                        <td>
                           <p class="lable-name">Track/Module</p>
                        <select id="track_type" class="request edit_dropdown" name="track_type" required>
                                    <option value="" disabled="" selected="">Please select a Track</option>
                                    <?php 
                                    foreach($trackList as $track){ ?>
                                     <option value="<?=$track['id'];?>" <?php if($ticketsData['fields']['customfield_11305']['value'] == $track['track_name'] ){ echo " selected=selected ";}?>  ><?=$track['track_name'];?></option>    
                                <?php } ?>
                                </select>
                                <span class="error" id="track_type_error"></span>
                        </td>
                        <td>
                            <p class="lable-name">Sub Track/Sub Module</p>
                            <select id="sub_track_type" class="request edit_dropdown" name="sub_track_type" required>
                                    <option value="" disabled="" selected="">Please select a Sub Track</option>
                                    <?php 
                                    foreach($subtrackList as $track){ ?>
                                     <option value="<?=$track['id'];?>" <?php if($ticketsData['fields']['customfield_11306']['value'] == $track['sub_track_name'] ){ echo " selected=selected ";}?>  ><?=$track['sub_track_name'];?></option>    
                                <?php } ?>
                                </select>
                                <span class="error" id="sub_track_type_error"></span>
                        </td>
                    </tr>
                    <tr class="spaceUnder table_rows_two" >
                        
                    </tr>
                    <tr>
                        <td>   
                              <p class="lable-name">Instance</p>
                            <select id="instance" class="request edit_dropdown" name="instance" required>
                                    <option value="" disabled="" selected="">Please select a Instance</option>
                                    <option  <?php if($ticketsData['fields']['customfield_11307']['value'] == 'Development' ){ echo " selected=selected ";}?> value="Development">Development</option>
                                    <option <?php if($ticketsData['fields']['customfield_11307']['value'] == 'Production' ){ echo " selected=selected ";}?> value="Production">Production</option>
                                    <option <?php if($ticketsData['fields']['customfield_11307']['value'] == 'Test' ){ echo " selected=selected ";}?> value="Test">Test</option>
                                    
                                </select>
                        </td>
                        <td>
                             <p class="lable-name">Phase</p>
                        <select id="phase" class="request edit_dropdown" name="phase" required>
                                    <option value="" disabled="" selected="">Please select a Phase</option>
                                    <option  <?php if($ticketsData['fields']['customfield_11308']['value'] == 'CRP1' ){ echo " selected=selected ";}?> value="CRP1">CRP1</option>
                                    <option  <?php if($ticketsData['fields']['customfield_11308']['value'] == 'CRP2' ){ echo " selected=selected ";}?> value="CRP2">CRP2</option>
                                    <option <?php if($ticketsData['fields']['customfield_11308']['value'] == 'SIT' ){ echo " selected=selected ";}?> value="SIT">SIT</option>
                                    <option <?php if($ticketsData['fields']['customfield_11308']['value'] == 'Support' ){ echo " selected=selected ";}?>  value="Support">Support</option>
                                    <option <?php if($ticketsData['fields']['customfield_11308']['value'] == 'UAT' ){ echo " selected=selected ";}?>  value="UAT">UAT</option>
                                    
                        </select>
                        </td>
                         <td>
                             <p class="lable-name">Service Type</p>  
                        <select id="service_type" class="request edit_dropdown" name="service_type" required>
                                    <option value="" disabled="" selected="">Please select a Service Type</option>
                                    <option <?php if($ticketsData['fields']['customfield_11309']['value'] == 'Decision' ){ echo " selected=selected ";}?> value="Decision">Decision</option>
                                    <option <?php if($ticketsData['fields']['customfield_11309']['value'] == 'Issue' ){ echo " selected=selected ";}?> value="Issue">Issue</option>
                                    <option <?php if($ticketsData['fields']['customfield_11309']['value'] == 'Risk' ){ echo " selected=selected ";}?> value="Risk">Risk</option>
                                    <option <?php if($ticketsData['fields']['customfield_11309']['value'] == 'Requirement' ){ echo " selected=selected ";}?> value="Requirement">Requirement</option>
                                </select></td>
                    </tr>
<tr class="spaceUnder table_rows_two" >
                        
                    </tr>
                    <tr>
                       
                        <td> <p class="lable-name">Requester Email</p>  
                                    <?= trim($ticketsData['fields']['customfield_11310']) ?> </td>
                        <td>
                                 <p class="lable-name">Requester Name</p>      
                                    <?= trim($ticketsData['fields']['customfield_11312']) ?></td>
                        <td>
                                 <p class="lable-name">Requester Department</p>      
                                    <?= trim($ticketsData['fields']['customfield_11311']) ?></td>
                    </tr>
                </table>
            </div>
            <div class="description_div">
                <div class="sub-heading">DESCRIPTION</div>
                <textarea id="description" name="description" class="request required txtfield tarea"><?= htmlspecialchars_decode(nl2br(trim($ticketsData['fields']['description']))); ?></textarea>
            </div>

            <div class="sub-heading" >ATTACHMENTS</div>
            <div class="attachment_div"   >
            <div class="ajax-upload-dragdrop" id="drop-zone" style="border:2px dashed #cdcdcd;">
                
                <div align="center" class="ajax-file-upload">
                    <p class="drag">Drag & Drop your files here or</p>
                    <p><img src="<?= SITE_URL ?>views/images/upload_button.png" /></p>
                </div>
            <input type="file" name="myfile" id="myfile" accept=".txt,.doc,.docx,.pdf,.zip,.csv,.xlsx,.xls,.png,.jpg,.jpeg,.eps">

            </div>
               
<div id="ajax-file-upload-statusbar" class="ajax-file-upload-statusbar" style="display: none;">
        <span class="ajax-file-upload-filename"></span>
                <span  class="ajax-file-upload-red" style="float: right;">Delete</span>
    </div> 

    <label for="myfile" class="error" generated="true"></label>
        <?php
                if (!empty($ticketsData['fields']['attachment'])) {

                   foreach ($ticketsData['fields']['attachment'] as $attachment) {
                         print_r(UtilityHtml::getAttachmentPreviewHtml($attachment['content'], $attachment['size'], $attachment['id'], $ticketsData['key'], 'EDIT' ));
                    }
                } else {
//                    echo "<div style='padding:20px;' >No Attachments  </div>";
                }
                ?>
                
            </div> 

        </div> 
                    <div>
                        <button type="button"  class="edit_button confirm_button" value="confirm" name="confirm" id="edit_confirm"  onclick="submitedit()">CONFIRM</button>
                        <a style="text-decoration:none;" href="<?= SITE_URL ?>front/viewrequest?key=<?=base64_encode($ticketsData['key'])?>" class="edit_button cancel_button" name="cancel" id="edit_cancel">CANCEL</a>
            </div>
    </div>