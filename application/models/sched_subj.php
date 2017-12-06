<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Sched_subj extends MY_Model{

		const DB_TABLE = 'sched_subj';
    	const DB_TABLE_PK = 'ss_id';
    	
    	public $ss_id;
    	public $sy;
    	public $sem;
    	public $subj_id;
    	public $bs_id;
    	public $avs_status;
    	public $employee_id;
        public $year_lvl;
        public $temp_id;
        public $key;

        
        public function get_schedule($room_code  = false){
            $this->toJoin = array(
              'room_list' => 'sched_subj',
              'sched_day' => 'sched_subj',
              'subject'   => 'sched_subj',
            );
            
            if (!empty($room_code)) {
              $this->db->where('room_list.room_code', $room_code);
            }
            
            return $this->get();
            
        }

        public function get_by_block($data =array()){
            
            $this->toJoin = array('Subject'=>'sched_subj');

            $this->db->where(array('bs_id'=>$data['id'], 'type'=>$data['type']));
            return $this->get();
        }

      
		
	}