<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Rate_percentage_subj extends MY_Model{

		const DB_TABLE = 'rate_percentage_subj';
    	const DB_TABLE_PK = 'rns_id';
    	
    	public $rns_id;
    	public $rate_num;
    	public $subj_id;
    	public $rn_id;
    	
	}