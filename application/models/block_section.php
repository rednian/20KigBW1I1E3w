<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Block_section extends MY_Model{

		const DB_TABLE = 'block_section';
    	const DB_TABLE_PK = 'bs_id';
    	
    	public $bs_id;
    	public $sec_code;
    	public $activation;
    	public $description;
        public $year_lvl;
        public $semister;
        public $sy;
        public $pl_id;
        public $cur_id;


    public function get_block_section($data =array()){
        
    }

    public function get_last_row(){
      $this->db->limit(1);
      $this->db->order_by('bs_id','DESC');
       return $this->get();
    }

        public function all(){
            $this->sqlQueries['join_type'] = 'LEFT';
            $this->toJoin = array(
                'program_list'=>'block_section'
                );
            return $this->get();

        }
    	
	}