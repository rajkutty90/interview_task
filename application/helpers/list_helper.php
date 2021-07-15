<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Function to create full table
 * 
 * $tableData          = [
			                    'table'      => $parentsList,
								'labels'     => ['Parent ID', 'Father Name', 'Mother Name', 'Email', 'Phone', 'Hello'],
								'fields'     => ['PID', ['PFFName', 'PFLName'], ['PMFName', 'PMLName'], 'PEmail', 'PPhone', 'Hello'],
								'link'       => 'PFFName',
								'page'       => $pageNo,
								'controller' => $controller,
								'filter'     => ['PPhone' => 'getPhoneStringFormat[PFFName,PFLName,hello]', 'Hello' => fun[PEmail]],
                                'filter_xss' => ['TDocuments'],
								'options'    => [
												'edit_controller' => 'parents/edit-parent',
												'table_id' => 'PID',
												'table' => 'parents'
								                ]
							  ];
 */

function getFullTable($data){

   $emptyMessage = isset($data['empty_message']) ? $data['empty_message'] : 'No Item Found';

   if(!$data['table'] && $data['page'] > 1){ redirect($data['controller']); };

   if(!$data['table']) return '<div class="an-empty-list">'.$emptyMessage.'</div>';

   $thead  = '';

   if($data['labels']){
       $thead .= '<th><input type="checkbox" class="an-list-select-all" id="an-list-select-all"/><label class="stylish" for="an-list-select-all"></label></th>';
       foreach($data['labels'] as $value){
            $thead .= '<th>'.$value.'</th>';
       }   
   }

   $tbody  = getTableBody($data);

   $table  = '<div class="table-responsive"><table class="table an-table an-table-ajax-load an-table-'.$data['options']['table'].'"><thead class="text-primary"><tr>';
   $table .= $thead.'</tr></thead><tbody>';
   $table .= $tbody.'</tbody></table></div>';

   return $table;

}

/**
 * Function to create table body
 */

 function getTableBody($data){
    
    $tbody = '';

    if($data['table']){
        $index = 1;
        foreach($data['table'] as $value){
             $tbodyContent = '';
             $idField      = $data['options']['table_id'];
             $mainId       = $value->$idField;

             if($data['fields']){
                $tbodyContent .= '<td><input type="checkbox" class="an-list-select-item" id="an-list-select-item-'.$index.'" name="items[]" value="'.$mainId.'"/><label class="stylish" for="an-list-select-item-'.$index.'"></label></td>';

                foreach($data['fields'] as $valueL1){

                    $link  = false;
                    
                    if(is_array($valueL1)){
                       $fieldValue = '';
                       foreach($valueL1 as $valueL2){
                         $fieldValue .= $fieldValue ? ' ' : '';
                         if($data['link'] == $valueL2) $link  = true;
                        
                         $filterValue    = isset($value->$valueL2) ? $value->$valueL2 : '';
                         if(isset($data['filter']) && isset($data['filter'][$valueL2])){
                            $filterFunction = is_array($data['filter'][$valueL2]) ? $data['filter'][$valueL2] : [$data['filter'][$valueL2]];
                            foreach($filterFunction as $valueL3){
                                $getFunctionInfo = getFilterFunctionInfo($valueL3);
                
                                if($getFunctionInfo['arg']){
                                    $funArg          = [];
                                    foreach($getFunctionInfo['arg'] as $valueL4){
                                        $funArg[]    = isset($value->$valueL4) ? $value->$valueL4 : $valueL4;
                                    }
                                    $filterValue     = call_user_func_array($getFunctionInfo['function'], $funArg);
                                }else{
                                    $filterValue     = call_user_func($valueL3, $value->$valueL2);
                                }
                               
                            }
                         }else{
                            $fieldValue .= _eg($filterValue);
                         } 
                         
                       }
                    }else{
                       
                        $fieldValue    = isset($value->$valueL1) ? $value->$valueL1 : '';
                        if($data['link'] == $valueL1) $link  = true;
                        if(isset($data['filter']) && isset($data['filter'][$valueL1])){
                            $filterFunction = is_array($data['filter'][$valueL1]) ? $data['filter'][$valueL1] : [$data['filter'][$valueL1]];
                            foreach($filterFunction as $valueL2){

                                $getFunctionInfo = getFilterFunctionInfo($valueL2); 
                
                                if($getFunctionInfo['arg']){
                                    $funArg          = [];
                                    foreach($getFunctionInfo['arg'] as $valueL3){
                                        $funArg[]    = isset($value->$valueL3) ? $value->$valueL3 : $valueL3;
                                    }
                                    
                                    $fieldValue     = call_user_func_array($getFunctionInfo['function'], $funArg);
                                }else{
                                    $fieldValue     = call_user_func($valueL2, $fieldValue);
                                }
                            
                            }
                        }else{
                            $fieldValue = _eg($fieldValue); 
                        }    
                    }

                    
                    
                    if($link){ 
                        $editUrl       = base_url().$data['options']['edit_controller'].'/'.$mainId; 
                        $tbodyContent .= '<td><a href="'.$editUrl.'" class="an-edit-table-item">'.$fieldValue.'</a></td>';
                    }else{
                        $tbodyContent  .= '<td>'.$fieldValue.'</td>'; 
                    }
                } 
             }
             $tbody .= '<tr>'.$tbodyContent.'</tr>';

             $index++;
        }
    }

    return $tbody;
 }

 /**
  * Function to get pagination
  */

