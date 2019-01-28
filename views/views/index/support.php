<?php
//App::pre($_SESSION);
?>

<script type="text/javascript" src="<?= SITE_URL ?>public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    var SITE_URL = "<?= SITE_URL ?>";
    var jqueryValidation = $.parseJSON('<?= json_encode($jqueryValidation);?>');
//    console.log(jqueryValidation);
</script>
<script type="text/javascript" src="<?= SITE_URL ?>public/css/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>public/js/jquery-1.11.1.validate.js"></script>

<link type="text/css" rel="stylesheet" href="<?= SITE_PUBLIC_URL ?>css/support_popup.css" />
<link type="text/css" rel="stylesheet" href="<?= SITE_PUBLIC_URL ?>css/selectize.default.css" />
<script type="text/javascript" src="<?= SITE_PUBLIC_URL ?>js/selectize.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>public/js/loadingoverlay.min.js"></script>
<script type="text/javascript" src="<?= SITE_URL ?>public/js/support.js"></script> 

<script type="text/javascript">
            
function changeIssueType(IssueType){
    if(IssueType == 'Question'){
        $("#priority").val("Medium");
        $(".priority_tr").hide();
    }else{
        $("#priority").val('');
        $(".priority_tr").show();
    }
}

$(document).ready(function () {
//     console.log(jqueryValidation);

   $('#support-project-quotation').validate({
        errorClass: "error",
        focusInvalid: true,
        errorPlacement: function (error, element) {
//            console.log(element);
            error.insertAfter(element);
            switch (element.attr("name")) {
                case 'title':
                    error.insertAfter("#title_error");
                    break;
                case 'service_type':
                    error.insertAfter("#service_type_error");
                    break;
                case 'priority':
                    error.insertAfter("#priority_error");
                    break;
                    case 'description':
                    error.insertAfter("#description_error");
                    break;
                    case 'requester_name':
                    error.insertAfter("#requester_name_error");
                    break;
                case 'email':
                    error.insertAfter("#email_error");
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
            "title": {required: true, maxlength:254},
            "service_type": {required: true},
            "priority": {required: true},
            "description": {required: true},
            "requester_name": {required: true, maxlength:150},
            "email": {required: true, email:true, maxlength:250}
        },
        messages: {
            "title": {required: "Please enter Subject"},
            "service_type": {required: "Please select Service Type"},
            "priority": {required: "Please select Severity"},
            "description": {required: "Please enter Description"},
            "requester_name": {required: "Please enter Requester Name"},
            "email": {required: "Please enter Requester Email"}
        },
        ignore: []
    });  
    
            $("#submitbutton").click(function () {
            
            if($('#support-project-quotation').valid()){
                $("#submitbutton").attr("disabled", "disabled");
//                alert("true");
            $.LoadingOverlay("show");
            $("#support-project-quotation").submit();
            }else{
//                alert("eerer");

                return false;
            }
        });
    
});
        </script>     
<style>
    
    @font-face {
    font-family:Roboto Condensed;
    src: url(<?= SITE_URL ?>public/css/fonts/Roboto-Regular.ttf);
}

 ::-moz-placeholder {
    font-style: normal !important;
    color:#656363 !important;
    letter-spacing:1px !important;
    font-family : Roboto Condensed !important;
}

 ::-webkit-input-placeholder {
     font-family :Roboto Condensed !important;
    font-style: normal !important;
   /*font-weight: 600!important;*/
    color:#656363 !important;
    
}

#title {
 font-family: Roboto Condensed !important;
}
.support_header {
 font-family: Roboto Condensed !important;
}
.ui-dialog .ui-dialog-content{
    padding: 0px;
    background-color: #FFFFFF;
    font-family : Roboto Condensed !important;
    color: #7a7a7a;
}
.error{
        color: red;
        /*margin-left: 10px;*/
        padding-left: 10px;
        font-size: 15px !important;
    }
       .support-container-div{
        background-color: #FFFFFF;
        margin: auto;
        padding: 0 100px;
        margin-top: 20px;
        font-family : Roboto Condensed !important;

    }
    .div-file {    
    background-color: #7bc3f7;
    padding: 4px 8px 20px;
    height: 17px;
    text-align: left;
    border-radius:3px;
    }
    #support-project-quotation .form{
        /*width: 650px;*/ 
    }
    #support_popup_dialog{
        padding: 0px;
    }
    .support_header{
        display: block;
        height: 40px;
        background-color: #cdcdcd;
        text-align: center;
        vertical-align: bottom !important;
        line-height: 40px;
        font-weight: bold;
    }
    .rowconsis{
        padding: 4px 2px;
        color: #7a7a7a;
        font-size: 15px;
    }
    .rowconsisdiv{
        padding: 7px 0px;
    }
    .select_options {
    padding: 6px 6px 6px 2px !important;
    }
    .request {
        width: 440px;
        background: #e3e2e2;
        border: 1px;
        border-radius: 3px;
        font-size: 14px !important;
        padding: 6px;
        color: #000;
        font-family: Roboto Condensed !important;
    }
    #support-project-quotation input::placeholder , textarea::placeholder  {
        font-family: Roboto Bold Condensed;
        color: #000;
        /*font-weight: bold;*/
        /*text-decoration:*/
    }
    #support-project-quotation select option{
        background-color: #FFFFFF;
        color: #000;
        padding: 0px !important;
    }

    #support-project-quotation select label{
        color: #000;
    }


    #support-project-quotation textarea{
        height: 80px;
        resize: none;
        color:#000;
    }
    #support-project-quotation input[type=text] {
        color: #000;
    }
    #support-project-quotation .upload_file_div{
        width:  440px;
        /*background-color: #e3e2e2;*/
        padding: 4px;
        border-radius: 3px;
        text-align: center;
    }
    .support_file_span{
        cursor: pointer;
        /*padding-left: 30px;*/
    }
