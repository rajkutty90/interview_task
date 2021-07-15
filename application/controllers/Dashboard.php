<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index($page = 'page', $pageNo = '1')
	{
		loginPage(['administrator', 'user']);

		$this->load->model('AN_Content');
		$this->load->helper('content');

		$data = []; 
		$data['header'] = array('title' => 'Dashboard');

		$role  = getCurrentUser('role');


		$this->load->view('header', $data);
		if($role == 'user'){
			$data['content'] = $this->AN_Content->get_user_content(getCurrentUser('user_id'));
			$data['content'] = view_content($data['content']);
            $this->load->view('user-dashboard', $data);
		}else{

			$this->load->model('AN_List');
			$this->load->helper('list');

			$controller = 'dashboard';
		
			$label      = 'User';
			

			$options = [];

			/**-----Sort-------*/

			$options['order']['order']     = 'DESC';
			$options['order']['order_by']  = 'user_id';


			$pageLimits         = $this->config->item('number_of_items');
			$userList           = $this->AN_List->listItems('an_user', $pageLimits, $pageNo, $options);

			$tableData          = [
									'table'      => $userList,
									'labels'     => ['User ID', 'Name', 'Email', 'Phone', 'Role', 'Delete'],
									'fields'     => ['user_id', ['user_first_name','user_last_name'], 'user_email', 'user_phone', 'user_role', 'Delete'],
									'link'       => 'user_first_name',
									'page'       => $pageNo,
									'controller' => $controller,
									'filter'     => ['Delete' => 'remove_user_button[user_id]'],
									'options'    => [
													'edit_controller' => 'users/edit-user',
													'table_id' => 'user_id',
													'table' => 'user'
													]
								];
			
			/**----List Table----*/

			$data['listItems']  = getFullTable($tableData);

			/**----Pagination----*/
			
			$pagination         = $this->AN_List->getPagination();
			$pageConroller      = $controller;
			$data['pagination'] = getPagination($pagination['total_page'], $pagination['current_page'], $pageConroller, ['start' => '<div class="an-pagination-wrap">', 'end' => '</div>']);					  


			$this->load->view('dashboard', $data);
		}
		$this->load->view('footer', $data);
	}


}