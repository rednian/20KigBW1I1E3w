<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Rate_source extends MY_Model{

		const DB_TABLE = 'rate_source';
    	const DB_TABLE_PK = 'rn_id';
    	
    	public $rn_id;
    	public $rate_name;
    	public $description;
    	
	}