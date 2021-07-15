<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Function to print array
 */

function pre($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}


/**
 * Function to echo database content
 */

 function _e($str){
   $str = encodeSpecialCharacter($str);  
   $str = htmlentities($str);
   $str = decodeSpecialCharacter($str);
   echo $str; 
 }

 /**
 * Function to get echo database content
 */

function _eg($str){
   $str = encodeSpecialCharacter($str);  
   $str = htmlentities($str);
   $str = decodeSpecialCharacter($str);
   return $str; 
  }

/** Special Character Encode */

function encodeSpecialCharacter($str){
	$specialChar = ['&#x20B9;'];
	$index = 1;
	foreach($specialChar as $value){
		$str = str_replace($value, '[special'.$index.']', $str);
	}
	return $str;
}

/** Special Character Encode */

function decodeSpecialCharacter($str){
	$specialChar = ['&#x20B9;'];
	$index = 1;
	foreach($specialChar as $value){
		$str = str_replace('[special'.$index.']',$value , $str);
	}
	return $str;
}


 /**
  * Function to get header script
  */

  function AN_header_script($extra = ''){
    $CI = &get_instance();
    ?>
      <script>
          var an_site_url   = "<?= base_url() ?>";
          var an_csrf_token = "<?= $CI->security->get_csrf_hash(); ?>";
      </script>
    <?php
     echo $extra;
}


  /**
  * Function to get footer script
  */

  function AN_footer_script($extra = ''){
    ?>
         <script>
          <?= $extra; ?>
        </script>

    <?php

  }


  /**Function to send mail */

  function send_mail($to, $subject, $content){

        $CI  = &get_instance();

        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";

        $CI->load->library('email', $config);

        $sender_name = $CI->config->item('email_sender_name');
        $sender_email = $CI->config->item('email_sender_email');
        $CI->email->from($sender_email, $sender_name);
        $CI->email->to($to);

        $CI->email->subject($subject);

        $message = $CI->load->view('email/template-default.php',$content,TRUE);
        $CI->email->message($message);

        $CI->email->send();
  }


/**Function to change Dataformat */

function an_dateformat($datetime = 'Y-m-d H:i:s', $newdatetime = ''){
    $newdatetime = $newdatetime ? $newdatetime : date('Y-m-d');
    $newdatetime = date($datetime, strtotime($newdatetime));
    return $newdatetime;
}


