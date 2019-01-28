
<style>
    .error{
        color: red;
        margin-left: 10px;
    }
.upload_file_div{
    background-color: #e3e2e2;
    /*padding: 4px;*/
}
.singlefile{
    padding: 5px;
    border-bottom: 0.5px solid #FFF;
}
    .support_file_span, #file_remove, .support-button{
        cursor: pointer;
    }
    textarea{
        resize: none; 
    }
    .div-file {
    background-color: #7bc3f7;
    padding: 8px 15px 8px;
    height: 25px;
}
</style>
<script>
    function triggUpoladFile() {
        $("#fileToUpload_1").click();
       
    }
//   $(document).ready(function () {   
 
//          var REGEX_EMAIL = '([a-zA-Z0-9]{1,})((@[a-zA-Z]{2,})[\\\.]([a-zA-Z]{2}|[a-zA-Z]{3}))';
//
//    $('#additional-cc').selectize({
//        plugins: ['remove_button'],
//        persist: false,
//        maxItems: null,
//        valueField: 'email',
//        labelField: 'name',
//        searchField: ['name', 'email'],
//        maxLength: 100,
////        options: $.parseJSON(''),
//        optgroups: [
//            {value: 'emailcontent', label: 'CONTACTS AND RECENT ADDRESSES '},
//        ],
//        optgroupField: 'class',
//        render: {
//            optgroup_header: function (data, escape) {
//                return '<div class="optgroup-header">' + escape(data.label) + '</div>';
//            },
//            item: function (item, escape) {
//                var caption = item.name ? item.name : item.email;
//                return '<div>' +
//                        (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
//                        '</div>';
//            },
//            option: function (item, escape) {
//                var label = item.name || item.email;
//                var caption = item.name ? item.email : null;
//                return '<div>' +
//                        '<span class="label">' + escape(label) + '</span>' +
//                        (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
//                        '</div>';
//            }
//        },
//        createFilter: function (input) {
//            console.log(input);
//
//            var match, regex;
//
//            // email@address.com
//            regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');
//
//            match = input.match(regex);
//
//            if (match)
//                return !this.options.hasOwnProperty(match[0]);
//
//            // name <email@address.com>
//            regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
//            match = input.match(regex);
//            if (match)
//                return !this.options.hasOwnProperty(match[2]);
//
//            return false;
//        },
//        create: function (input) {
//
//            if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
//                return {email: input};
//            }
//            var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
//            if (match) {
//                return {
//                    email: match[2],
//                    name: $.trim(match[1])
//                };
//            }
//            alert('Invalid email address.');
//            return false;
//        }
//    });
//
//    });
</script>
<a class="form-field" style="float:right;" href="<?= SITE_URL ?>front/dashboard">Back to Dashboard</a>
<div id="support-container-div" class="support-container-div" >

    <form enctype="multipart/form-data" id="support-project-quotation"  action="<?= SITE_URL ?>/front/submitticket" method="POST" novalidate="novalidate">
       
        <div class="">

            <div id="support_msg_div"></div>
            <div class="form-text">
                <span class="form-field" >
                    <p id="" class="contact"><label for="subject"> TITLE <span style="color:red;">*</span> : </label> </p>
                        <input class="request txtfield" type="text" max-length="100" placeholder="Please enter title" id="title" name="title" required/>
                                <span class="error" id="title_error"></span>
                    
                </span>
                
                <span class="form-field" >
                    <p id="" class="contact"> <label for="description">Description <span style="color:red;">*</span>  : </label>  </p>
                
                                <textarea name="description" id="description" class="request required txtfield" placeholder="Please enter Description" required></textarea>
                                <span class="error" id="description_error"></span>
                
                </span>
                <span class="form-field" >
                    <p id="" class="contact"> <label for="platform"> Platform <span style="color:red;">*</span> : </label>  </p>
                                <select id="platform" class="request styled-select" name="platform" required>
                                    <option value="" disabled="" selected="">Please select a Platform</option>
                                    <option value="Concur">Concur</option>
                                    <option value="Oracle">Oracle</option>
                                    
                                </select>
                                <span class="error" id="platform_error"></span>
                            
                </span>
                    
                <span class="form-field" >
                    <p  class="contact"> <label for="track_type">Track <span style="color:red;">*</span> : </label> </p>
                                <select id="track_type" class="request styled-select" name="track_type" required>
                                    <option value="" disabled="" selected="">Please select a Track</option>
                                    <?php 
                                    foreach($trackList as $track){ ?>
                                     <option value="<?=$track['id'];?>" ><?=$track['track_name'];?></option>    
                                <?php } ?>
                                </select>
                                <span class="error" id="track_type_error"></span>
               
                </span>
                <span class="form-field" >
                    <p  class="contact"> <label for="sub_track_type">Sub Track <span style="color:red;">*</span>  : </label>  </p>
                                <select id="sub_track_type" class="request styled-select" name="sub_track_type" required>
                                    <option value="" disabled="" selected="">Please select a Sub Track</option>
                                </select>
                                <span class="error" id="sub_track_type_error"></span>
               
                </span>
                <span class="form-field" >
                    <p  class="contact"> <label for="instance">Instance <span style="color:red;">*</span>  : </label>  </p>
                                <select id="instance" class="request styled-select" name="instance" required>
                                    <option value="" disabled="" selected="">Please select a Instance</option>
                                    <option value="Development">Development</option>
                                    <option value="Production">Production</option>
                                    <option value="Test">Test</option>
                                    
                                </select>
                                <span class="error" id="instance_error"></span>
             
                </span>
                <span class="form-field" >
                    <p  class="contact"> <label for="phase">PHASE <span style="color:red;">*</span>  : </label>  </p>
                                <select id="phase" class="request styled-select" name="phase" required>
                                    <option value="" disabled="" selected="">Please select a Phase</option>
                                    <option value="CRP1">CRP1</option>
                                    <option value="CRP2">CRP2</option>
                                    <option value="SIT">SIT</option>
                                    <option value="Support">Support</option>
                                    <option value="UAT">UAT</option>
                                    
                                </select>
                                <span class="error" id="phase_error"></span>
              
                </span>
                
                <span class="form-field" >
                    <p  class="contact"> <label for="issue_type">Service Type <span style="color:red;">*</span> : </label>   </p>
                                <select id="service_type" class="request styled-select" name="service_type" required>
                                    <option value="" disabled="" selected="">Please select a Service Type</option>
                                    <option value="Decision">Decision</option>
                                    <option value="Issue">Issue</option>
                                    <option value="Risk">Risk</option>
                                    <option value="Requirement">Requirement</option>
                                </select>
                                <span class="error" id="service_type_error"></span>
                
                </span>
