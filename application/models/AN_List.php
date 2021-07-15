<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Class for List Items

class AN_List extends CI_Model{
	
	/**
	 * Properties of List
	 */

	 public $totalItems  = 0;
	 public $currentPage = 1;
	 public $totalPages  = 0;
	 public $pageLimit   = 0;
	 public $where       = '';
	 public $like        = '';
	 public $table;

	/**
	 * Function to list items
	 */

	public function listItems($table, $limit = '', $page = 1, $options = ''){

		$limit   = $limit ? $limit : 1000000000000000;
		$offset  = 0;
		$this->currentPage = $page;
		$this->pageLimit   = $limit;
		$this->table       = $table; 
		$search            = false;

		if($limit){
			$offset = $limit * ($page - 1);
		}
	   
		if($options){

			$where  = '';
			$select = '';

			if(isset($options['where'])){
				$where  .= getDbWhereFormat($options['where']);
			}

			if(isset($options['like'])){
				$where  .= $where ? ' AND ' : '';
				$where  .= getDbLikeFormat($options['like'], 'OR', 'both', TRUE);
				$select .= '*, '.getDbLikeOrder($options['like'], 'both');
				$search  = true;
			}

			
			if(isset($options['filter'])){
				$where  .= $where ? ' AND ' : '';
				$where  .= getDbFilterFormat($options['filter'], 'AND', TRUE);
			}

			if($where){
                $this->db->where($where);
				$this->where = $where;
			}

			if(isset($options['order'])){
                $this->db->order_by($options['order']['order_by'], $options['order']['order']);
			}

		}

		if($search){
		    $where = $where ? 'WHERE '.$where : '';
            $sql   = "SELECT * FROM (
                           SELECT $select 
						   FROM $table $where
						   ORDER BY ".$options['order']['order_by']." ".$options['order']['order']." 
			            ) as list_table ORDER BY search_rank ASC
			       ";
			$query = $this->db->query($sql);	   
		}else{
	     	$query   = $this->db->get($table, $limit, $offset);
		}
		
		$result  = $query->result();

		if($result) return $result; 
		return FALSE;
		
	}

	/**
	 * Function to get Total items
	 */

	public function totalItems($table, $options = ''){
	   
		if($options){

			if(isset($options['where'])){
				$this->db->where($options['where']);
			}
			
		}
	
		$result  = $this->db->count_all_results($table);

		$this->totalItems = $result;

		if($result) return $result; 
		return 0;
		
	} 

	/**
	 * Get pagination details
	 */

	 public function getPagination(){
	
		$options = [];
		if($this->where) $options['where'] = $this->where;

		$this->totalItems($this->table, $options);

		$this->totalPages = ceil($this->totalItems / $this->pageLimit);

		$return = [
					'current_page' => $this->currentPage,
					'total_page'   => $this->totalPages
				  ];

	    return $return;			  
	 }

	 /**
	  * Function to make bulk action
	  */

	  public function makeBulkAction($options){

		   $validStatus = $options['validStatus'];

		   $listItems = []; 
		   if($options['items']){
			    foreach($options['items'] as $value){
			        $listItems[] =  $value;
			    }
		   }
		   
		   if(in_array($options['status'], $validStatus)){
			
			  if($listItems){
				  $table      = $options['table'];
				  $field      = $options['field'];
				  $tableID    = $options['table_id'];
				  $curentUser = getCurrentUser('UID');
				  $status     = $this->db->escape($options['status']);
				  foreach($listItems as $value){
					$canDelete  = TRUE;
				    if($table == 'an_user' && $value == $curentUser) $canDelete = FALSE; 
					if($canDelete){  
					    $value  = $this->db->escape($value);  
					    $sql    = "UPDATE ".$table." SET ".$field."=".$status." WHERE ".$tableID."=".$value;
					    $this->db->query($sql);
					}
			      }
			  }

		   }

		   if($options['status'] == 'clear'){
			
			   if($listItems){
				  $table      = $options['table'];
				  $field      = $options['field'];
				  $tableID    = $options['table_id'];
				  $curentUser = getCurrentUser('UID');
				  $status     = $this->db->escape($options['status']);
				  foreach($listItems as $value){
					$canDelete  = TRUE;
				    if($table == 'an_user' && $value == $curentUser) $canDelete = FALSE; 
					if($canDelete){  
					    $value  = $this->db->escape($value);  
					    $sql    = "DELETE FROM ".$table." WHERE ".$tableID."=".$value;
					    $this->db->query($sql);
					}
			      }
			  }
			
		   }

	  }


	  /**Function to get List Item Details */

	  function getListItemDetails($table, $option){
		  $field = $option['field'];
		  $value = $this->db->escape($option['value']);
		  $sql   = "SELECT * FROM ".$table." WHERE ".$field."=".$value;
		  $data  = $this->db->query($sql);
		  $data  = $data->result();
		  if(!$data) return FALSE;
		  return $data[0];
	  }

}
