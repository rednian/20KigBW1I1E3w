<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class User extends MY_Model{

		const DB_TABLE = 'user';
    	const DB_TABLE_PK = 'user_id';

    	const FIRST_NAME = 'user_fname';
    	const LAST_NAME = 'user_lname';
    	const MIDDLE_NAME = 'user_mname';
    	
    public $user_id;
		public $user_fname;
		public $user_lname;
		public $user_mname;
		public $username;
		public $password;
		public $user_status;
		public $user_image;
		public $user_department;
		public $user_position;
		public $dep_id;



		public function data_table(){
			$this->user_query();
			
			if($_GET['length'] != -1){
				$this->db->limit($_GET['length'], $_GET['start']);
			}	

			return $this->get();
		}

		// public function get_all_data(){
		// 	$this->user_query();
		// 	$this->db->count_all_results();
		// 	return $this->get();
		// }



		// pg_unescape_bytea(data)lic function get_filtered_data(){
		// 	$this->user_query();
		// 	$query = $this->db->get();
		// 	return $query->num_rows();
		// }


		private function user_query(){
			$order = array('user_fname', 'user_mname','user_lname','user_position','user_department');
			$search = isset($_GET['search']['value']) ? $_GET['search']['value'] : null;
		
			$this->toJoin = array("Department"=>"User");
				
				if(!empty($search)){
						$this->db->like('user_fname',$search);
						$this->db->or_like('user_mname',$search);
						$this->db->or_like('user_lname',$search);
						$this->db->or_like('user_department',$search);
						$this->db->or_like('user_position',$search);
				}

				if(!empty($_GET['order'])){
					$this->db->order_by($order[$_GET['order'][0]['column']],$_GET['order'][0]['dir']);
				}
				else{
					$this->db->order_by('user_id','DESC');
				}

		}



		public function get_user($data = array()){
			if(!empty($data)){
				$this->toJoin = array("Department"=>"User");
				$search = $this->search($data);
				return $search;
			}
			else{
				$this->toJoin = array("Department"=>"User");
				$this->db->where("user_id != {$this->userInfo->user_id}");
				$list = $this->get();
				return $list;
			}	
		}

		public function add($data = array()){

			if(!empty($data)){
				foreach ($data as $key => $value) {
					if($key != "user_id"){
						$this->$key = $value;
					}
				}
				$this->save();
				if($this->db->affected_rows() > 0){
					return true;
				}
				else{
					return false;
				}
			}
		}

		public function remove($id){
			$this->load($id);
			$this->delete();
			if($this->db->affected_rows() > 0){
				return true;
			}
			else{
				return false;
			}
		}

		public function modify($user_id, $data = array()){
			$this->load($user_id);
			if(!empty($data)){
				foreach ($data as $key => $value) {
					if($key != "user_id"){
						$this->$key = $value;
					}
				}
				$this->save();
				if($this->db->affected_rows() > 0 || $this->db->affected_rows() == 0){
					return true;
				}
				else{
					return false;
				}
			}
		}
	}

?>