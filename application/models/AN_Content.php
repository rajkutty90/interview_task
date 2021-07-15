<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AN_Content extends CI_Model 
{
     /**
      * Get Content
      */

      function get_content($condition = '', $ci =''){

        $ci = $ci ? $ci : $this;
    
        $ci->load->database();
        
        if($condition) $ci->db->where($condition);
        $query      = $ci->db->get('an_content');
        $result     = $query->result();

        return $result;

     }

     /**
      * Get user content
      */

      function get_user_content($user_id){

        $ci = $this;
    
        $ci->load->database();

        $return_data = [];

        $user_subscriptions = getCurrentUser('subscription');

        if($user_subscriptions){
          foreach($user_subscriptions as $key => $value){
             $content = $this->get_content(['user_id' => $user_id, 'content_tag' => $value]);
             $return_data[$value] = $content;
          }
        }
        
        return $return_data;

     }

}