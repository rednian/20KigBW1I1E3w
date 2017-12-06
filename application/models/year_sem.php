<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Year_sem extends MY_Model{

		const DB_TABLE = 'year_sem';
    	const DB_TABLE_PK = 'ys_id';
    	
    	public $ys_id;
    	public $cur_id;
    	public $year;
    	public $semister;

    	public function add($data = array()){
    		if(!empty($data)){
    			foreach ($data as $key => $value) {
    				$this->$key = $value;
    			}
    			$this->save();
    			if($this->db->affected_row() > 0){
    				return true;
    			}
    			else{
    				return false;
    			}
    		}
    	}
	}