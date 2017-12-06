<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subj_sched_day extends MY_Model {
    
    const DB_TABLE = 'subj_sched_day';
    const DB_TABLE_PK = 'ssd_id';

    public $ssd_id;
    public $sd_id;
    public $ss_id;
    public $time_start;
    public $time_end;
    public $type;
    public $rl_id;

    public function get_schedule($room_code = false){
    	$this->toJoin = array(
    	    "Room_list" => "Subj_sched_day", 
    	    "Sched_day" => "Subj_sched_day", 
    	    "Sched_subj" => "Subj_sched_day", 
    	    "Subject" => "Sched_subj"
    	);
    	$this->db->where('room_list.room_code', $room_code);

    	return $this->get();
    	
    }

}
  