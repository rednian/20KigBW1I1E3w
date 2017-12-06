<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Semester extends MY_Model{

		const DB_TABLE = 'semester';
    	const DB_TABLE_PK = 'sem_id';
    	
    	public $sem_id;
    	public $semester;
    	
	}