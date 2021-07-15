<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AN_User extends CI_Model 
{

    /**
     * User Objects
     */

     private $defaultUserRole   = 'user';
    
    /**
     * Function to register user 
     */

     public function add_user($data){

          $this->load->model(['AN_Encrypt','AN_Curl']);
          $this->load->helper('content');

          $password   = $this->AN_Encrypt->cryptPass($data['password']);

          $userRole   = isset($data['role']) ? $data['role'] : $this->defaultUserRole; 
          $userStatus = 'inactive';
          $date       = date('Y-m-d H:i:s');

          $insert_data = array(
                                'user_first_name'      => $data['first_name'],
                                'user_last_name'       => $data['last_name'],
                                'user_email'           => $data['email'],
                                'user_phone'           => $data['phone'],
                                'user_dob'             => $data['dob'],
                                'user_country'         => 'UK',
                                'user_subscription'    =>  implode(',', $data['subscription']),
                                'user_password'        => $password,
                                'user_created_at'      => $date,
                                'user_updated_at'      => $date,
                                'user_role'            => $userRole,
                                'user_status'          => $userStatus
                          );

         $email  =   $data['email'];
         $name   = $data['first_name'] . ' ' . $data['last_name'];

         $register_status = FALSE;                 

         $this->db->trans_start();

         $insert_data = $this->db->insert('an_user', $insert_data);

         if($insert_data){
            $uId    = $this->db->insert_id();
            $uCode  = $this->AN_Encrypt->generateUniqueCode($uId);

            $this->db->set('user_code', $uCode);
            $this->db->where('user_id', $uId);
            $this->db->update('an_user');

            if($data['subscription']){
              foreach($data['subscription'] as $key => $value){
                $this->AN_Curl->server_url = 'http://hn.algolia.com/api/v1/search_by_date?tags='.$value.'&page=1&hitsPerPage=10';
                $this->AN_Curl->execute();
                $content = make_content_insert_array($this->AN_Curl->result, $value, $uId);
                $this->db->insert_batch('an_content', $content); 
              }
            }    
            
         }

         $this->db->trans_complete();

          if ($this->db->trans_status() !== FALSE) {
            $register_status = TRUE;
          } 

         if($register_status){

           $url  = base_url().'register/activate?u='.$uCode;

            $data = [
                'title' => 'Hello '.$name,
                'content' => 'Thank you for registration, please activate your account',
                'button' => ['label' => 'Activate', 'link' => $url]
              ];

            send_mail($email, 'Activate Account', $data);
         }

         return $register_status;
     }

     


     /**
     * Function to update user 
     */

    public function update_user($data, $user_id){

      $this->load->model(['AN_Encrypt','AN_Curl']);
      $this->load->helper('content');

      $password   = $data['password'] ? $this->AN_Encrypt->cryptPass($data['password']) : '';

      $userRole   = isset($data['role']) ? $data['role'] : $this->defaultUserRole; 
      $userStatus = 'inactive';
      $date       = date('Y-m-d H:i:s');

      $update_data = array(
                            'user_first_name'      => $data['first_name'],
                            'user_last_name'       => $data['last_name'],
                            'user_email'           => $data['email'],
                            'user_phone'           => $data['phone'],
                            'user_dob'             => $data['dob'],
                            'user_country'         => 'UK',
                            'user_subscription'    =>  implode(',', $data['subscription']),
                            'user_updated_at'      => $date,
                            'user_role'            => $userRole
                      );
      if($password){
        $update_data['user_password'] = $password;
      }                


     $update_status = FALSE;                 

     $this->db->trans_start();

     $update_data = $this->updateUser($update_data, ['user_id' => $user_id]);

     if($update_data){

      $delete_user_id = $this->db->escape($user_id);
      $sql = "DELETE FROM an_content WHERE user_id=$delete_user_id";
      $this->db->query($sql);

        if($data['subscription']){
          foreach($data['subscription'] as $key => $value){
            $this->AN_Curl->server_url = 'http://hn.algolia.com/api/v1/search_by_date?tags='.$value.'&page=1&hitsPerPage=10';
            $this->AN_Curl->execute();
            $content = make_content_insert_array($this->AN_Curl->result, $value, $user_id);
            $this->db->insert_batch('an_content', $content); 
          }
        }    
        
     }

     $this->db->trans_complete();

      if ($this->db->trans_status() !== FALSE) {
        $update_status = TRUE;
      } 


     return $update_status;
   }


    /**
    * Function to update user details
    */

    public function updateUser($data, $where){
        $this->db->set($data);
        $this->db->where($where);
        $this->db->update('an_user');
        return TRUE;
    }


     /**
      * Function to check valid user
      */

      public function validUser($uid){

        $this->db->where(['UID' => $uid]);
        $query      = $this->db->get('an_user');
        $result     = $query->result();

        if($result) return TRUE;
        return FALSE;
      }

       /**
      * Function to check unique email
      */

      public function unique_email($email, $uid = 0){

        if($uid > 0){
          $this->db->where(['user_id !=' => $uid, 'user_email' => $email]);
        }else{
          $this->db->where(['user_email' => $email]);
        }
        $query      = $this->db->get('an_user');
        $result     = $query->result();

        if($result) return FALSE;
        return TRUE;
      }

       /**
      * Function to check unique phone
      */

      public function unique_phone($phone, $uid = 0){

        if($uid > 0){
          $this->db->where(['user_id !=' => $uid, 'user_phone' => $phone]);
        }else{
          $this->db->where(['user_phone' => $phone]);
        }
        $query      = $this->db->get('an_user');
        $result     = $query->result();

        if($result) return FALSE;
        return TRUE;
      }

     /**
      * Fuuction to to authentication
      */

      public function authenticationCheck($data){

          $this->load->model('AN_Encrypt');

          $password   = $data['password']; 
          $email      = $data['email'];

          $this->db->where(['user_email' => $email]);
          $query      = $this->db->get('an_user');
          $result     = $query->result();

          if($result){

            $oPassword = $result[0]->user_password;
            if($this->AN_Encrypt->check_password($password, $oPassword)){
                $this->updateUser(['user_login_attempt' => 0, 'user_last_login_attempt' => date('Y-m-d h:i:s')], ['user_id' => $result[0]->user_id]);
                return $result;
            } 
     
          } 
  
          return FALSE;

      }

      /**
       * Function to check wherther login blocked or not
       */

       public function check_account_locked($email){

        $CI  = &get_instance();

        if($CI->config->item('login_restrict')){

          $this->db->where(['user_email ' => $email]);
          $query      = $this->db->get('an_user');
          $result     = $query->result();

          if($result){
            $account_locked    = false;
            $last_login        = an_dateformat('d-m-Y H:i:s', $result[0]->user_last_login_attempt);
            $last_login        = strtotime($last_login);
            $last_login        = $last_login + ($CI->config->item('login_restrict_minutes') * 60);
            $now               = strtotime(date('d-m-Y H:i:s'));
            if($now  < $last_login && $CI->config->item('login_max_attempt') <= $result[0]->user_login_attempt){
              $account_locked = true;
            }
            
            if($result[0]->user_login_attempt == 0){
              $this->updateUser(['user_login_attempt' => 1, 'user_last_login_attempt' => date('Y-m-d H:i:s')], ['user_id' => $result[0]->user_id]);
            }else{
              $this->updateUser(['user_login_attempt' => $result[0]->user_login_attempt + 1], ['user_id' => $result[0]->user_id]);
            }
           
            if($now  > $last_login){
              $this->updateUser(['user_login_attempt' => 1, 'user_last_login_attempt' => date('Y-m-d H:i:s')], ['user_id' => $result[0]->user_id]);
            }
            
            return $account_locked;
          }

        }

        return false;
       }

      /**
       * Function to login
       */

      public function login($data){

          $userData = ["userID" => $data[0]->user_id];
          $this->session->set_userdata($userData);

          $now = date('Y-m-d H:i:s');
          $this->updateUser(['user_login_attempt' => 0, 'user_last_login_attempt' => $now], ['user_id' => $data[0]->user_id]);

          return TRUE;
      } 


      /**
       * Function to logout
       */
     
      public function logout(){

          $this->session->unset_userdata('userID');

          return TRUE;
      }  

        /**
        * Function to update password
        */

        public function updatePassword($data){
            
            $userDetails = getUserDetails(['UCode' => $data['ucode'], 'UPCRActive' => '1']);
            if(!$userDetails) return FALSE;

            $this->load->model('AN_Encrypt');

            $password = $this->AN_Encrypt->cryptPass($data['password']);

            $this->updateUser(['UPassword' => $password, 'UPCRActive' => '0'], ['UCode' => $data['ucode']]);

            return TRUE;

        }

      /**
       * Function to get User details
       */

       public function getUserDetails($condition = '', $ci =''){

          $ci = $ci ? $ci : $this;
		  
		      $ci->load->database();
          
          if($condition) $ci->db->where($condition);
          $query      = $ci->db->get('an_user');
          $result     = $query->result();

          return $result;

       }

       /**
        * Function to activate user account
        */

        public function activate_account($UCode){
          
          if(!$this->getUserDetails(['user_code' => $UCode, 'user_status' => 'inactive'])) return FALSE;

           $this->db->where('user_code', $UCode);
           $this->db->update('an_user', ['user_status' => 'active']);

           return TRUE;
        }


        function delete_user($user_id){


          if($user_id == getCurrentUser('user_id')) return FALSE;

          $delete_status = FALSE;                 

          $this->db->trans_start();
     
          $delete_user_id = $this->db->escape($user_id);
          $sql = "DELETE FROM an_user WHERE user_id=$delete_user_id";
          $delete_user = $this->db->query($sql);
     
          if($delete_user){
         
           $sql = "DELETE FROM an_content WHERE user_id=$delete_user_id";
           $this->db->query($sql);   
             
          }
     
          $this->db->trans_complete();
     
           if ($this->db->trans_status() !== FALSE) {
             $update_status = TRUE;
           } 

           return $delete_status;
            
        }
   
}