.singlefile{
    padding: 5px;
    text-align: left !important;
    /*border-bottom: 0.5px solid #FFF;*/
}

    .support-button{
/*        height: 30px;*/
        border-radius: 5px;
        font-family: Roboto Condensed !important;
        /*font-weight: bold;*/
        border: 1px #000 solid;
        letter-spacing: 1px;
        cursor: pointer;
  padding:5px 15px;

    }
    #support-project-quotation .submitBtn{
        color: #FFFFFF;
        background-color: #000;

    }
    #support-project-quotation .cancelBtn{
        color: #000;
        background-color: #FFFFFF;    
    }
    #support-project-quotation .support-button-span{
        padding: 15px;
    }
    #file_name{
        float: left;
        /*width: 100px;*/
    }

    #support-project-quotation input::-webkit-input-placeholder{
        font-family: Roboto Condensed !important;
        font-weight: lighter;
        color: #6b6868;
    }
    #support-project-quotation textarea::-webkit-input-placeholder{
        font-family: Roboto Condensed !important;
        font-weight: lighter;
        color: #6b6868;
    }
    
    #support-project-quotation .selectize-control{
        color:#000;
        width: 440px !important;
        background-color: #fff !important;
        border-radius: 3px !important;
        padding: 0px !important;
    }

    #support-project-quotation .selectize-input{
    border: none;
    background: #e3e2e2;
    width: 440px !important;
    padding: 5px 5px 0px 5px !important;
    border: 0px !important;
    border-radius: 3px !important; 
    }
/*    #support-project-quotation .selectize-input{
        background-color: #e3e2e2;
        width: 509px;
    }*/
     #additional-cc-selectized {
        height:50px !important;
    }
    
</style>
<script>
    
    
    /*************** Attachments JS Script ****************/
