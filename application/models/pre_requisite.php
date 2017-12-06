<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Pre_requisite extends MY_Model{

		const DB_TABLE = 'pre_requisite';
    	const DB_TABLE_PK = 'prr_id';
    	
    	public $prr_id;
    	public $cs_id;
    	public $subj_id;
	}