function getPagination($totalpage, $currentPage, $controller, $wrap = ''){

      $CI  = &get_instance();

      $sort   = isset($_GET['sort']) ? $CI->input->get('sort', TRUE) : '';
      $order  = isset($_GET['order']) ? $CI->input->get('order', TRUE) : '';
      $search = isset($_GET['s']) ? $CI->input->get('s', TRUE) : '';

      if($totalpage < 2) return '';

      $previous = '<li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                   </li>';
      
      if($currentPage > 1){
        $pageUrl  = isset($_GET['sort']) ?  base_url().$controller.'/page/'.($currentPage - 1).'?sort='.$sort.'&order='.$order : base_url().$controller.'/page/'.($currentPage - 1);
        if(isset($_GET['s'])) $pageUrl = isset($_GET['sort']) ? $pageUrl.'&s='.$search : $pageUrl.'?s='.$search; 
        $previous = '<li class="page-item">
                            <a class="page-link" href="'.$pageUrl.'" tabindex="-1">Previous</a>
                    </li>';
      }

      $next = '<li class="page-item disabled">
                        <a class="page-link" href="#">Next</a>
                    </li>';

      if($currentPage < $totalpage){
        $pageUrl  = isset($_GET['sort']) ?  base_url().$controller.'/page/'.($currentPage + 1).'?sort='.$sort.'&order='.$order : base_url().$controller.'/page/'.($currentPage + 1);  
        if(isset($_GET['s'])) $pageUrl = isset($_GET['sort']) ? $pageUrl.'&s='.$search : $pageUrl.'?s='.$search; 
        $next = '<li class="page-item">
                        <a class="page-link" href="'.$pageUrl.'" tabindex="-1">Next</a>
                    </li>';
      }

      $paginationList = '';

      if($totalpage < 7){
          for($i = 1; $i <= $totalpage; $i++){
              $active = '';
              if($i == $currentPage) $active = "active";
              $pageUrl  = isset($_GET['sort']) ?  base_url().$controller.'/page/'.($i).'?sort='.$sort.'&order='.$order : base_url().$controller.'/page/'.($i);  
              if(isset($_GET['s'])) $pageUrl = isset($_GET['sort']) ? $pageUrl.'&s='.$search : $pageUrl.'?s='.$search; 
              $paginationList .= '<li class="page-item '.$active.'"><a class="page-link" href="'.$pageUrl.'">'.$i.'</a></li>';
          }
      }else{

        $active = '';
        if($currentPage == 1) $active = 'active';
        $pageUrl         = isset($_GET['sort']) ?  base_url().$controller.'/page/1?sort='.$sort.'&order='.$order : base_url().$controller.'/page/1';  
        if(isset($_GET['s'])) $pageUrl = isset($_GET['sort']) ? $pageUrl.'&s='.$search : $pageUrl.'?s='.$search; 
        $paginationList .= '<li class="page-item '.$active.'"><a class="page-link" href="'.$pageUrl.'">1</a></li>';
        
        $start  = $currentPage - 1;
        $end    = $currentPage + 1;
        $dots   = true;
        $dote   = true;

        if($start < 3) {
            $start = 2;
            $end   = 5;
            $dots  = false;
        }

        if(($start + 3) > $totalpage){
            $start = $totalpage - 4;
            $end   = $totalpage;
            $dote   = false;
        }

        if($dots){
            $paginationList .= '<li class="page-item"><a class="page-link" href="#">...</a></li>'; 
        }

        for($i = $start; $i < $end + 1; $i++){
            
            $active = '';
            if($i == $currentPage) $active = "active";
     
            if($i > 1 && $i < $totalpage){
                $pageUrl         = isset($_GET['sort']) ?  base_url().$controller.'/page/'.($i).'?sort='.$sort.'&order='.$order : base_url().$controller.'/page/'.($i).'';  
                if(isset($_GET['s'])) $pageUrl = isset($_GET['sort']) ? $pageUrl.'&s='.$search : $pageUrl.'?s='.$search; 
                $paginationList .= '<li class="page-item '.$active.'"><a class="page-link" href="'.$pageUrl.'">'.$i.'</a></li>'; 
            }

        }

        if($dote){
            $paginationList .= '<li class="page-item"><a class="page-link" href="#">...</a></li>'; 
        }
        
        $active = '';
        if($currentPage == $totalpage) $active = 'active';
        $pageUrl         = isset($_GET['sort']) ?  base_url().$controller.'/page/'.($totalpage).'?sort='.$sort.'&order='.$order : base_url().$controller.'/page/'.($totalpage).'';  
        if(isset($_GET['s'])) $pageUrl = isset($_GET['sort']) ? $pageUrl.'&s='.$search : $pageUrl.'?s='.$search; 
        $paginationList .= '<li class="page-item '.$active.'"><a class="page-link" href="'.base_url().$controller.'/page/'.$totalpage.'">'.$totalpage.'</a></li>';

      }

      $paginationContent = '<nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    '.$previous.'
                                    '.$paginationList.'
                                    '.$next.'
                                </ul>
                                </nav>';

      $pagination = $paginationContent;
      if($wrap){
        $pagination = $wrap['start'].$paginationContent.$wrap['end'];
      }

      return $pagination;
}

