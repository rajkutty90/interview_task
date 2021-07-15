<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
	 * Function to edit user
	 */

	 function edit_user($userID){

		loginPage(['administrator']);
        
		$data['header'] = array('title' => 'Edit User');

		$this->load->helper(['form']);
		$this->load->model(['AN_List', 'AN_User']);

		$data['userdetails'] = $this->AN_User->getUserDetails(['user_id' => $userID]);
		if(!$data['userdetails']) redirect('dashboard'); 

		$data['userdetails'] = $data['userdetails'][0];

		$data['footerScriptData']  = ' call_dob_datapicker();';

		$this->load->view('header', $data);
		$this->load->view('edit-user');
		$this->load->view('footer');
	 }

	

	 /**
	  * Function to update user
	  */
	

	 function update_user(){

		loginPage(['administrator']);

		if(!$this->input->is_ajax_request()){
			redirect('');
		}

		$return  = [];

		$return['status'] = 'error';

		$this->load->helper(['form']);
		$this->load->model(['AN_User']);

		$this->load->library('form_validation');

		/**
		 * Validate Form Fields
		 */

		$valid_subscriptions = ['story', 'comment', 'poll']; 

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|valid_name');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|valid_name');
		$this->form_validation->set_rules('password', 'Password', 'trim');
		$this->form_validation->set_rules('subscription[]', 'Subscription', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|valid_dob[/]');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|valid_uk_phone');
		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required|integer');
		
		
		/**
		 * Validation Check  
		 */	
		
		$validation = TRUE; 

		if ($this->form_validation->run() == FALSE)
		{
			$return['error']   = $this->form_validation->error_array();
			
			$return['error_display'] = [
				'first-name'                => isset($return['error']['first_name']) ? $return['error']['first_name'] : '',
				'last-name'                 => isset($return['error']['last_name']) ? $return['error']['last_name'] : '',
				'an-password'               => isset($return['error']['password']) ? $return['error']['password'] : '',
				'subscription-group-label'  => isset($return['error']['subscription[]']) ? $return['error']['subscription[]'] : '',
				'an-email'                  => isset($return['error']['email']) ? $return['error']['email'] : '',
				'dob-datepicker'            => isset($return['error']['dob']) ? $return['error']['dob'] : '',	
				'an-uk-phone'               => isset($return['error']['phone']) ? $return['error']['phone'] : '',
				'user-id'                   => isset($return['error']['user_id']) ? $return['error']['user_id'] : ''	
			];

			$validation = FALSE;
		}

		$valid_user = TRUE;

		$user_details = '';

		if(!isset($return['error_display']['user-id']) || (isset($return['error_display']['user-id']) && !$return['error_display']['user-id'])){
			$user_details = $this->AN_User->getUserDetails(['user_id' => $this->input->post('user_id', true)]);
			if(!$user_details){
				$valid_user = FALSE;
				$validation = FALSE;
				$return['error_display']['user-id'] = 'Invaild User';
			}
		}else{
			$valid_user = FALSE;
		}

		if(!isset($return['error_display']['subscription-group-label']) || (isset($return['error_display']['subscription-group-label']) && !$return['error_display']['subscription-group-label'])){
			$subscriptions = $this->input->post('subscription[]');
			$subscriptions_status = true;
			foreach($subscriptions as $key => $value){
               if(!in_array($value, $valid_subscriptions)){
				$subscriptions_status = false;
				break;
			   }
			}

			if(!$subscriptions_status){
				$validation = FALSE;
				$return['error_display']['subscription-group-label'] = 'Invaild subscription';
			}
		}

		if(!isset($return['error_display']['an-email']) || (isset($return['error_display']['an-email']) && !$return['error_display']['an-email'])){
			if($valid_user && !$this->AN_User->unique_email($this->input->post('email', TRUE),  $this->input->post('user_id', true))){
				$validation = FALSE;
				$return['error_display']['an-email'] = 'Email already Registerd';
			}
		}

		if(!isset($return['error_display']['an-uk-phone']) || (isset($return['error_display']['an-uk-phone']) && !$return['error_display']['an-uk-phone'])){
			if($valid_user && !$this->AN_User->unique_phone($this->input->post('phone', TRUE),  $this->input->post('user_id', true))){
				$validation = FALSE;
				$return['error_display']['an-uk-phone'] = 'Phone number already Registerd';
			}
		}

		if($validation){
            $data               = [
				"first_name"     => $this->input->post('first_name', TRUE),
				"last_name"      => $this->input->post('last_name', TRUE),
				"subscription"   => $this->input->post('subscription[]', TRUE),
				"password"       => $this->input->post('password'),
				"email"          => $this->input->post('email', TRUE),
				"dob"            => $this->input->post('dob', TRUE),
				"phone"          => $this->input->post('phone', TRUE),
				"role"           => $user_details[0]->user_role	
			 ];

			if($this->AN_User->update_user($data, $this->input->post('user_id', true))){
				$return['status']  = 'success';
				$return['message'] = "User has successfuly been updated";

			}else{
			    $return['message'] = "Please Try Again";
			}								 
		}


		$return['csrf_token'] = $this->security->get_csrf_hash();

		echo json_encode($return);
	 } 


	function delete_user(){
		loginPage(['administrator']);

		if(!$this->input->is_ajax_request()){
			redirect('');
		}

		$return  = [];

		$return['status'] = 'error';

		$this->load->helper(['form']);
		$this->load->model(['AN_User']);

		$this->load->library('form_validation');

		/**
		 * Validate Form Fields
		 */


		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required|integer');
		
		
		/**
		 * Validation Check  
		 */	
		
		$validation = TRUE; 

		if ($this->form_validation->run() == FALSE)
		{
			$validation = FALSE;
		}

		if($validation){
            if($this->AN_User->delete_user($this->input->post('user_id', true))){
				$return['status'] = 'success';
			}
			
		}

		$return['csrf_token'] = $this->security->get_csrf_hash();

		echo json_encode($return);
	}

}
