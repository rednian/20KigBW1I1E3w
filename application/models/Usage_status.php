<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Usage_status extends MY_Model{

		const DB_TABLE = 'sis_main_db.usage_status';
    	const DB_TABLE_PK = 'us_id';
    	
    	public $pl_id;
    	public $us_id;
    	public $status;
    	
	}