/**
 * Function to get sorted
 */


function sortListItem($data){
    $CI       = &get_instance();
    $sortList['desktop'] = '';
    $sortList['mobile']  = '';
    if($data['sort']){
    $label      = isset($data['label']) ? '--Sort '.$data['label'].'--' : '--Sort List--';  
    $url        = getSortUrl($data['urlContent']);
    $sortList['desktop']  .= '<div class="form-group"><select class="form-control an-list-sort stylish-select"><option value="'.$url.'">'.$label.'</option>';
    $sortList['mobile']   .= '<div class="form-group"><select class="form-control an-list-sort stylish-select-filter-pop-up" data-parant="an-list-filter-pop-up"><option value="'.$url.'">'.$label.'</option>';
    foreach($data['sort'] as $value){
       
        $ascSelect  = '';
        $descSelect = '';

        if(isset($_GET['sort'],$_GET['order'])){
            if($_GET['sort'] == $value && $_GET['order'] == 'ASC') $ascSelect = 'selected';
            if($_GET['sort'] == $value && $_GET['order'] == 'DESC') $descSelect = 'selected';
        }  

        $url        = getSortUrl($data['urlContent'], $value, 'ASC');
        $sortList['desktop']  .= '<option value="'.$url.'" '.$ascSelect.'>'.$value.' ASC</option>';
        $sortList['mobile']   .= '<option value="'.$url.'" '.$ascSelect.'>'.$value.' ASC</option>';
        $url        = getSortUrl($data['urlContent'], $value, 'DESC');
        $sortList['desktop']  .= '<option value="'.$url.'" '.$descSelect.'>'.$value.' DESC</option>';
        $sortList['mobile']   .= '<option value="'.$url.'" '.$descSelect.'>'.$value.' DESC</option>';
    }
    
    $sortList['desktop']  .= '</select></div>';
    $sortList['mobile']   .= '</select></div>';
    }
    return $sortList;
}

/**
 * Function to form sort url
 */

 function getSortUrl($data, $sort = '', $order = ''){
      $currentUrl   = AN_GetUrl();
      $currentQuery = $data;
      if(!$sort && !$order){
        $currentQuery['order'] = [];
      }else{
        $currentQuery['order'] = ['sort' => $sort, 'order' => $order];
      }
      $newUrl = makeQueryURL($currentQuery);
      return $currentUrl['mainUrl'].$newUrl;
 }

 
/**
 * Function to get role list
 */

