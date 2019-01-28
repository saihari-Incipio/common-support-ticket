/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function supportIframe(request_from){
    $("#dashboard_type").val(request_from);
    $("body").css({overflow: 'hidden'});
    $.LoadingOverlay("show");

    $("#support_popup_dialog").dialog({
        height:560,
        width: 700,
        modal: true,
        resizable: false,
        draggable: false,
        open: function(){
        $('body').scrollTop(0);
        $(this).scrollTop(0);
        $('.ui-dialog').css("top","0px");
//        $('#support_iframe')[0].contentWindow.location.reload(true);
        $('#support_iframe').attr("src", $('#support_iframe').attr("src"));
        $("#support_iframe").contents().find('#title').focus();
        $.LoadingOverlay("hide");

        },

        close: function () {
            $("body").css({overflow: 'inherit'});
            //alert('closeed');
        }
       
    });
}