<!--                <span class="form-field" >
                    <p id="" class="contact"> <label for="requester_email" >Requester Email  : </label>   </p>
                                <input type="text" class="request" placeholder="Please enter Requester Email" id="email" name="email" value="" required/>
                                <span class="error" id="email_error"></span> 
                 
                </span>-->
<!--                <span class="form-field" >
                    <p id="" class="contact"> <label for="additional_ccs" > Additional CC's : </label>    </p>
                              <input type="text"  class="request" name="additional-cc" id="additional-cc"  style="" placeholder="Please enter Additional CC's        " value=""/>
                                <span class="error" id="email_error"></span> 
                </span>-->
                <span class="form-field" >
                    <p id="" class="contact"> <label for="attachements" > Attachment(s) : </label>
                        <div class="file_div" id="file_div">                  

                    </div>

                    <div class="upload_file_div" id="upload_file_div">
                    <span id="file_labels_div">                
                    <div class="div-file" id="div-file-1">
                        <label for="input-file-1" style="cursor: pointer;">
                            <img style="vertical-align:middle; width:20px; margin-right: 15px;" class="Fileupload" id="fileupload-attachments" src="<?= SITE_URL ?>views/images/upload_icon.png" /> FILE ATTACHMENTS UP TO 100MB 
                        </label>
                        <input id="input-file-1" class="fileuploads" name="fileToUpload[]" inc="1" onchange="getFileName(this);"  style="cursor: pointer; visibility: hidden;" type="file"/>
                    </div>
                </span>
                <div class="all-filenames-span" id="all-filenames"></div>
                    </div> 
                    </p>
                    </span>
                <span class="form-field" >
                <div style="text-align: center; " >
                    <span class="support-button-span">  <input class="support-button submitBtn" id="submitbutton" type="button" value="SUBMIT" /></span>
                    <!--<span class="support-button-span"> <input class="support-button cancelBtn" id="submitbutton" type="button" value="CANCEL" onclick="suppCan();"/></span>-->

                    <img id="validation_loader" style="width: 50px;left: 200px; position: absolute; display: none;" src="<?= SITE_URL; ?>views/images/ajax_loader_front.gif">
                    </span>
                </div>
                
            </div>
        </div>
    </form>
</div>