function filterListItem($data){
    $CI       = &get_instance();
    $filterList['desktop'] = '';
    $filterList['mobile'] = '';
    if($data['filterItems']){
        $label      = isset($data['label']) ? '--'.$data['label'].'--' : '--Filter '.$data['slug'].'--'; 
        $tempUrlContent =  $data['urlContent'];
        unset($tempUrlContent['filter'][$data['slug']]);
        $url        = getFilterUrl($tempUrlContent);
        $filterList['desktop']  .= '<div class="form-group"><select class="form-control an-list-filter stylish-select"><option value="'.$url.'">'.$label.'</option>';
        $filterList['mobile']   .= '<div class="form-group"><select class="form-control an-list-filter stylish-select-filter-pop-up" data-parant="an-list-filter-pop-up"><option value="'.$url.'">'.$label.'</option>';
        
        foreach($data['filterItems'] as $value){
            $selected   = '';
            $slug_value = is_array($value) ? $value['id'] : $value;
            if(isset($_GET[$data['slug']]) && $_GET[$data['slug']] == $slug_value){
                $selected       =  'selected';
            }
            $tempUrlContent =  $data['urlContent'];
            $tempUrlContent['filter'][$data['slug']] = is_array($value) ? $value['id'] : $value;
           
            $url            = getFilterUrl($tempUrlContent);
            $name           = is_array($value) ? $value['name'] : $value;
            $filterList['desktop']  .= '<option value="'.$url.'" '.$selected.'>'.$name.'</option>';  
            $filterList['mobile']   .= '<option value="'.$url.'" '.$selected.'>'.$name.'</option>';     
        }
        
        $filterList['desktop']  .= '</select></div>';
        $filterList['mobile']   .= '</select></div>';
    }
    return $filterList;
}

/**
 * Function to form role url
 */

function getFilterUrl($data){
    $currentUrl   = AN_GetUrl();
    $currentQuery = $data;
    $newUrl = makeQueryURL($currentQuery);
    return $currentUrl['mainUrl'].$newUrl;
}


/**
  * function to make new query url
  */

function makeQueryURL($queryData){

    $queryString = '';

    if($queryData['s']){
        $queryString = '?s='.urlencode($queryData['s']);
    }

    if(!empty($queryData['filter'])){
        foreach($queryData['filter'] as $key => $value){
            $queryString .=  $queryString ? '&'.urlencode($key).'='.urlencode($value) : '?'.urlencode($key).'='.urlencode($value);
        }
    }

    if(!empty($queryData['order'])){
        $queryString .=  $queryString ? '&sort='.urlencode($queryData['order']['sort']).'&order='.urlencode($queryData['order']['order']) : '?sort='.urlencode($queryData['order']['sort']).'&order='.urlencode($queryData['order']['order']);
    }

    return $queryString;

}



/**
* Function to get main filter list
*/

function statusListItem($controller, $currentStatus, $status){
    
    $active       = $currentStatus == 'all' ? 'class="active"' : '';
    $url          = base_url().$controller;
    $statusReturn = '<ul class="an-filter-status"><li '.$active.'><a href="'.$url.'">All</a></li>';
    
    if($status){
        foreach($status as $value){
            $active        = $currentStatus == $value ? 'class="active"' : '';
            $url           = base_url().$controller.'/'.$value;
            $statusReturn .= '<li '.$active.'><a href="'.$url.'">'.$value.'</a></li>'; 
        }
    }

    $statusReturn .= '</ul>';

    return $statusReturn;

}


/**
 * Function to get search Form
 */

function searchListItem($controller, $name = 'Item', $urlContent){

    $CI         = &get_instance();
    $action     = base_url().$controller;

    $hiddenFields = '';
    if(!empty($urlContent['order'])){
        $hiddenFields  .= '<input type="hidden" name="sort" value="'.$urlContent['order']['sort'].'"/>';
        $hiddenFields  .= '<input type="hidden" name="order" value="'.$urlContent['order']['order'].'"/>';
    }
    if(!empty($urlContent['filter'])){
         foreach($urlContent['filter'] as $key => $value){
            $hiddenFields  .= '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';
         }
    }

    $value      = isset($_GET['s']) ? $CI->input->get('s', TRUE) : ''; 

    $searchForm['desktop'] = '<form action="'.$action.'" class="an-list-search-form"><div class="input-group no-border">
                                <input type="text" name="s" class="form-control" placeholder="Search..." value="'.$value.'">
                                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                                </button>
                            </div></form>';

    $searchForm['mobile'] = '<form action="'.$action.'" class="an-list-search-form">
                                <input type="text" name="s" class="form-control" value="'.$value.'" placeholder="Search...">
                                '.$hiddenFields.'
                                <input type="image" src="'.base_url().'assets/images/search.svg" alt="Submit" class="form-submit-image">
                                </form>';                
    return $searchForm;    

} 

