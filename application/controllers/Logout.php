<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$this->load->model('AN_User');
		$this->AN_User->logout();
		redirect('');

	}

}
