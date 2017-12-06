<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Room_list extends MY_Model{

		const DB_TABLE = 'room_list';
    const DB_TABLE_PK = 'rl_id';
    	
    public $rl_id;
		public $room_code;
		public $room_name;
		public $capacity;
		public $location;
		public $type;
		public $desc;

		public function add($data = array()){
			if(!empty($data)){
				foreach ($data as $key => $value) {
					if($key != "rl_id"){
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

		public function roomSched($data = []){

			$sql = "SELECT
						sched_subj.*, sched_day.composition,
						`subject`.subj_code,
						subj_name,
						room_list.room_code
					FROM
						sched_subj,
						`subject`,
						sched_day,
						room_list
					WHERE
					sched_subj.rl_id = {$data['rl_id']}
					AND sched_subj.sem = '{$data['sem']}'
					AND sched_subj.sy = '{$data['sy']}'
					AND sched_subj.sd_id = sched_day.sd_id
					AND sched_subj.avs_status = 'active'
					AND room_list.rl_id = sched_subj.rl_id
					AND `subject`.subj_id = sched_subj.subj_id";

			$query = $this->db->query($sql);
			return $query->result();
		}
	}