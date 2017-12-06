<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Subject_declaration extends MY_Model{

		const DB_TABLE = 'subject_declaration';
    	const DB_TABLE_PK = 'sd_id';
    	
    	public $sd_id;
    	public $ss_id;
    	public $declaration;
    	
	}