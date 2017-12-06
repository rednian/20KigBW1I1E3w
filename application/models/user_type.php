<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class User_type extends MY_Model{

		const DB_TABLE = 'user_type';
    	const DB_TABLE_PK = 'user_type_id';
    	
    	public $user_type_id;
    	public $user_type;
    	
	}