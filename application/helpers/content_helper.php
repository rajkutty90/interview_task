<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(defined('ENVIRONMENT') && ENVIRONMENT == 'development'){
   script_compress();
}


function make_content_insert_array($content_data, $tag, $uid){

    $CI  = &get_instance();
    $CI->load->helper("security");

    $return  = [];

    if($content_data && isset($content_data->hits)){
        foreach($content_data->hits as $key => $value){
            $content_title = $value->title ? $value->title : $value->story_title;
            $return[] = [
                           'user_id'            => $uid,
                           'content_tag'        => $tag,
                           'content_author'     => $CI->security->xss_clean($value->author),
                           'content_title'      => $CI->security->xss_clean($content_title),
                           'content_story_text' => $CI->security->xss_clean($value->story_text)
                        ];
        }
    }

    return $return;

}


function view_content($data){

     $view_content = '';

     if($data){
        $view_content .= '<ul class="nav nav-tabs nav-justified view-content-tab" id="myTab" role="tablist">';

            $index = 0;

            foreach($data as $key => $value){
                 $active = $index == 0 ? 'active' : '';
                 $aria   = $index == 0 ? 'true' : 'false';

                 $view_content .=        '<li class="nav-item">
                                                <a class="nav-link '.$active.'" id="tab-'.$index.'" data-toggle="tab" href="#main-tab-'.$index.'" role="tab" aria-controls="main-tab-'.$index.'" aria-selected="'.$aria.'">'._eg($key).'</a>
                                            </li>';
                 $index++;
            }
                         
                            
            $view_content .=        '</ul>';

            $index = 0;

            $view_content .=        '<div class="tab-content" id="myTabContent">';

            foreach($data as $key => $value){
                $active = $index == 0 ? 'active' : '';

                $view_content .=        '<div class="tab-pane fade show '.$active.'" id="main-tab-'.$index.'" role="tabpanel" aria-labelledby="main-tab-'.$index.'">
                                            <div id="accordion">';
                
                 if($value){
                     $indexL2 = 0;
                     foreach($value as $keyL2 => $valueL2){
                        $collapsed     = $indexL2 == 0 ? '' : 'collapsed'; 
                        $show          = $indexL2 == 0 ? 'show' : ''; 
                        $view_content .= ' <div class="card">
                        <div class="card-header" id="headingOne">
                          <h5 class="mb-0">
                            <a class="btn-link '.$collapsed.'" data-toggle="collapse" data-target="#collapse-'.$indexL2.'" aria-expanded="true" aria-controls="collapseOne">
                              '._eg($valueL2->content_title).'
                            </a>
                          </h5>
                        </div>
                    
                        <div id="collapse-'.$indexL2.'" class="collapse '.$show.'" aria-labelledby="headingOne" data-parent="#accordion">
                          <div class="card-body">
                             <h6>Author:  '._eg($valueL2->content_author).'</h6>
                             <p> '._eg($valueL2->content_story_text).'</p>
                          </div>
                        </div>
                      </div>';
                        $indexL2++;
                     }
                 }
                
                $view_content .=   '</div>
                                        
                                         </div>';
                $index++;
           }

           $view_content .= '</div>';


     }

     return $view_content;

}