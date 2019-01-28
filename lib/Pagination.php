<?php

class Pagination {
    
    public static function getHtml($recordsPerPage = RECORDS_PER_PAGE) {
        
        $currentPage = self::currentPage();
        $totalPage = ceil(Model::totalRecordCount()/$recordsPerPage);
//        
//        $pagination = '';
//        if($totalPage > 1) {
//            $pagination = '<tr><td colspan="19" style="text-align: right;">';
//            for($i=1; $i <= $totalPage; $i++) {
//                $activeStatus = ($currentPage == $i) ? 'active' : 'inactive';
//                $pagination .= "<a pgcount=$i class='pagelink $activeStatus'>$i</a> &nbsp;";
//            }
//            $pagination .= '</td></tr>';
//        }
//        return $pagination;
        
//        $totalPage = ceil($totalRecord / $recordParPage);

        $pagination = '';
        if ($totalPage > 1) {
            $pagination = '<tr><td colspan="19" align="right" style="text-align: center;" >';
	    
	    $startRange = ($currentPage - 5);
	    $endRange = ($currentPage + 5);   
	    
	    for ($pageNumber = 1; $pageNumber <= $totalPage; $pageNumber++) {
                $activeStatus = ($currentPage == $pageNumber) ? 'active' : 'inactive';

                // check whether this page number is first two or last two pages
                $isFirstAndLastPages = in_array($pageNumber, [1, 2, ($totalPage - 1), $totalPage]);
                
                // check whether this page number is under range
                $isUnderRange = (($pageNumber >= $startRange) && ($pageNumber <= $endRange));
                
                // check whether need separator 
                $isSeparator = in_array($pageNumber, [3, ($totalPage - 2)]);
                
                // display page for first 2
                if($isFirstAndLastPages || $isUnderRange) {
                    $pagination .= "<a pgcount=$pageNumber class='pagelink $activeStatus'>$pageNumber</a> &nbsp;";
                } else if($isSeparator) {
                    $pagination .= '&nbsp...&nbsp';
                }
            }
            $pagination .= '</td></tr>';
        }
        return $pagination;
    }
    
    public static function currentPage() {
        return ((isset($_REQUEST['page'])) && $_REQUEST['page'] != '') ? $_REQUEST['page'] : 1;
    }
    
    public static function getStartSerialNumber() {
        return ((self::currentPage()-1) * RECORDS_PER_PAGE) + 1;
    }
}
