<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(defined('ENVIRONMENT') && ENVIRONMENT == 'development'){
   script_compress();
}



function script_compress(){

    $skip_files     = [];
    $ds             = DIRECTORY_SEPARATOR;
    $ouput          = FCPATH.'assets'.$ds.'js'.$ds.'main_script.js';
    $input          = FCPATH.$ds.'assets'.$ds.'js'.$ds.'script';
    $script_content = list_folder_files($input, $skip_files);
    $script_content = read_files($script_content);
    write_files($script_content, $ouput);

}


  
function list_folder_files($dir, $skip_files){
  
    static $files_list = [];
    $ds        = DIRECTORY_SEPARATOR;
  
    $ffs = scandir($dir);
  
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);
  
    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;
  
    
    foreach($ffs as $ff){
      if(is_dir($dir.$ds.$ff)){
        list_folder_files($dir.$ds.$ff, $skip_files);
      }else{
        if(!in_array($ff,$skip_files)){
           $files_list[] =  $dir.$ds.$ff;
        }  
      }
    }
  
    return $files_list;
  }
  
  
  function read_files($files){
     static $file_contents = '';
     if(is_array($files)){
       foreach($files as $res){
        read_files($res);
       }
     }else{
        $file          = fopen($files,'r');
        if(filesize($files) > 0){
          $file_contents .= fread($file, filesize($files)).PHP_EOL.PHP_EOL;
        }
        fclose($file);
     }
     return $file_contents;
  }
  
  function write_files($script_content, $ouput){
       $file  = fopen($ouput,'w');
       fwrite($file, $script_content);
       fclose($file);
  }