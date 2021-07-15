<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Function to check User Logged In or Not
 */

function is_user_logged_in(){
    
    $ci = &get_instance();

    //load the session library
    $ci->load->library('session');

    if($session = $ci->session->userdata('userID')){
  
       $ci->load->model('AN_User'); 
       $userId = $ci->session->userdata('userID');
       $userStatus = $ci->AN_User->getUserDetails(['user_id' => $userId], $ci); 
       if($userStatus[0]->user_status != 'active'){
          $ci->AN_User->logout(); 
         return FALSE;
       } 
       return $ci->session->userdata('userID');

    }

    return FALSE;
}  

/**
 * Get Current Logged In User Details
 */

function getCurrentUser($data = ''){

    if($uId = is_user_logged_in()){

        if(!defined("AN_CURRENT_USER")){
          
            $ci = &get_instance();

            $ci->load->model('AN_User');
            $ci->load->database();

            $results = $ci->AN_User->getUserDetails(['user_id' => $uId], $ci);

            if($results){
                $userDetails  = [
                                   'user_id'          => $results[0]->user_id,
                                   'first_name'       => $results[0]->user_first_name,
                                   'last_name'        => $results[0]->user_last_name,
                                   'email'            => $results[0]->user_email ,
                                   'phone'            => $results[0]->user_phone,
                                   'dob'              => $results[0]->user_dob,
                                   'country'          => $results[0]->user_country,
                                   'subscription'     => explode(',', $results[0]->user_subscription),
                                   'role'             => $results[0]->user_role,
                                   'date'             => $results[0]->user_created_at,
                                   'code'             => $results[0]->user_code,
                                   'status'           => $results[0]->user_status
                                ];
                define("AN_CURRENT_USER", $userDetails);               
            }
        }

        if($data){
           return isset(AN_CURRENT_USER[$data]) ? AN_CURRENT_USER[$data] : '';
        }
        return AN_CURRENT_USER;
    }

    return FALSE;
}



 /**
  * Function to get user details
  */

 function getUserDetails($data){
   
    $ci = &get_instance();

    $ci->load->model('AN_User');
    $ci->load->database();

    $results = $ci->AN_User->getUserDetails($data, $ci);
    
    if($results){
        $userDetails  = [
                            'user_id'          => $results[0]->user_id,
                            'first_name'       => $results[0]->user_first_name,
                            'last_name'        => $results[0]->user_last_name,
                            'email'            => $results[0]->user_email ,
                            'phone'            => $results[0]->user_phone,
                            'dob'              => $results[0]->user_dob,
                            'country'          => $results[0]->user_country,
                            'subscription'     => explode(',', $results[0]->user_subscription),
                            'role'             => $results[0]->user_role,
                            'date'             => $results[0]->user_created_at,
                            'code'             => $results[0]->user_code,
                            'status'           => $results[0]->user_status
                        ];
        return $userDetails;                
    }
    
    return FALSE;
 } 


 /**
  * Funtion to check user logggedin to view the page
  */

  function loginPage($role = ''){
     
    if(!is_user_logged_in()) redirect('');

    if($role){
       if(!in_array(getCurrentUser('role'), $role)){
          redirect(''); 
       }  
    }

  }

   /**
  * Funtion to check if the user logged out to view the page
  */

  function logout_page(){
     if(is_user_logged_in()) redirect('');
  }

 function remove_user_button($user_id){
    return "<button class='btn btn-remove-user btn-ajax-form-btn' data-id='".$user_id."'>Delete</button>";
 }