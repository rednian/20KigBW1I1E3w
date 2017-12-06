<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Cur_subject extends MY_Model{

		const DB_TABLE = 'cur_subject';
    	const DB_TABLE_PK = 'cs_id';
    	
    	public $cs_id;
    	public $ys_id;
    	public $subj_id;
	}