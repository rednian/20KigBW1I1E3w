<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Program_list extends MY_Model{

		const DB_TABLE = 'sis_main_db.program_list';
    	const DB_TABLE_PK = 'pl_id';
    	
    	public $pl_id;
    	public $prog_code;
    	public $prog_abv;
    	public $prog_name;
    	public $prog_desc;
    	public $prog_type;
    	public $level;
    	public $major;
      public $dep_id;
      public $created_at;
    	public $updated_at;

    // program only display in course if the curriculum already created
    public function get_by_user(){
      $this->toJoin = array(
        'curr_codelist'=>'program_list'
      );
      $this->db->where(array('dep_id'=>$this->userInfo->dep_id));
      return $this->get();
    }


    public function all(){
            $this->join = array(
                "Department"=>"Program_list", 
                "Usage_status"=>"Program_list"
                );
            return $this->get();
        }

    	public function saveProgram($data = array()){

    		if(!empty($data)){
    			foreach ($data as $key => $value) {
    				$this->$key = $value;
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
	}