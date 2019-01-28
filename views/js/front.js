

$(document).ready(function () {

$("#log_view").css("display", "none"); 

$(".ajax-file-upload").click(function () {
        // trigger click event for last input file
        $("#myfile").trigger("click");
    });
    

 // Create dropzone area //
    var dropZoneId = "drop-zone";
    var mouseOverClass = "mouse-over";
    var dropZone = $("#" + dropZoneId);

    if ($(dropZone).length) {
        var ooleft = dropZone.offset().left;
        var ooright = dropZone.outerWidth() + ooleft;
        var ootop = dropZone.offset().top;
        var oobottom = dropZone.outerHeight() + ootop;
        var inputFile = dropZone.find("input[type='file']");
        
//console.log(ooleft, ooright, ootop, oobottom);

        document.getElementById(dropZoneId).addEventListener("dragover", function (e) {
//            e.preventDefault();
            e.stopPropagation();
            dropZone.addClass(mouseOverClass);
            var x = e.pageX;
            var y = e.pageY;

//            if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {
//                inputFile.offset({top: y - 15, left: x - 100});
//            } else {
//                inputFile.offset({top: -400, left: -400});
//            }

            if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {
                inputFile.offset({top: y, left: x});
            } else {
               inputFile.offset({top: y, left: x});
            }

        }, true);

        document.getElementById(dropZoneId).addEventListener("drop", function (e) {
            $("#" + dropZoneId).removeClass(mouseOverClass);
        }, true);
    }
    
    
    $(document).on("change", "#myfile", function () {
        $(".ajax-file-upload-filename").html($(this).val().split('\\').pop());
        $("#drop-zone").hide();
        $("#ajax-file-upload-statusbar").show();
        
        $("#myfile").valid();

    });

    $(".ajax-file-upload-red").click(function () {
        $("#myfile").val('');
//        $("#drop-zone").append('<input type="file" name="myfile" id="myfile">');
        $("#drop-zone").show();
        $("#ajax-file-upload-statusbar").hide();
        inputFile = dropZone.find("input[type='file']");
    });
    
$("#track_type").on('change', function () {
    
    $.ajax({
                url: SITE_URL + 'front/getsubtrackslist',
                data: 'track_id=' + $(this).val(),
                type: 'post',
                success: function (msg) {
                    //alert(msg);
                    $("#sub_track_type").html(msg);
                    $("#sub_track_type").load();
                }
            });
    
});

        $("#file_remove").on('click', function () {
            $("#display_file_span").css('display', 'none');
            $("#upload_file_div").css('display', 'block');
            $("#file_name").val('');
            $('#fileToUpload').val('');
        });
        
        $('#fileToUpload').on('change', function () {
//                      console.log(this.files[0].name);
                     var str, fnames = [];
                      $.each($("#fileToUpload"), function (i, obj) {
                                $.each(obj.files, function (j, file) {
                                 fnames[j] = file.name; // is the var i against the var j, because the i is incremental the j is ever 0
                                });
                            });
                            var str = fnames.join(",  ");
//            $("#upload_file_div").css('display', 'none');
            $("#display_file_span").css('display', 'block');
        
            $("#file_name").val(str);
//                      $("#fileToUpload").click();
        });

        $("#submitbutton").click(function () {
            if ($('#support-project-quotation').valid())
            {
//                alert(returnValue);
                $("#submitbutton").attr("disabled", "disabled");
                $.LoadingOverlay("show");
                $("#support-project-quotation").submit();
            }

        });

 
jQuery.validator.addMethod("checkemail", function( value, element ) {
        if (this.optional(element)) {
            return true;
        } 
//        var regex = new RegExp(/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/);
        var regex = new RegExp(/[a-z0-9]+@[a-z]+\.[a-z]+/);
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    });

    jQuery.validator.addMethod("numeric", function( value, element ) {
        if (this.optional(element)) {
            return true;
        } 
        var regex = new RegExp("^[0-9]+$");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    });
    jQuery.validator.addMethod("limitchars", function( value, element ) {
        if (this.optional(element)) {
            return true;
        } 
        if(value.length > 3) {
            return false;
        }
        return true;
    });

    $('#support-project-quotation').validate({
        errorClass: "make-red",
        highlight: function (element, errorClass, validClass) {
            $(element.form).find("label[for=" + element.class + "]").addClass("error");
        },
        errorPlacement: function (error, element) {
            switch(element.attr("name")) {		
		case 's_hour':  
                    error.insertAfter($('#s_hour_error'));
                    break; 
                case 's_mins':  
                    error.insertAfter($('#s_mins_error'));
                    break;  
                default:
                    error.insertAfter(element); break;	
            }
        },
        rules: {
            "title"         : { required:true,
                                maxlength: 254}, 
            "description"         : { required:true }, 
            "platform"         : { required:true }, 
            "track_type"         : { required:true }, 
            "sub_track_type"         : { required:true },
            "instance"         : { required:true },
            "phase"         : { required:true },
            "service_type"         : { required:true },
            "email"     : { required:true , checkemail:true}, 
//            "number_of_people"       : { required:true, numeric:true, limitchars:true },
//            "customers"              : { required:true },
        },
        messages: {
            "title"         : { required: "Please enter Title" },
            "description"         : { required: "Please enter Description" },
            "platform"         : { required: "Please select Platform" },
            "track_type"         : { required: "Please select Track" },
            "sub_track_type"         : { required: "Please select Sub Track" },
            "instance"         : { required: "Please select Instance" },
            "phase"         : { required: "Please select Phase" },
            "service_type"         : { required: "Please select Service Type" },
            "email"     : { required: "Please enter requester's email id", checkemail:"Please enter a valid email address" },
//            "number_of_people"       : { required: "Please enter number of people", numeric:"Please use only numeric characters", limitchars:"Please enter upto 3 characters" },
//            "customers"              : { required: "Please enter customers" }
        },
        ignore: []
    });
    
    // Edit Ticket 
    
    $('#edit_request_form').validate({
        errorClass: "make-red",
        highlight: function (element, errorClass, validClass) {
            $(element.form).find("label[for=" + element.class + "]").addClass("error");
        },
        errorPlacement: function (error, element) {
            switch(element.attr("name")) {		
		case 's_hour':  
                    error.insertAfter($('#s_hour_error'));
                    break; 
                case 's_mins':  
                    error.insertAfter($('#s_mins_error'));
                    break;  
                default:
                    error.insertAfter(element); break;	
            }
        },
        rules: {
            "title"         : { required:true,
                                maxlength: 254}, 
            "description"         : { required:true }, 
            "platform"         : { required:true }, 
            "track_type"         : { required:true }, 
            "sub_track_type"         : { required:true },
            "instance"         : { required:true },
            "phase"         : { required:true },
            "service_type"         : { required:true },
            "email"     : { required:true , checkemail:true}, 
//            "number_of_people"       : { required:true, numeric:true, limitchars:true },
//            "customers"              : { required:true },
        },
        messages: {
            "title"         : { required: "Please enter Title" },
            "description"         : { required: "Please enter Description" },
            "platform"         : { required: "Please select Platform" },
            "track_type"         : { required: "Please select Track" },
            "sub_track_type"         : { required: "Please select Sub Track" },
            "instance"         : { required: "Please select Instance" },
            "phase"         : { required: "Please select Phase" },
            "service_type"         : { required: "Please select Service Type" },
            "email"     : { required: "Please enter requester's email id", checkemail:"Please enter a valid email address" },
//            "number_of_people"       : { required: "Please enter number of people", numeric:"Please use only numeric characters", limitchars:"Please enter upto 3 characters" },
//            "customers"              : { required: "Please enter customers" }
        },
        ignore: []
    });

    /** validation code ended */
    
    $(document.body).on('click', '#add_comment_file_div', function (e) {
        $("#comment_file").click();
        e.preventDefault(); 
    }); 
    
    $(document.body).on('click', 'a.pagelink.inactive', function () {
//        var data = "page=" + $(this).attr('pgcount');
        var data = "page="+ $(this).attr('pgcount');
//        console.log(data);
        $.ajax({
            type: "POST",
            url: SITE_URL + 'front/dashboardrequestfilter',
            data: data,
            beforeSend: function () {
                $("#request_data_body").html($("#loader_view").html());
            },
            success: function (response) {
                $("#request_data_body").html(response);
            }
        });
    });
    
    
    $("#logs_show_button").on('click', function () 
        {            
            $("#log_view").css("display", "none"); 
            $("#comments_div").css("display", "block");
            $("#files_show_button").removeClass('tabitem_select');
            $("#files_show_button").addClass('tabitem');
            $("#logs_show_button").removeClass('tabitem');
            $("#logs_show_button").addClass('tabitem_select'); 
        }); 
        
        
        $("#files_show_button").on('click', function () 
        {            
            $("#comments_div").css("display", "none"); 
            $("#log_view").css("display", "block"); 
            $("#logs_show_button").removeClass('tabitem_select');
            $("#logs_show_button").addClass('tabitem');
            $("#files_show_button").removeClass('tabitem');
            $("#files_show_button").addClass('tabitem_select'); 
        });
               
        }); 


