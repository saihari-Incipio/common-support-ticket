
<!-- Defined here to avoid conflict with calender page -->
<script type="text/javascript"> 
$(document.body).on('click', 'a.pagelink.inactive', function () {
    var data = "page=" + $(this).attr('pgcount') + "&" + $("#request_filter").find("select").serialize();
    $.ajax({
        type: "POST",
        url: SITE_URL + 'backadmin/requestfilter/',
        data: data,
        beforeSend: function () {
            $("#request_data_body").html('<tr><td colspan="19" style="text-align: center;"><img src=\'' + SITE_URL + 'views/images/ajax-loader-circle.gif\'/></td></tr>');
        },
        success: function (response) {
            $("#request_data_body").html(response);
        }
    });
});
</script>

<style type="text/css">
    .bkadmin-table-main {
        display: none;
    }
</style>

<div id="list-views" style="padding-top:15px;">

    <table id="tablesorter" class="tablesorter">
        <thead style="color: #231600;">
            <tr id="request_filter">
                <th width="3%"> SNo </th>
                <th>Requester's full name  </th>
                <th>Email address</th>
                <th>Phone number</th>
                <th>Request Type</th>
                <th>Date of meeting</th>         
                <th>Time of meeting</th>
                <th>No. of people in meeting (total)</th>
                <th>Customer(s)</th>
                <th>Comments Field</th>             
            </tr>
        </thead>
        <tbody id="request_data_body">
            <?php include dirname(__FILE__) . '/requestfilter.php'; ?>
        </tbody>
    </table>

</div>



