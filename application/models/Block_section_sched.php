<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Block_section_sched extends MY_Model{

		const DB_TABLE = 'block_section_sched';
    	const DB_TABLE_PK = 'sched_id';
    	
    	public $sched_id;
    	public $bs_id;
    	public $ss_id;
    	public $sched_type;

        public function getSubjectExistSchedule($subj_id = false){
            
            $query = $this->db->query("SELECT
                                            sched_subj.*, block_section_sched.bs_id,
                                            sched_type
                                        FROM
                                            block_section_sched,
                                            sched_subj
                                        WHERE
                                            block_section_sched.ss_id = sched_subj.ss_id
                                        AND
                                            sched_subj.subj_id = {$subj_id}
                                        ORDER BY
                                            block_section_sched.bs_id");
            
            return $query->result();
        }
    	
	}