var increaseFile = 2, filecheck = 1, filesize = 0, total_file_size = '';
function getFileName(fileobj) {
    var validExts = new Array(".exe", ".ipk", ".apk", ".msi", ".jar", ".bat", ".cab", ".log", ".ini", ".ttf" );
    var fileExt = fileobj.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    //console.log(validExts.indexOf(fileExt));
    if (validExts.indexOf(fileExt) != -1) {
//      alert("Invalid files are " +
//               validExts.toString() + " types.");
        alert("Invalid files are exe, ipk, apk, msi, jar, bat, cab, log, ini, ttf types.");
        $("#input-file-" + (increaseFile-1) ).val('');
        return false;
    }                
    checkfiles();
    console.log(filesize);
    if (filesize > 104857600) {
        alert('Your file(s) contains more than 100MB. Please upload upto 100MB');
        return false;
    }

    if (filecheck == 2) {
        $("#div-file-" + $("#" + fileobj.id + "").attr('inc')).hide();
        $("#file_labels_div").append('<div class="div-file" id="div-file-' + increaseFile + '"><img style="vertical-align:middle; margin-right: 15px;cursor: pointer;" class="Fileupload" id="fileupload-attachments" src="' + SITE_URL + 'public/images/plus_icon.png" onclick="triggerUploadAction(' + increaseFile + ')" /><label for="input-file-' + increaseFile + '" style="cursor: pointer;"><span id="img_label" >' + total_file_size + '</span></label><input class="fileuploads" id="input-file-' + increaseFile + '" name="projectfiles[]" inc="' + increaseFile + '" onchange="getFileName(this);"  style="cursor: pointer; visibility: hidden;" type="file"/></div>');
        increaseFile++;
    } else {
        $("#file_labels_div").html('<div class="div-file" id="div-file-1"><label for="input-file-1" style="cursor: pointer;"><img style="vertical-align:middle; margin-right: 15px;cursor: pointer;" class="Fileupload" id="fileupload-attachments" src="' + SITE_URL + 'public/images/plus_icon.png" /><span id="img_label" >FILE ATTACHMENTS UP TO 100MB</span></label><input class="fileuploads" id="input-file-1" name="projectfiles[]" inc="1" onchange="getFileName(this);"  style="cursor: pointer; visibility: hidden;" type="file"/></div><span id="all-filenames"></span>');
        increaseFile = 2;
        filesize = 0;
    }
}

function triggerUploadAction(fileInput) {
//    alert(fileInput);
    $('#input-file-' + fileInput).click();
}
function checkfiles() {
    //file_names='<span id="all-filenames">';
    file_names = '';
    filesize = 0;
    filecheck = 1;

    for (fcheck = 0; fcheck < increaseFile; fcheck++) {
//        alert("in for checkfiles fun");
        if ($('#div-file-' + fcheck).length > 0)
        {

            var x = document.getElementById("input-file-" + fcheck);
            var txt = "";
            myFile = "input-file-" + fcheck + "";
            if ('files' in x) {
                //alert(x.files.length)
                if (x.files.length == 0) {
                    txt = "Select one or more files.";
                } else {

                    filecheck = 2;
                    for (var i = 0; i < x.files.length; i++) {
                        //txt += "<br><strong>" + (i+1) + ". file</strong><br>";
                        var file = x.files[i];
                        if ('name' in file) {
                            // txt += "name: " + file.name + "<br>";
                            if (filesize > 104857600)
                            {
                                $("#all-filenames").html(file_names);
                                //alert("You have exceeded maximum allowed size 3GB")
                                return true;
                            }

                            if ('size' in file) {
                                var sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                            }

                            //alert(sizeInMB + 'MB');

                            // file_names+='<span onmouseover=\'$("#closebtn-'+fcheck+'").show()\' onmouseout=\'$("#closebtn-'+fcheck+'").hide()\' id="singlefile-'+fcheck+'">'+file.name+' ('+sizeInMB+'MB) <img id="closebtn-'+fcheck+'"  src="images/x-close_btn.png" style="cursor:pointer;/*display:none;*/vertical-align: bottom;padding-left: 3px;" onclick=deletefile("singlefile-'+fcheck+'","#div-file-'+fcheck+'") /> <br></span>';
                            file_names += '<div class="singlefile"  id="singlefile-' + fcheck + '"><img id="closebtn-' + fcheck + '"  src="' + SITE_URL + 'public/images/close_icon@2x.png" style="cursor:pointer;/*display:none;*/vertical-align: middle;padding-left: 12px; margin-right: 18px; width: 15px;" onclick=deletefile("singlefile-' + fcheck + '","#div-file-' + fcheck + '") />' + file.name + ' (' + sizeInMB + 'MB)<br></div><input id="input-file-' + increaseFile + '" name="projectfiles[]" inc="' + increaseFile + '" onchange="getFileName(this);"  style="display:none;" type="file"/>';
                        }
                        if ('size' in file) {
                            // txt += "size: " + file.size + " bytes <br>";
                            filesize += file.size
                        }
                    }
                }
            }

            //file_names+='</span>';

            //$( "span" ).remove( "#all-filenames" );
            //	$("#all-filenames").remove();
            if (filesize < 104857600)
            {
                $("#all-filenames").html(file_names);
            } else {
                $('#' + myFile).val('');
//                alert("You have exceeded maximum allowed size 100MB");
                return false;
            }

        }
    }

    var sizeInMB = (filesize / (1024 * 1024)).toFixed(2);
//    console.log((100-(filesize / (1024 * 1024))).toFixed(2));
    total_file_size = $('.singlefile').length + " ATTACHMENTS / (" + (100 - sizeInMB).toFixed(2) + "MB REMAINING)";
//				$("#div-file-"+fcheck).html(total_file_size)	
//alert(total_file_size);
}

