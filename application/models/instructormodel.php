<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class InstructorModel extends MY_Model{

		public function get_instructor(){
			$this->toJoin = array(
				'instructorModel'=>'sched_subj'
			);

			return $this->get();
		}

        public function get_list(){
            $query = $this->db->query("SELECT * FROM instructor");
            return $query->result();
        }
    	
	}