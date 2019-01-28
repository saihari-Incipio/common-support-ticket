<?php

trait UtilityHtml {

    public static function getProjectStatusHtml($projectStatus) {
        if ($_SESSION['admin_type'] == 'admin') {
            // list valid project status
            $options = ['new', 'open', 'closed', 'reject'];

            // create select html
            $html = '<select name="status">';
            foreach ($options as $option) {
                $selected = ($option == $projectStatus) ? 'selected="selected"' : '';
                $html .= "<option $selected value=\"$option\">$option</option>";
            }
            $html .= '</select>';
        } else {
            // just display project status instead of dropdown
            $html = $projectStatus;
        }

        return $html;
    }

    public static function getDesignersHtml($designers, $designerSelected) {
        $projectDesigners = !empty($designerSelected) ? explode(',', $designerSelected) : array();

        if ($_SESSION['admin_type'] == 'admin') {

            // create multi select dropdown 
            $html = '<select class="dropdown-checklist" name="designers[]" multiple="true">';
            foreach ($designers as $designerId => $designerName) {

                // check option for selected designers
                $optionSelected = in_array($designerId, $projectDesigners) ? 'selected="selected"' : '';
                $html .= "<option $optionSelected value=\"$designerId\">$designerName</option>";
            }
            $html .= '</select>';
        } else {
            $designerNames = [];
            foreach ($designers as $designerId => $designerName) {
                // collect designer names only instead of dropdown
                if (in_array($designerId, $projectDesigners)) {
                    $designerNames[] = $designerName;
                }
            }
            $html = implode(',', $designerNames);
        }

        return $html;
    }

    public static function getDownloadAttachmentHtml($projectId, $attachments) {
        if ($attachments != '') {
            $html = '<a href="' . SITE_URL . MODULE_NAME . '/backadmin/downloadattachements?id=' . base64_encode($projectId) . '">Download</a>';
        } else {
            $html = 'No file attached';
        }
        return $html;
    }

    public static function getDueDateHtml($projectId, $duedate) {
        $expired = (strtotime($duedate) < time()) ? 'expired' : '';
        $duedateText = date("m/d/Y h:i A", strtotime($duedate));

        if ($_SESSION['admin_type'] == 'admin') {
            $html = '<input name="duedate" type="text" class="duedate_datetime ' . $expired . '" style="width:150px;border:0px" id="duedate-' . $projectId . '" value="' . $duedateText . '"/>';
            $html .= '<script> new datepickr("duedate-' . $projectId . '", { dateFormat: "m/d/Y", minDate: 0});</script>';
        } else {
            $html = $duedateText;
        }
        return $html;
    }

    public static function getRequesterText($requesters, $requesterId, $requesterOther) {
        if ($requesterId == '' || $requesterId == 0) {
            return $requesterOther;
        }

        $requesterName = '';
        foreach ($requesters as $requester) {
            if ($requester['requester_id'] == $requesterId) {
                $requesterName = $requester['requester_name'];
            }
        }

        return $requesterName;
    }

    public static function getRevisionNumberText($revisionNumber) {
        return ($revisionNumber != '') ? '-' . $revisionNumber : '';
    }

    public function getPrintButtonHtml($projectId) {
        $projectEncodedId = base64_encode(base64_encode($projectId));
        return '<input type="button" value="Print" onclick="window.open(\'' . SITE_URL . 'backadmin/printproject/?id=' . $projectEncodedId . '\', \'popupWindow\', \'width=1120, height=800, scrollbars=yes\');" />';
    }

    public static function getOptionsHtml(array $options, $userChoise, $selectOption = true) {
        $html = $selectOption ? '<option value="">Select</option>' : '';
        foreach ($options as $option) {
            $selectedAttribute = ($option == $userChoise) ? 'selected="selected"' : '';
            $html .= "<option $selectedAttribute>$option</option>";
        }
        return $html;
    }
    public function getAttachmentPreviewHtml($attachements, $filesize, $id, $key, $type){
        $filesize = round($filesize / 1024, 2) .' KB';
 
    
    $html = '';
//    App::pre($multiplefiles);
     foreach ((array)$attachements as $attachement) {
        $filExt = explode('.', $attachement);
//        print_r($attachement);
//        App::pre(basename($attachement));
        $fileExp = explode('.', basename($attachement));
        $fileNameTrim = substr($fileExp[0], 0, 10).'...'.substr($fileExp[0], -10).'.'.$fileExp[1];
        if(isset($filExt)){
            switch (strtolower(end($filExt))) {
                case 'png' :  
                case 'jpeg' : 
                case 'jpg' :
                    $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/image_icon.png';
                    break;
                case 'pdf' :
                    $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/pdf_icon.png';
                    break;
                case 'zip' :
                    $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/zip_icon.png';
                    break;
                case 'csv' :
                case 'xls' :
                case 'xlsx':
                    $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/excel_icon.png';
                    break;
                case 'doc' :
                    $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/doc_icon.png';
                    break;
                default :
                    $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/Other_files.png';
                    break;
            }
     }else{
          $thumbFilePath = SITE_URL.'views/images/file_type_thumbs/Other_files.png';
     }

     $alertMsg = "'Are you sure you want to delete ?'";
         $html .= '<div class="thumbnail-img-div" style="display: inline-block;padding:20px;" >
             <div class="thumbnail-img-a-div" >
             </div>
                    <div class="thumbnail-img-div-inner" style="">
                        <div class="thumbnail-img-outer-div" > <img class="thumbnail-img"  src="'.$thumbFilePath. '" /></div>
                            <p style="background-color:#333;padding:5px;margin-bottom: 0px;">
<a target="_blank" href="'.SITE_URL.'front/downloadattachments?file='. base64_encode($attachements) .'" title="' .basename($attachement). '" style="color:#fff;" >Download</a>'; 
    
  if($type == 'EDIT'){  
      $html .= '<span><a href="'.SITE_URL.'front/deleteattachment?id='. $id .'&key='.$key.'"  onclick="return confirm('.$alertMsg.');" style="cursor:pointer;"><img src="http://localhost/erp-service/views/images/icons/delete.png" align="right" style="width:15px;height:18px;"/></a></span>';
}    
$html .= '</p>
</div>';
  
       $html .=  '<div style="text-align:left;font-weight:bold; padding:3px;color:#000;"  title="' .basename($attachement). '" > '.$fileNameTrim.'<span style="float:right;">'.$filesize.'</span> </div></div>'; 

     }
         return $html;
                            
    }
}
