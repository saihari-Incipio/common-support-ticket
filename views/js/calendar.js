
function setupDraggable() {
    $('.dragg').draggable({
        revert: true, // immediately snap back to original position
        revertDuration: 0
    });

    $('.dragg').each(function () {

        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            id: $(this).data("id"),
            title: $.trim($(this).find(".event-title").text()), // use the element's text as the event title
            stick: true // maintain when user navigates (see docs on the renderEvent method)
        });
    });
}
var viewDate = '';
//var allDates = '';

$(document).ready(function () {// document ready

    setupDraggable();
    
    $(document.body).on('click', 'a.pagelink.inactive', function () {
//        var data = "page=" + $(this).attr('pgcount');
        var data = "page="+ $(this).attr('pgcount')+"&date="+viewDate;
//        console.log(data);
        $.ajax({
            type: "POST",
            url: SITE_URL + 'backadmin/unschedules',
            data: data,
            beforeSend: function () {
                $("#list-view").html($("#loader_view").html());
            },
            success: function (response) {
                $("#list-view").html(response);
                setupDraggable();
            }
        });
    });

});

function loadSchedules(meetingRooms, schedules) {

    $('#calendar').fullCalendar({
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        defaultView: 'agendaDay',
        minTime: "07:00:00",
        maxTime: "20:00:00",
        defaultDate: '2017-01-04',
//            gotoDate: 'currentDate',
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        eventOverlap: false,
        allDaySlot: false,
        height: 535,
        header: {
            left: 'myCustomButton',
            center: 'prev,title,next',
            right: 'agendaDay,agendaFourDay',

        },
        views: {
            agendaFourDay: {
                type: 'agenda',
                duration: {days: 5},

                // views that are more than a day will NOT do this behavior by default
                // so, we need to explicitly enable it
                groupByResource: false

                        //// uncomment this line to group by day FIRST with resources underneath
                        //groupByDateAndResource: true
            }
        },

        titleFormat: 'dddd, MMMM DD, YYYY',
        timeFormat: 'h:mm a',
        resources: meetingRooms,
        events: schedules,
        eventConstraint: {
            start: "00:00", // a start time (10am in this example)
            end: "24:00", // an end time (6pm in this example)
        },

        droppable: true,

//            dropAccept: '.dragg',
        drop: function (date, jsEvent, ui, resourceId) {

//                if(!confirm("Are you sure want to schedule this meeting?")) {
//                    return false;
//                }

            console.log("Dropped on " + date.format());

            console.log('drop', date.format(), resourceId);
            $(this).remove();
        },
        customButtons: {
            myCustomButton: {
                text: 'SAVE',
                click: function () {
                    if (!confirm("Are you sure want to save changes?")) {
                        return false;
                    }

                    var events = $('#calendar').fullCalendar('clientEvents');
                    var eventsData = [];

                    $(events).each(function () {
                        eventsData.push({
                            'event_id': this.id,
                            'start_datetime': this.start.format(),
                            'end_datetime': this.end.format(),
                            'room_id': this.resourceId
                        });
                    });

                    $.ajax({
                        type: "POST",
                        url: SITE_URL + 'backadmin/saveevents',
                        data: JSON.stringify(eventsData),
                        beforeSend: function () {
                            openModal();
                        },
                        success: function (response) {
                            closeModal();
                        }
                    });

                }
            }
        },
        eventClick: function(calEvent, jsEvent, view) {
            
            var eventId = calEvent.id;
            
            $("#eventContent").dialog({
                modal: true, 
                title: calEvent.title, 
                width: 580, 
                height: 500,
                resizable: false,
                draggable: false,
                buttons: {
                    DELETE: function () {
                        deleteEvent(eventId);
                    },
                    EDIT: function () {
                        editevent(eventId);
                    }
                }
            });
            
            $.ajax({
                type: "POST",
                url: SITE_URL + 'backadmin/viewevents',
                data: 'eventID='+eventId,
                beforeSend: function () {
                    //openModal();
                    $('#event_view').html($("#loader_view").html());
                },
                success: function (response) {
                    $('#event_view').html(response);
                    //closeModal();
                }
            });
        },
        eventReceive: function (event) { // called when a proper external event is dropped
            console.log('eventReceive', event);
            return false;
        },
        eventDrop: function (event) { // called when an event (already on the calendar) is moved
            console.log('eventDrop', event);
        },
        viewRender: function (view, element) {
            
            var meetingStartDate = $.fullCalendar.moment('2017-01-04');
            var meetingEndDate = $.fullCalendar.moment('2017-01-09');
            
            viewDate = view.start.format();
//            console.log("viewDate is " + viewDate);
            if (view.name === "agendaFourDay") {
                 viewDate = 'all';
                if (!view.start.isSame(meetingStartDate)) { // if schedule start is not 2017-01-05
                    // reset to start date to display 4 days schedule only
                    $('#calendar').fullCalendar('gotoDate', meetingStartDate)
                }

                // hide next/prev button
                $(".fc-center .fc-prev-button, .fc-center .fc-next-button").hide();
                
                //requestAgenda();
                
                // hide unscheduled meetings as we can't assign room number for all dates views
                $("#list-view").hide();
                return true;
            } else {
                $("#list-view").show();
            }
            
            // remove next/prev button (if hide)
            $(".fc-center .fc-prev-button, .fc-center .fc-next-button").show();


            //========= Hide Next/Prev Buttons based on date range
            if (view.end.isSame(meetingEndDate)) {
                $(".fc-next-button").addClass('fc-state-disabled');
            } else {
                $(".fc-next-button").removeClass('fc-state-disabled');
            }

            if (view.start.isSame(meetingStartDate)) {
                $(".fc-prev-button").addClass('fc-state-disabled');
            } else {
                $(".fc-prev-button").removeClass('fc-state-disabled');
            }    
            
            requestAgenda();
        }
    });

}

function requestAgenda(){
    var data = "page=1&date="+viewDate;
                $.ajax({
                    type: "POST",
                    url: SITE_URL + 'backadmin/unschedules',
                    data: data,
                    beforeSend: function () {
                        $("#list-view").html($("#loader_view").html());
                    },
                    success: function (response) {
                        $("#list-view").html(response);
                        setupDraggable();
                    }
                });
}


function requestEventClick(event_id, event_title) {
    
    $("#eventContent").dialog({
                modal: true, 
                title: event_title, 
                width: 580, 
                height: 500,
                resizable: false,
                draggable: false,
                buttons: {
                    DELETE: function () {
                        deleteEvent(event_id);
                    },
                    EDIT: function () {
                        editevent(event_id);
                    }
                }
            });
            
    $.ajax({
                type: "POST",
                url: SITE_URL + 'backadmin/viewevents',
                data: 'eventID='+event_id,
                beforeSend: function () {
                    $('#event_view').html($("#loader_view").html());
                },
                success: function (response) {
                    $('#event_view').html(response);
                }
            });
}