function deletefile(filename, divname)
{
//	alert('file name is'+filename+"divname"+divname)
    $('#' + filename).remove();
    $(divname).remove();

    checkfiles();

    var sizeInMB = (filesize / (1024 * 1024)).toFixed(2);
    Deleted_remain_file_size = $('.singlefile').length + " ATTACHMENTS / (" + (100 - sizeInMB).toFixed(2) + "MB REMAINING)";
    $("#div-file-" + (fcheck - 1) + " span:first").text(Deleted_remain_file_size);
    if (filecheck == 1)
    {
        $("#file_labels_div").html('<div class="div-file" id="div-file-1">\n\
<img style="vertical-align:middle; margin-right: 15px;cursor: pointer;" class="Fileupload" id="fileupload-attachments" src="' + SITE_URL + 'public/images/plus_icon.png" onclick="triggerUploadAction(' + 1 + ');" /> <label for="input-file-1" style="cursor: pointer;">FILE ATTACHMENTS UP TO 100MB</label>\n\
<input id="input-file-1" name="projectfiles[]" inc="1" onchange="getFileName(this);"  style="visibility: hidden;" type="file"/></div>');
        $('#upload_file_div').append('<div class="all-filenames-span" id="all-filenames"></div>');
        increaseFile = 2;
        filesize = 0;
    }

}
$(function () {
    $('.Fileupload').click(function (e) {
//     alert('hdfhhf fijdjol');
        e.preventDefault();
        $('#input-file-1').click();
    });
});

    function suppCan() {
//        alert("efershgtdyh");
        
        $('.ui-dialog-titlebar-close').trigger("click");
        window.parent.$("#support_popup_dialog").dialog('close');
//        $("#support_popup_dialog").dialog("close");
//        window.parent.closeIframe();
        return false;
//        $("#support_popup_dialog").dialog("close");

    }
    function triggUpoladFile() {
        $("#fileToUpload").click();
    }
    $(document).ready(function () {

//        $("#file_remove").on('click', function () {
//            $("#display_file_td").css('display', 'none');
//            $("#upload_file_td").css('display', 'block');
//            $("#file_name").val('');
//            $('#fileToUpload').val('');
//        });
//
//        $('#fileToUpload').on('change', function () {
////                      console.log(this.files[0]);
//            $("#display_file_td").css('display', 'block');
//            $("#upload_file_td").css('display', 'none');
//            $("#file_name").val(this.files[0].name);
////                      $("#fileToUpload").click();
//        });

        
          var REGEX_EMAIL = '([a-zA-Z0-9]{1,})((@[a-zA-Z]{2,})[\\\.]([a-zA-Z]{2}|[a-zA-Z]{3}))';

    $('#additional-cc').selectize({
        plugins: ['remove_button'],
        persist: false,
        maxItems: null,
        valueField: 'email',
        labelField: 'name',
        searchField: ['name', 'email'],
        maxLength: 100,
//        options: $.parseJSON(''),
        optgroups: [
            {value: 'emailcontent', label: 'CONTACTS AND RECENT ADDRESSES '},
        ],
        optgroupField: 'class',
        render: {
            optgroup_header: function (data, escape) {
                return '<div class="optgroup-header">' + escape(data.label) + '</div>';
            },
            item: function (item, escape) {
                var caption = item.name ? item.name : item.email;
                return '<div>' +
                        (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                        '</div>';
            },
            option: function (item, escape) {
                var label = item.name || item.email;
                var caption = item.name ? item.email : null;
                return '<div>' +
                        '<span class="label">' + escape(label) + '</span>' +
                        (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                        '</div>';
            }
        },
        createFilter: function (input) {
            console.log(input);

            var match, regex;

            // email@address.com
            regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');

            match = input.match(regex);

            if (match)
                return !this.options.hasOwnProperty(match[0]);

            // name <email@address.com>
            regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
            match = input.match(regex);
            if (match)
                return !this.options.hasOwnProperty(match[2]);

            return false;
        },
        create: function (input) {

            if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
                return {email: input};
            }
            var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
            if (match) {
                return {
                    email: match[2],
                    name: $.trim(match[1])
                };
            }
            alert('Invalid email address.');
            return false;
        }
    });

    });
</script>
<!--<d  iv class="support_header"><span>CREATE NEW TICKET</span></div>-->
<div id="support-container-div" class="support-container-div" >

    <form id="support-project-quotation" name="support-project-quotation"  target="_parent" action="<?= SITE_URL ?>support/index/supportsubmit" method="POST" enctype="multipart/form-data" novalidate="novalidate" autocomplete="off" >
        <div class="">
    <!--        <span class="roboto-bold heading">
                <img src="http://dev.ncpo.cc/production-request-portal/views/images/incipio-logo-white.png" style="position: relative; top: 2px; width: 15%; vertical-align: middle; margin-bottom: 10px;"><br>
                <div class="roboto-bold  heading" style="background-color: #cbcbcb"></div>
                <div style="border-top:3px solid #000000;width:36px;"></div>
            </span>-->
<input type="hidden" class="request" id="dashboard_type" name="dashboard_type" value="<?=$_REQUEST['dashboard_type'];?>" required/>
            <div id="support_msg_div"></div>
            <div class="form-text">
                <table>
                    <tbody>
                        <tr>
                            <td id="task_td" class="rowconsis">Subject :   <span class="error" id="title_error"></span> </td>
                        </tr>
                        <tr>

                            <td class="rowconsis">
                                <input class="request valid" type="text" placeholder="Please enter subject" id="title" name="title" required autofocus/>
                                <!--<span class="error" id="title_error"></span>-->
                            </td>
                        </tr>
                         <?php 
                           if($_REQUEST['dashboard_type'] == 'Requester-Login' || $_REQUEST['dashboard_type'] == 'Backadmin-Login'){
                               $selectionDisable = ' disabled="true"';
                               $selectValue = 'selected="selected"';
                               echo '<input type="hidden" name="service_type" value="Support Bug" />';
                           }else{
                               $selectionDisable = '';
                               $selectValue = '';
                           }
                            ?>
                        <tr>
                            <td id="task_td" class="rowconsis">Service Type :   <span class="error" id="service_type_error"></span> </td>
                        </tr>
                        <tr>

                            <td class="rowconsis">
                                <select id="service_type" class="request custom-select select_options" name="service_type" required onchange="changeIssueType(this.value);"  <?=$selectionDisable ?>>
                                    <option value="" disabled="" selected="">Please select a Service Type</option>
                                    <option value="Support Bug" <?=$selectValue ?> >Bug</option>
                                    <option value="Improvement Request">Feature Request</option>
                                    <option value="Question">Question</option>
                                </select>
                                <!--<span class="error" id="service_type_error"></span>-->
                            </td>
                        </tr>
                        <tr class="priority_tr">
                            <td id="task_td" class="rowconsis">Severity :   <span class="error" id="priority_error"></span></td>
                        </tr>
                        <tr class="priority_tr">

                            <td class="rowconsis">
                                <select id="priority" class="request custom-select select_options" name="priority" required>
                                    <option value="" disabled="" selected="">Please select a Severity</option>
                                    <option value="Highest">Highest</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                    <option value="Lowest">Lowest</option>
                                </select>
                                <!--<span class="error" id="priority_error"></span>-->
                            </td>
                        </tr>
                        <tr>
                            <td id="task_td" class="rowconsis">Description :  <span class="error" id="description_error"></span></td>
                        </tr>
                        <tr>

                            <td class="rowconsis">
                                <textarea name="description" id="description" class="request required txtfield" placeholder="Please enter Description" required></textarea>
                                <!--<span class="error" id="description_error"></span>-->
                            </td>
                        </tr>
                         <?php 
                           if(!isset($support_requester_email)|| $support_requester_email =='' || $support_requester_name ==''){
                               $readonly = '';
                           } else {
                            $readonly = 'readonly="true"';   
                            }
                           ?>
                        <tr>
                            <td id="task_td" class="rowconsis">Requester Name :  <span class="error" id="requester_name_error"></span> </td>
                        </tr>
                        <tr>

                            <td class="rowconsis">
                                <input class="request valid" type="text" placeholder="Please enter Requester Name" id="requester_name" name="requester_name" value="<?php echo $support_requester_name; ?>" required <?=$readonly?>/>
                                <!--<span class="error" id="title_error"></span>-->
                            </td>
                        </tr>
                        <tr>
                            <td id="task_td" class="rowconsis">Requester Email  :   <span class="error" id="email_error"></span> </td>
                        </tr>
                        <tr>

                            <td class="rowconsis">
                                <input type="text" class="request" placeholder="Please enter Requester Email" id="email" name="email" value="<?php echo $support_requester_email; ?>" required <?=$readonly?> />
                                <!--<span class="error" id="email_error"></span>--> 
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td id="task_td" class="rowconsis">Additional CC's :   <span class="error" id="email_error"></span> </td>
                        </tr>
                        <tr>


                            <td class="rowconsis">
                                <input type="text"  class="request" name="additional-cc" id="additional-cc"  style="width:500px;" placeholder="Please enter Additional CC's        " value=""/>
                                <!--<span class="error" id="email_error"></span>--> 
                            </td>
                        </tr>
                        <tr>
                        </tr>
<!--                        <tr>
                            <td id="task_td" class="rowconsis">Attachment : </td>
                        </tr>
                        <tr>

                            <td class="rowconsis" id="upload_file_td">
                                <div class="upload_file_div">
                                    <span class="support_file_span" id="support_file_span" onclick="triggUpoladFile();">
                                        <span id="file_name" class="file_name"></span>
                                        <span>Upload <img width="13px;" src="<?= SITE_URL ?>views/images/upload_icon.png" /></span>
                                    </span></div>
                                <input type="file" class="request" name="projectfiles" id="projectfiles" style="display:none;">    
                            </td>
                            <td class="rowconsis" id="display_file_td" style="display:none">
                                <input style="width:505px !important;" type="text" class="request" id="file_name" name="file_name" value="" readonly="readonly" />
                                <img id="file_remove" style="width: 16px;padding-left: 3px;padding-top: 10px;" src="<?= SITE_URL; ?>views/images/Close-clear.png" />
                                <span class="error" id="email_error"></span> 
                            </td>
                        </tr>-->
                    </tbody>
                </table>
                
                <div class="form-field" >
                    <p id="task_td" class="rowconsis" style="font-size: inherit;    margin-top:1px;
    margin-bottom: 5px;"> Attachment(s) :  </p>
                        <div class="file_div" id="file_div">                  

                    </div>

                    <div class="upload_file_div" id="upload_file_div">
                    <span id="file_labels_div">                
                    <div class="div-file" id="div-file-1">
                        <label for="input-file-1" style="cursor: pointer;">
                            <img style="vertical-align:middle; margin-right: 15px;" class="Fileupload" id="fileupload-attachments" src="<?= SITE_URL ?>public/images/plus_icon.png" /> FILE ATTACHMENTS UP TO 100MB 
                        </label>
                        <input id="input-file-1" class="fileuploads" name="projectfiles[]" inc="1" onchange="getFileName(this);"  style="cursor: pointer; visibility: hidden;" type="file"/>
                    </div>
                </span>
                <div class="all-filenames-span" id="all-filenames"></div>
                    </div> 
<!--                    </p>-->
                    </div>
                <div style="text-align: center; padding: 20px;">
                    <span class="support-button-span">  <input class="support-button submitBtn" id="submitbutton" type="button" value="SUBMIT" /></span>
                    <span class="support-button-span"> <input class="support-button cancelBtn" id="submitbutton" type="button" value="CANCEL" onclick="suppCan();"/></span>

                    <!--<img id="validation_loader" style="width: 50px;left: 200px; position: absolute; display: none;" src="<?= SITE_URL ?>public/images/ajax_loader_front.gif">-->

                </div>
            </div>
        </div>
    </form>
</div>

