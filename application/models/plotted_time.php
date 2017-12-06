<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Plotted_time extends MY_Model{

		const DB_TABLE = 'plotted_time';
    	const DB_TABLE_PK = 'pt_id';
    	
    	public $pt_id;
		public $time;
		public $st_id;


    public function get_by_sched($data =array())
    {
      $this->db->where('time >=', $data[0]);
      if (!empty($data[0])){
      $this->db->where('time <=', $data[1]);
      }
      return $this->get();
		}

		public function add($data = array()){
			if(!empty($data)){
				foreach ($data as $key => $value) {
					if($key != "pt_id"){
						$this->$key = $value;
					}
				}
				$this->save();
				if($this->db->affected_rows() > 0){
					return array("result"=>true, "type"=>"new");
				}
				else{
					return false;
				}
			}
		}

		public function show($data = array()){
			if(empty($data)){
				return $this->get();
			}
			else{
				return $this->search($data);
			}
		}

		public function remove($data){
			foreach ($data as $key => $value) {
				$this->load($value);
				$this->delete();

				if($this->db->affected_rows() > 0){
					return true;
				}
				else{
					return false;
				}
			}
		}

		public function modify($rl_id, $data){
			$this->load($rl_id);
			foreach ($data as $key => $value) {
				$this->$key = $value;
			}
			$this->save();
			if($this->db->affected_rows() >=0){
			  return array("result"=>true, "type"=>"update");
			}else{
			  return false;
			}
		}
	}