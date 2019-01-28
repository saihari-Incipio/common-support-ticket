
$(document).ready(function () {

//    $('.duedate_datetime').datetimepicker({
//        timeFormat: "hh:mm tt",
//        altField: "#alt_example_3_alt",
//        altFieldTimeOnly: false,
//        altFormat: "yy-mm-dd",
//        altTimeFormat: "HH:mm:00",
//    });

    
    $(".meeting-room.not-selected").click(function(){
        var roomId = $(this).data("room-id");
        var scheduleUrl = SITE_URL+"backadmin/allschedules";
        if(roomId !== "all") {
            scheduleUrl += "?room_id="+roomId;
        }
        window.location.href = scheduleUrl;
    });
    
    $(".dinner-reservations.not-selected").click(function(){
        window.location.href = SITE_URL+"backadmin/dinners";
    });
    
    $(".add_meeting").click(function(){
        
        $("#eventAdd").dialog({
                height: 650,
                width: 820,
                modal: true,
                resizable: false,
                draggable: false,
                buttons: {
                    SUBMIT: function () {
                        $("#project-quotation").submit();
                    }
                },
                close: function () {
        //            alert('closeed');
                }
            });
    });
        
    $('#edit_form').validate({
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
            "request_type"         : { required:true }, 
            "restaurant_name_1"     : { required:true }, 
            "restaurant_name_2" : { required:true }, 
            "number_of_people"        : { required:true },
            "customers"              : { required:true },
//            "comments"              : { required:true },
        },
        messages: {
            "request_type"         : { required: "Please select requester type" },
            "restaurant_name_1"     : { required: "Please enter restaurant choice 1" },
            "restaurant_name_2" : { required: "Please enter restaurant choice 2" },
            "number_of_people"        : { required: "Please enter number of people" },
            "customers"              : { required: "Please enter customers" },
//            "comments"              : { required: "Please enter comments" }
        },
//        ignore: []
    });
    
});

function approveRequest(requestId) {

    var designer = $("#project-designers-" + requestId).val();

    $.ajax({
        type: "POST",
        url: SITE_URL + 'backadmin/approverequest/',
        data: $("#request_row_" + requestId).find("select, input").serialize() + "&designer=" + designer,
        success: function (res) {
            var response = $.parseJSON(res);
            if (response.status === 0) {
                alert(response.message);
            } else {
//                $("#project_status_col_"+requestId).html(response.updatedData);
//                
//                if(!response.updatable) {
//                    $("#status_update_submit_"+requestId).hide();
//                }

                //window.location.reload();
                alert("Request status updated successfully.");
            }
        }
    });
}

function openModal() {
    document.getElementById('modal').style.display = 'block';
    document.getElementById('fade').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('fade').style.display = 'none';
}

function editevent(eId) {
   
   $.ajax({
        type: "POST",
        url: SITE_URL + 'backadmin/editevent',
        data: 'event_id='+eId,
        beforeSend: function () {
            $('#edit_form').html($("#loader_view").html());
        },
        success: function (response) {
            $("#edit_form").html(response);
        }
    });
        
    $("#eventEdit").dialog({
        height: 400,
        width: 520,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            BACK: function () {
                $(this).dialog('close');
            },
            DONE: function () {
                $("#edit_form").submit();
            }
        },
        close: function () {
//            alert('closeed');
        }
        
        
    });
}

function deleteEvent(eId) {
    if (confirm('Are you sure, you want to delete this event ?')) {
        window.location.href = SITE_URL + 'backadmin/deleteevent?eventID='+eId;
    } else {
        return false;
    }

}

function changerequesttype(value) {
//    alert(value);
    if(value === 'DINNER') {
        $('#restaurant_span_1').css('display', 'grid');
        $('#restaurant_span_2').css('display', 'grid');
    } else {
        $('#restaurant_span_1').css('display', 'none');
        $('#restaurant_span_2').css('display', 'none');
    }
    
    $('#number_of_people_label').html("No. of people in "+value+" (total)");
    
}

function changedate(date) {
    //console.log(date);
    
    $('#form_meeting_rooms').html($('#meeting_rooms').html());
    $('#form_meeting_rooms').css('display', 'grid');
    
     $.ajax({
        type: "POST",
        url: SITE_URL + 'backadmin/getavailablerooms',
        data: 'datetime='+date,
        beforeSend: function () {
            //$('#edit_form').html($("#loader_view").html());
        },
        success: function (response) {
            $("#meeting_room").html(response);
        }
    });
} 

// Start make session active //
var refreshSn = function () {
    var time = 60000; // 1 mins

    setTimeout(function () {
        $.ajax({
           url: SITE_URL+'backadmin/refreshsession',
           cache: false,
           complete: function () {
               refreshSn();
           }
        });
    }, time);
};

refreshSn();
// End make session active //