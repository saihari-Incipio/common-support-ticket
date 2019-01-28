
$(document).ready(function () {
    
    $("img.sorting_arrow").on('click', function () {
        $("img").removeClass('active')
        $(this).addClass('active')
        $.post('get_Projects.php', {sindx: 0, orderby: $(this).attr('sort-data')}, function (data)
        {
            $("thead").nextAll('tbody').remove();
            $("thead").after(data);
        })
    })

    $(document.body).on('change', '[data-filter]', function () {

        //alert("data-filter chage");

        var data = "";
        if (this.id === "pstatus_main") {
            // reselect other filter for mail selectet
            $("select[name='requester_id']").val("");
            $("select[name='project_status']").val("");
            data = 'project_status=' + $(this).val();
        } else {
            data = $("#request_filter").find("select").serialize();
        }

        $.ajax({
            type: "POST",
            url: SITE_URL + 'backadmin/requestfilter/',
            data: data,
            beforeSend: function () {
                $("#request_data_body").html('<tr><td colspan="19" style="text-align: center;"><img src=\'' + SITE_URL_COMMON_MODULE + '/views/common/images/ajax-loader-circle.gif\'/></td></tr>');
            },
            success: function (response) {
                $("#request_data_body").html(response);
            }
        });
    });

    $("#projectselecter").change(function () {
        window.location.href = this.value;
    });

    $(document.body).on('mouseover', '#tableBody', function () {
        $('#tooltip').remove();
    });

    $(document.body).on('mouseover', 'span[content-project-id]', function () {

        var $td = $(this);
        // alert($(this).attr('content-data-date'))
        $.ajax({
            type: "POST",
            url: SITE_URL + "backadmin/getprojectbyid/",
            data: {
                date: $(this).attr('content-data-date'),
                'id': $(this).attr('content-project-id')

            },
            success: function (response) {
                var pos = $td.position();
                $('#tooltip').remove();
                $('<div/>', {html: response, id: 'tooltip'}).css({left: pos.left + 10 + 'px', top: pos.top + 10 + 'px'}).prependTo('body');
            }
        });
    });

    $(document.body).on('click', '#next', function () {

        if (parseInt($('#monthchooser  option:selected').val()) == 11)
        {
            year = parseInt($('#yearChooser').val()) + 1;
            console.log('prev year is' + year)
            $('#yearChooser').val(year);
            //$('#yearChooser option:selected').next('option').attr('selected', 'selected'); 
            value = 0;
        }
        else
            value = parseInt($('#monthchooser  option:selected').val()) + 1;

        $('#monthchooser').val(value);

        //populateTable(document.dateChooser);
    });


    function foobar_cont() {
        // console.log("finished.");
        //populateTable(document.dateChooser);
    }
    ;

    $(document.body).on('click', '#previous', function () {

        if (parseInt($('#monthchooser  option:selected').val()) == 0)
        {
            //alert(parseInt($('#monthchooser  option:selected').val()))
            year = parseInt($('#yearChooser').val()) - 1;
            console.log('prev year is' + year)
            $('#yearChooser').val(year);
            value = 11;
        }
        else
            value = parseInt($('#monthchooser  option:selected').val()) - 1;

        $('#monthchooser').val(value);


        //populateTable(document.dateChooser);
    });


});

function getrecords(txtfield, comboval) {
    $("img").removeClass('active')
    $.post('get_Projects.php', {sindx: 0, txtfield: txtfield, combobox: comboval}, function (data) {
        $("thead").nextAll('tbody').remove();
        $("thead").after(data);
    })
}

function submitfilter(e) {
    if (e.keyCode == 13)
        $("#submit-filter").trigger("click");

}

function changeView(val)
{
    if (val == 'List')
    {
        $("#list-view").show()
        $("#calender-view").hide()
        $('#tooltip').remove();
        $("#center-td").show()
        $("#center-td-cal").hide()
    } else if(val == "schedules") {
        window.location = SITE_URL+'backadmin/schedules';
    } else if(val == "allschedules") {
        window.location = SITE_URL+'backadmin/allschedules';
    } else if(val == "list-view") {
        window.location = SITE_URL+'backadmin';
    }
//    else {
//        //populateTable(document.dateChooser)
//        $("#list-view").hide()
//        $("#calender-view").show()
//        $("#center-td").hide()
//        $("#center-td-cal").show()
//    }
}