/**
 * Function to get Filter Array
 */

function getFilterArray($filter){
    $filterData = []; 
    if(isset($_GET) && $filter){
        foreach($_GET as $key => $value){
            $index = array_search($key, $filter['label']);
            if(in_array($key, $filter['label']) && $index >= 0){
                $filter['tableField'][$index];
                $filterData[$key] = $filter['tableField'][$index];
            }
        }
    }
    return $filterData;
}

/**
 * functtion to get url array
 */

 function getUrlArray($filter){
     
     $urlArray['order']   = [];
     $urlArray['s']       = '';
     $urlArray['filter']  = [];

     if(isset($_GET['s'])) $urlArray['s'] = $_GET['s'];
     if(isset($_GET['order'], $_GET['sort'])) $urlArray['order'] = ['sort' => $_GET['sort'], 'order' => $_GET['order']];
 
     if(isset($_GET) && $filter){
        foreach($_GET as $key => $value){
            $index = array_search($key, $filter['label']);
            if(in_array($key, $filter['label']) && $index >= 0){
                $filter['tableField'][$index];
                $urlArray['filter'][$key] = $value;
            }
        }
     }

     return $urlArray;
}

/**
 * Function to make bulk action
 */

 function bulkActionItem($action, $status, $newStatus = '', $defaultStatus = ['active', 'inactive']){

     $CI = &get_instance();
     $CI->load->helper('form');

     $bulkActionOptions = '';
     $bulkActionOptionsArray = $defaultStatus;
     if($newStatus) $bulkActionOptionsArray = array_merge($bulkActionOptionsArray, $newStatus);
     $bulkActionOptionsArray = array_merge($bulkActionOptionsArray, ['trash']);

     foreach($bulkActionOptionsArray as $value){
        if($status != $value) $bulkActionOptions .= '<option value="'.$value.'">'.$value.'</option>';
     }
     
     if($status == 'trash') $bulkActionOptions .= '<option value="clear">Clear</option>';

     $attributes  = array('class' => 'an-bulk-action-form');
     $formopen    = form_open($action, $attributes);
     $current_url = AN_GetUrl();

     $bulkAction['desktop'] = $formopen .'
                       <div class="form-group">
                       <select class="form-control an-bulk-action-select stylish-select" name="an-bulk-action">
                         <option value="">Bulk Action</option>
                         '.$bulkActionOptions.'
                       </select>
                       </div>
                       <div class="an-selected-item-list"></div>
                       <input type="hidden" name="backto" value="'.$current_url['fullUrl'].'"/>
                       <input type="submit" class="btn btn-default an-btn-bulk-action" value="Apply"/>
                     </form>
                   ';
     
    $bulkAction['mobile'] = $formopen .'
                   <div class="form-group">
                   <select class="form-control an-bulk-action-select stylish-select-filter-pop-up" data-parant="an-list-filter-pop-up" name="an-bulk-action">
                     <option value="">Bulk Action</option>
                     '.$bulkActionOptions.'
                   </select>
                   </div>
                   <div class="an-selected-item-list"></div>
                   <input type="hidden" name="backto" value="'.$current_url['fullUrl'].'"/>
                   <input type="submit" class="btn btn-default an-btn-bulk-action" value="Apply"/>
                 </form>
               ';              
                   
      return $bulkAction;             
 }

  /**Function to get List User Thumb */

  function getListUserThumb($mid, $f_name, $l_name){

    $thumb = base_url().'assets/images/avatar.jpg';
    if($mid > 0){

        $CI = &get_instance();
        $CI->load->helper('an_file');
    
        $mediaDetails = getMediaDetails($mid);
        if($mediaDetails) $thumb = $mediaDetails['thumb']['50x50'];
    }

    return '<div class="list-profile-name-wrap"><img src="'.$thumb.'" class="list-image"><div class="label">'._eg($f_name).' '._eg($l_name).'</div></div>';

 }

 function getFilterFunctionInfo($fun){
     $explodeFun = explode('[', $fun);

     if(!isset($explodeFun[1])){
         return ['function' => $fun, 'arg' => ''];
     }

     $fun        = $explodeFun[0];
     $explodeFun = explode(']', $explodeFun[1]);

     $explodeFun = explode(',', $explodeFun[0]);

     return ['function' => $fun, 'arg' => $explodeFun];
 }

 function getCurrencyAdded($data){
     return '<i class="material-icons content-icon dollor">attach_money</i>'.number_format($data, 2);
 }