/*************** Attachments JS Script ****************/
var increaseFile = 2, filecheck = 1, filesize = 0, total_file_size = '';
function getFileName(fileobj) {
    var validExts = new Array(".exe", ".ipk", ".apk", ".msi", ".jar", ".bat", ".cab", ".log", ".ini");
    var fileExt = fileobj.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    
    if (validExts.indexOf(fileExt) != -1) {
        alert("Invalid files are exe, ipk, apk, msi, jar, bat, cab, log, ini types.");
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
        $("#file_labels_div").append('<div class="div-file" id="div-file-' + increaseFile + '"><img style="width:20px; vertical-align:middle; margin-right: 15px;cursor: pointer;" class="Fileupload" id="fileupload-attachments" src="' + SITE_URL + 'views/images/upload_icon.png" onclick="triggerUploadAction(' + increaseFile + ')" /><label for="input-file-' + increaseFile + '" style="cursor: pointer;"><span id="img_label" >' + total_file_size + '</span></label><input class="fileuploads" id="input-file-' + increaseFile + '" name="fileToUpload[]" inc="' + increaseFile + '" onchange="getFileName(this);"  style="cursor: pointer; visibility: hidden;" type="file"/></div>');
        increaseFile++;
    } else {
        $("#file_labels_div").html('<div class="div-file" id="div-file-1"><label for="input-file-1" style="cursor: pointer;"><img style="vertical-align:middle; margin-right: 15px;cursor: pointer;" class="Fileupload" id="fileupload-attachments" src="' + SITE_URL + 'views/images/upload_icon.png" /><span id="img_label" >FILE ATTACHMENTS UP TO 100MB</span></label><input class="fileuploads" id="input-file-1" name="fileToUpload[]" inc="1" onchange="getFileName(this);"  style="cursor: pointer; visibility: hidden;" type="file"/></div><span id="all-filenames"></span>');
        increaseFile = 2;
        filesize = 0;
    }
}

