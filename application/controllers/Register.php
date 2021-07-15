<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{

		
		$this->load->helper(['form']);
		$this->load->model('AN_Captcha');

		$data = []; 

		$data['login'] = is_user_logged_in() ? true : false;
   
		$data['header'] = array('title' => 'Register');
		$data['captcha'] = $this->AN_Captcha->create_capcha();

		$data['footerScriptData']  = ' call_dob_datapicker();';

		$this->load->view('header', $data);
		$this->load->view('register', $data);
		$this->load->view('footer', $data);
	}


	public function register_user()
	{

		if(!$this->input->is_ajax_request()){
			redirect('');
		}

		$return  = [];

		$return['status'] = 'error';

		$this->load->helper(['form']);
		$this->load->model(['AN_Captcha', 'AN_User']);

		$this->load->library('form_validation');

		/**
		 * Validate Form Fields
		 */

		$valid_subscriptions = ['story', 'comment', 'poll']; 

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|valid_name');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|valid_name');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('subscription[]', 'Subscription', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required|valid_dob[/]');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|valid_uk_phone');
		$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
		
		
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
				'an-captcha'                => isset($return['error']['captcha']) ? $return['error']['captcha'] : ''	
			];

			$validation = FALSE;
		}

		if(!isset($return['error_display']['an-captcha']) || (isset($return['error_display']['an-captcha']) && !$return['error_display']['an-captcha'])){
			$captcha_valid  = true;
			if(!$this->session->userdata('captcha_word')){
				$captcha_valid  = false;
			}else if($this->session->userdata('captcha_word') != $this->input->post('captcha')){
				$captcha_valid  = false;
			}
			if(!$captcha_valid){
				$validation = FALSE;
				$return['error_display']['an-captcha'] = 'Invaild captcha';
			}
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
			if(!$this->AN_User->unique_email($this->input->post('email', TRUE))){
				$validation = FALSE;
				$return['error_display']['an-email'] = 'Email already Registerd';
			}
		}

		if(!isset($return['error_display']['an-uk-phone']) || (isset($return['error_display']['an-uk-phone']) && !$return['error_display']['an-uk-phone'])){
			if(!$this->AN_User->unique_phone($this->input->post('phone', TRUE))){
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
				"phone"          => $this->input->post('phone', TRUE)	
			 ];

			if($this->AN_User->add_user($data)){
				$return['status']  = 'success';
				$return['message'] = "Registration has successfuly been completed and activation link has been sent to your mail";

			}else{
			    $return['message'] = "Please Try Again";
			}								 
		}

		$captcha  = $this->AN_Captcha->create_capcha();

		$return['csrf_token'] = $this->security->get_csrf_hash();
		$return['captcha']    = $captcha['image'];

		echo json_encode($return);

	}

	public function login(){

		if(!$this->input->is_ajax_request()){
			redirect('');
		}

		$return            = [];
		$return['status']  = 'error';
		
		$this->load->model('AN_User');

		$this->load->helper(array('form'));
		 
		$this->load->library('form_validation');

		/**
		 * Validate Form Fields
		 */

		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		
		
		/**
		 * Validation Check  
		 */		 
			   
		if ($this->form_validation->run() == FALSE)
		{
			$return['error']   = $this->form_validation->error_array();
			
			$return['error_display'] = [
				'an-email'      => isset($return['error']['email']) ? $return['error']['email'] : '',
				'an-password'   => isset($return['error']['password']) ? $return['error']['password'] : ''
			];
		}
		else
		{

			$data              = [
									"email"    => $this->input->post('email', TRUE),
									"password" => $this->input->post('password', TRUE)
								 ];		
								 
			$login_blocked       = $this->AN_User->check_account_locked($this->input->post('email', TRUE));	


			if(!$login_blocked && $result = $this->AN_User->authenticationCheck($data)){
				
				if($result[0]->user_status == 'active'){
					if($this->AN_User->login($result)){
						$return['status'] = 'success';
						$return['message'] = "Login Success Redirecting...";
                        $redirect          = base_url().'dashboard';
						$return['url']     = $redirect;
					}else{
						$return['message'] = "Please Try Again";
					}	
			    }elseif($result[0]->user_status == 'blocked'){
					$return['message'] = "Your account has been blocked";
				}else{
					$return['message'] = "Please activate your account";
				}
			}else{
				$return['message'] = "Invalid username or password";
			}

				
			if ($login_blocked){
				$return['message'] = "Your account has temporally been blocked";
			}

		   							 	
		}	
		
		$return['csrf_token'] = $this->security->get_csrf_hash();

		echo json_encode($return);
	}

	public function activate(){
		
		if(!isset($_GET['u'])) redirect('');
		$this->load->model('AN_User');
		if(!$this->AN_User->activate_account($_GET['u'])){
			redirect('');
		}
 
		$data['header'] = array('title' => 'Account Activate');
 
		$this->load->view('header', $data);
		$this->load->view('activation', $data);
		$this->load->view('footer', $data);
	}

}
