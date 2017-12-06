<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Stud_load_cap_set extends MY_Model{

		const DB_TABLE = 'stud_load_cap_set';
    	const DB_TABLE_PK = 'slcs_id';
    	
    	public $slcs_id;
    	public $student_type;
    	public $unit_capacity;
    
	}