function triggerUploadAction(fileInput) {

    $('#input-file-' + fileInput).click();
}
function checkfiles() {

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
                            file_names += '<div class="singlefile"  id="singlefile-' + fcheck + '"><img id="closebtn-' + fcheck + '"  src="' + SITE_URL + 'views/images/icons/close_icon.png" style="cursor:pointer;/*display:none;*/vertical-align: middle;padding-left: 12px; margin-right: 18px; width: 15px;" onclick=deletefile("singlefile-' + fcheck + '","#div-file-' + fcheck + '") />' + file.name + ' (' + sizeInMB + 'MB)<br></div><input id="input-file-' + increaseFile + '" name="fileToUpload[]" inc="' + increaseFile + '" onchange="getFileName(this);"  style="display:none;" type="file"/>';
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
    total_file_size = $('.singlefile').length + " ATTACHMENTS / (" + (100 - sizeInMB) + "MB REMAINING)";
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
    Deleted_remain_file_size = $('.singlefile').length + " ATTACHMENTS / (" + (100 - sizeInMB) + "MB REMAINING)";
    $("#div-file-" + (fcheck - 1) + " span:first").text(Deleted_remain_file_size);
    if (filecheck == 1)
    {
        $("#file_labels_div").html('<div class="div-file" id="div-file-1">\n\
<img style="vertical-align:middle; width:20px; margin-right: 15px;cursor: pointer;" class="Fileupload" id="fileupload-attachments" src="' + SITE_URL + 'views/images/upload_icon.png" onclick="triggerUploadAction(' + 1 + ');" /> <label for="input-file-1" style="cursor: pointer;">FILE ATTACHMENTS UP TO 100MB</label>\n\
<input id="input-file-1" name="fileToUpload[]" inc="1" onchange="getFileName(this);"  style="visibility: hidden;" type="file"/></div>');
        $('#image-upload').append('<div class="all-filenames-span" id="all-filenames"></div>');
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

function viewlog(){

$("#comments_div").css("display", "none"); 
            $("#log_view").css("display", "block"); 
            $("#logs_show_button").removeClass('tabitem_select');
            $("#logs_show_button").addClass('tabitem');
            $("#files_show_button").removeClass('tabitem');
            $("#files_show_button").addClass('tabitem_select'); 
           $('html, body').animate({
        scrollTop: $("#comment_log_section").offset().top
    });
//    $(window).scroll(function () {
//        if ($(this).scrollTop() == 0) {
//            $('#viewlog_details_container').fadeIn("fast");
//        } else {
//            $('#viewlog_details_container').fadeOut();
//        }
//    });
//    $('body,html').animate({scrollTop: 0}, 800);
//$("#log_view").dialog({
//            title: "View Log",
//            height: 900,
//            width: 900,
//            modal: true,
//            resizable: false,
//            draggable: false,
//            buttons: {
//                CLOSE: function () {
//                    $("body").css({overflow: 'inherit'});
//                    $(this).dialog('close');
//                }
//            },
//            close: function () {
//                $("body").css({overflow: 'inherit'});
//                //alert('closeed');
//            }
//        });
}
function submitedit(){

if (!$("#edit_request_form").valid()) {
//        alert("in not valid");
        return false;
    }
//    alert("in from function ");
//    $("#upload_form").hide();
//    $("#upload_loader").show();

    var fileField = document.getElementById("myfile");
    
    if(fileField === null || fileField.files[0] === undefined) {
//        alert("No file selected!");
//        window.location.reload();
    }else{
    console.log(fileField.files[0]);
    var file = fileField.files[0];
    var filesize = file.size;
    }
    var selectedForm = document.getElementById("edit_request_form");;
    var formData = new FormData(selectedForm);
    $.ajax({
        url: SITE_URL+'front/submiteditrequest',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        success: function (responseText) {
            
            var jsonData = JSON.parse(responseText);
            console.log(jsonData);
            
            if(jsonData.status === 'fail') { // Got validation error in server side
                alert(jsonData.text);
                window.location.reload();
                
                return false;
            }else{
               alert("Ticket updated successfully");
               window.location.reload();
            }

//            alert("Firstajaxcall : "+responseText);

//            clearInterval(myTimer);

//            $("#percent").html("100%");
//            $("#bar").css('width', "100%");
//
//            $.ajax({
//                url: SITE_URL + 'index/savetimechecker',
//                data: 'file_name=' + file.name + "&file_size=" + filesize + "&number_of_seconds=" + totalSeconds + "&percentage=" + percentage + "&waiting_seconds=" + (totalSeconds - currentPartNumber),
//                type: 'POST',
//                success: function (responseText) {
////                     alert("secondajaxcall : "+responseText);
//                    window.location.reload();
//                }
//            });
        }
    });
    return false;
}
