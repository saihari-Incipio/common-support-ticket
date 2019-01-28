<?php

class Utility {
    const DATE_DISPLAY_FORMATE = 'm/d/Y';
    const DATE_TIME_DISPLAY_FORMATE = 'm/d/Y h:i:s A';
    const DATE_MONTH_TIME_DISPLAY_FORMATE = 'm/d h:i A';
    const REQ_SITE_ROOT = '';
    
    public static function getStatusUpdateOptions($currentStatus) {
        $options = '';
//        switch ($currentStatus) {
//            case 'NEW' : // 'Active' and 'Reject' options for status 'New'
//                $options .= '<option value="ACTIVE">Active</option>';
//                $options .= '<option value="REJECTED">Reject</option>';
//                break;
//            case 'ACTIVE' : // Only 'Complete' option for status 'Active'
//                $options .= '<option value="COMPLETED">Complete</option>';
//                break;
//            default : // No options for completed and rejected request
//                break;
//        }

        $projectStatus = array('NEW' => 'New', 'ACTIVE' => 'Active', 'REJECTED' => 'Rejected', 'COMPLETED' => 'Completed');
        foreach ($projectStatus as $key => $value) {
            $selected = ($key == $currentStatus) ? 'selected="selected"' : '';
            $options .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }

        return $options;
    }

    public static function getPagination($totalRecord, $recordParPage, $currentPage = 1) {

        $totalPage = ceil($totalRecord / $recordParPage);

        $pagination = '';
        if ($totalPage > 1) {
            $pagination = '<tr><td colspan="19" align="right">';
            for ($i = 1; $i <= $totalPage; $i++) {
                $activeStatus = ($currentPage == $i) ? 'active' : 'inactive';
                $pagination .= "<a pgcount=$i class='pagelink $activeStatus'>$i</a> &nbsp;";
            }
            $pagination .= '</td></tr>';
        }
        return $pagination;
    }

    public static function getPSTCurrentTime() {
        $dateTime = new DateTime(null, (new DateTimeZone('UTC')));  // get current time as UTC/GMT timezone
        $dateTime->setTimezone(new DateTimeZone('PST'));            // convert time as PST timezone
        return $dateTime;
    }
    
     public static function getFormatedDate($date, $format = null) {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return '';
        }

        if (empty($format)) {
            // check whether time included to date i.e. YYYY-MM-DD => string length 10
            $format = (strlen($date) == 10) ? self::DATE_DISPLAY_FORMATE : self::DATE_TIME_DISPLAY_FORMATE;
        }

        return date($format, strtotime($date));
    }
    
     public static function getValidUploadedFileName($filename){
        
        $uniquePrefix = time() .'_'. rand(10000, 99999);
        
        $validFilename = preg_replace("/[^A-Za-z0-9.]/", '', $filename);
        $correctedLengthFilename = strlen($validFilename) > 50 ? substr($validFilename, -50) : $validFilename;

        return $uniquePrefix.'_'.$correctedLengthFilename;
    }
    
    public function arrayColumnFind($array,$colname,$Indexkey=''){
    if(!function_exists('array_column')){
    $return_array = array();
    if(is_array($array) || is_object($array)){
      foreach($array as $arrayDATA){
        if(is_object($arrayDATA)){
          if(isset($arrayDATA->{$colname})){
            if(isset($Indexkey) && isset($arrayDATA->{$Indexkey}) ){
              $return_array[$arrayDATA->{$Indexkey}] = $arrayDATA->{$colname};
            } else {
              $return_array[] = $arrayDATA->{$colname};
            }
          }
        } else if(is_array($arrayDATA)) {
          if(isset($arrayDATA[$colname])){
            if(isset($Indexkey) && isset($arrayDATA[$Indexkey]) ){
              $return_array[$arrayDATA[$Indexkey]] = $arrayDATA[$colname];  
            } else {
              $return_array[] = $arrayDATA[$colname]; 
            } 
          } 
        }     
      }
    } 
    return $return_array;

    }else{
       return array_column($return_array, $column_key);
    }
}
    

    public static function havingAboveAmountThreshold ($poDetails) {
        $amount = str_replace(['$', ','], '', $poDetails['amount']);
        return ($amount > 5000);
    }
    
         public function getConvertTimeToPst($date){
        $dateTime = new \DateTime($date, (new \DateTimeZone('UTC')));  // get current time as UTC/GMT timezone
        $dateTime->setTimezone(new \DateTimeZone('PST'));  
        return $dateTime;
    }
    
public function getTicketAttachmentPreview($attachements, $filesize, $id, $key, $type, $proj_jira_code){
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
<a target="_blank" href="'.SITE_URL.'support/downloadJiraAttachments?proj_jira_code='.$proj_jira_code.'&file='. base64_encode($attachements) .'" title="' .basename($attachement). '" style="color:#fff;" >Download</a>'; 
    
   
$html .= '</p>
</div>';
  
       $html .=  '<div style="text-align:left;font-weight:bold; padding:3px;color:#000;"  title="' .basename($attachement). '" > '.$fileNameTrim.'<span style="float:right;">'.$filesize.'</span> </div></div>'; 

     }
         return $html;
                            
    }
    
    
}
