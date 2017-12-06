<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Tutorial extends MY_Model{

		const DB_TABLE = 'tutorial';
    	const DB_TABLE_PK = 'tut_id';
    	
    	public $tut_id;
    	public $student_capacity;
    	public $ss_id;
    	
	}