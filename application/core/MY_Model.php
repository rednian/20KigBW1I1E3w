<?php

class MY_Model extends CI_Model{
	const DB_TABLE = "default";
	const DB_TABLE_PK = "default";

	// toJoin *array -> array('model to join' => 'model already joined or loaded');
	public $toJoin = array();
	public $selects = array();
	// $order_field and $order_type used for order queries
	public $sqlQueries = array("order_field" => '',
								"order_type" => '',
								"toGroup" => '',
								"join_type" => '',
								"selects" => '*',
								);

	// $ss-sqlQueries['join_type'] = 'LEFT';


  public function getSelect(){
		$selectQry = "";
		if($this->selects){
			$counter = 0;
			foreach ($this->selects as $key => $value) {
				$counter ++;
				if($counter == count($this->selects)){
					$selectQry .= " {$value} ";
				}
				else{
					$selectQry .= " {$value}, ";
				}
			}
		}
		return $selectQry;
	}
  public function db2_delete()
	{
		$tableName = $this::DB_TABLE;
		$pkName = $this::DB_TABLE_PK;
		$valueOfPk = $this->{$this::DB_TABLE_PK};

		$this->db2->query("DELETE FROM {$tableName} WHERE {$pkName} = {$valueOfPk}");
		unset($this->{$this::DB_TABLE_PK});
	}
  public function db2_get($qry = false)
	{
		$this->db2->from($this::DB_TABLE);
		if ($qry) {
			$this->db2->where($qry);
		}
		$query = $this->db2->get();
		$toret = $this->instatiate($query->result());
		return $toret;
	}
  // use instantiate for more than one record
  public function instatiate($qry_result){
		$toret = array();
		$class = get_class($this);
		foreach ($qry_result as $row) {
			$model = new $class;
			$model->populate($row);
			$toret[$row->{$this::DB_TABLE_PK}] = $model;
		}
		return $toret;
	}
  // use populate if you are looking for only one record
  public function populate($row){
		foreach ($row as $key => $value) {
				$this->$key = $value;
		}
	}
  public function load($id){
		if($this->getSelect() != ""){
			$qry->select($this->getSelect());
		}
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$query = $this->db->where(array($this::DB_TABLE.".".$this::DB_TABLE_PK => $id));
		$query = $this->db->get();
		$this->populate($query->row());
	}
  public function empty_table()
	{
		$this->db->empty_table($this::DB_TABLE);
	}
  public function delete($all = false){
			$this->db->delete($this::DB_TABLE,array(
			$this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}));
			unset($this->{$this::DB_TABLE_PK});
	}
  public function save(){
		if(isset($this->{$this::DB_TABLE_PK})){
			$this->update();
		}
		else{
			$this->insert();
		}
	}
  public function get($limit = 0, $offset = 0){
		$this->db->select('*');
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$this->addGroup();
		$this->addOrder();
		if($limit){
			$query = $this->db->limit($limit,$offset);
		}
		$qry = $this->db->get();
		$toret = $this->instatiate($qry->result());
		return $toret;
	}
  public function get_join(){
		// echo "asddas";
		$this->db->select('*');
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$query = $this->db->get();
		$toret = $this->instatiate($query->result());

		return $toret;

	}
  // @search
  // @parameter $where => array('field' => value)
  // @parameter $joins => array( 'model to join'=> 'model already joined' )
  public function search($where,$limit = 0, $offset = 0){
		if($this->getSelect() != ""){
			$this->db->select($this->getSelect());
		}
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$this->db->where($where);
		$this->addOrder();
		if ($limit) {
			$this->db->limit($limit);
			$this->db->offset($offset);
			$qry = $this->db->get();
		}
		else{
			$qry = $this->db->get();
		}
		$toret = $this->instatiate($qry->result());
		return $toret;
	}
  public function whereLike($orLikes,$andLikes,$where,$orWhere,$between = array(),$limit = 0,$offset = 0){
		$counter = 0;
		$qry = $this->db;
		if($this->getSelect() != ""){
			$qry->select($this->getSelect());
		}
		$qry->from($this::DB_TABLE);
		$this->addJoin('left');
		$whereQuery = "";

		if($orLikes)
		{
			$whereQuery .= "(";
			foreach ($orLikes as $key => $value)
			{
				$counter++;
				if($counter == 1)
				{
					if(is_int($value))
					{
						$whereQuery .= "{$key} = {$value} ";
					}
					else
					{
						$whereQuery .= "{$key} like '%{$value}%' ";
					}
				}
				else{
					if(is_int($value))
					{
						$whereQuery .= "OR {$key} = {$value} ";
					}
					else
					{
						$whereQuery .= "OR {$key} like '%{$value}%' ";
					}
				}
			}
			$whereQuery .= ")";
			if($andLikes OR $where OR $between || $orWhere )
			{
				$whereQuery .= " AND ";
			}
		}
		if($andLikes){
			$whereQuery .= "( ";
			$counter = 0;
			foreach ($andLikes as $key => $value) {
				$counter++;
				if($counter == 1){
					if(is_int($value)){
						$whereQuery .= "{$key}  = {$value} ";
					}
					else{
						$whereQuery .= "{$key} like '%{$value}%' ";
					}
				}else{
					if(is_int($value)){
						$whereQuery .= "AND {$key} = {$value} ";
					}
					else{
						$whereQuery .= "AND {$key} like '%{$value}%' ";
					}
				}
			}
			$whereQuery .= ") ";
			if($where || $orWhere || $between){
				$whereQuery .= " AND ";
			}

		}
		if($where){
			$counter = 0;
			$whereQuery .= "( ";
				foreach ($where as $key2 => $value2) {
				$counter++;
				foreach ($value2 as $key => $value) {
						if($counter == 1){
							if(is_int($value)){
								$whereQuery .= "{$key} = {$value} ";
							}
							else{
								$whereQuery .= "{$key} = '{$value}' ";
							}
						}else{
							if(is_int($value)){
								$whereQuery .= "AND {$key} = {$value} ";
							}
							else{
								$whereQuery .= "AND {$key} = '{$value}' ";
							}
						}
					}

			}
			$whereQuery .= ")";
			if($orWhere || $between){
				$whereQuery .= " AND ";
			}
		}
		if($orWhere){
			$whereQuery .= "( ";
				$counter = 0;
				foreach ($orWhere as $key2 => $value2) {
					foreach ($value2 as $key => $value) {
							$counter++;
							foreach ($value as $key3 => $value3) {
								if($counter == 1){
									if(is_int($value)){
										$whereQuery .= "{$key3} = {$value3} ";
									}
									else{
										$whereQuery .= "{$key3} = '{$value3}' ";
									}
								}
								else
								{
									if(is_int($value)){
										$whereQuery .= "OR {$key3} = {$value3} ";
									}
									else{
										$whereQuery .= "OR {$key3} = '{$value3}' ";
									}
								}
							}
						}
				}
			$whereQuery .= ")";
			if($between){
				$whereQuery .= " AND ";
			}
		}
		if($between){
			$whereQuery .= "( ";
				$counter = 0;
				foreach ($between as $key2 => $value2) {
					$whereQuery .= "{$key2} BETWEEN ";
					$counter = 0;
					foreach ($value2 as $key3 => $value3) {
						$counter++;
						if (is_int($value3)) {
							if ($counter == 2) {
								$whereQuery .= "{$value3}";
							}
							else{
								$whereQuery .= "{$value3} AND ";
							}
						}
						else{
							if ($counter == 2) {
								$whereQuery .= "'{$value3}'";
							}
							else{
								$whereQuery .= "'{$value3}' AND ";
							}
						}
					}

				}
			$whereQuery .= ")";
		}

		$qry->where($whereQuery);
		$this->addOrder();
		if ($this->sqlQueries['toGroup']) {
			$this->db->group_by($this->sqlQueries['toGroup']);
		}
		if ($limit) {
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();

		return $this->instatiate($query->result());
	}
  public function load_last_input(){
		$this->get_order_limit1($this::DB_TABLE_PK,'desc',array());
	}
  public function load_first_input(){
		$this->get_order_limit1($this::DB_TABLE_PK,'ASC',array());
	}
  public function get_order_limit1($field,$order,$where){
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$this->db->where($where);
		$this->db->order_by($field,$order);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query){
			$this->populate($query->row());
		}
	}
  public function get_ordered($where,$field,$order){
		$qry = $this->db;
		$qry->from($this::DB_TABLE);
		$qry->where($where);
		$qry->order_by($field,$order);
		$query = $this->db->get();
		$toret = $this->instatiate($query->result());

		return $toret;
	}
  public function fullName($format = "l, m. f"){
		$fullName = "";
		$format = str_split($format);
		$mname = "";

		if(isset($this->{$this::FIRST_NAME}) && isset($this->{$this::FIRST_NAME})){
			if ($this->{$this::MIDDLE_NAME} != "") {
				$mname = ucfirst($this->{$this::MIDDLE_NAME}[0]);
			}

			$name = array("f" => ucfirst($this->{$this::FIRST_NAME}),
						  "m" => $mname,
						  "l" => ucfirst($this->{$this::LAST_NAME})
						);
			foreach ($format as $key => $value) {
						if (isset($name[$value])) {
							$fullName .= $name[$value];
						}
						else{
							if (($value == "." || $value == ",")&& $mname == "") {
							}
							else{
								$fullName .= $value;
							}
						}
					}
		}
		return $fullName;
	}
  public function save_or_get($searchArray,$newValues,$className){
		$class = new $className;
		$objectExists = $class->search($searchArray);
		if($objectExists){
			$toret = array_shift($objectExists);
		}
		else{
			$newObject = new $className;
			foreach ($newValues as $key => $value) {
				$newObject->$key = $value;
			}
			$newObject->save();

			$lastInput = new $className;
			$lastInput->load_last_input();
			$toret = $lastInput;
		}
		return $toret;
	}
  public function calc_age($dob){
		//date in mm/dd/yyyy format; or it can be in other formats as well
	  $dob = date("m/d/Y",strtotime($dob));
	  //explode the date to get month, day and year
	  $dob = explode("/", $dob);
	  //get age from date or dob
	  $age = (date("md", date("U", mktime(0, 0, 0, $dob[0], $dob[1], $dob[2]))) > date("md")
	    ? ((date("Y") - $dob[2]) - 1)
	    : (date("Y") - $dob[2]));
		 return $age;
	}
  public function patient_age(){
		$age = 0;
		if(isset($this->patient_birthday))
		{
	    	if($this->patient_birthday != ""){
	    	  $birthDate = date("m/d/Y",strtotime($this->patient_birthday));
			  $birthDate = explode("/", $birthDate);
			  //get age from date or birthdate
			  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
	    	}
	    	else{
	    	}
	    	$this->patient_age = $age;
	    	return $age;
	    }
	}


	private function insert(){
    $this->db->insert($this::DB_TABLE,$this);
    $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
  }
  private function addJoin($joinType = null){
    if(isset($this->sqlQueries['join_type'])){
      if($this->sqlQueries['join_type'] != ""){
        $joinType = $this->sqlQueries['join_type'];
      }
    }
    if(count($this->toJoin) > 0){
      foreach ($this->toJoin as $key => $value) {
        $this->load->model($key);
        $this->load->model($value);
        $classname2 = ucfirst($value);
        $classname = ucfirst($key);
        $model1 	= new $classname;
        $model2 	= new $classname2;
        if(property_exists($model2, $model1::DB_TABLE_PK)){
          $commonPk = $model1::DB_TABLE_PK;
        }elseif(property_exists($model1, $model2::DB_TABLE_PK)){
          $commonPk = $model2::DB_TABLE_PK;
        }

        $this->db->join($model1::DB_TABLE, $model1::DB_TABLE.".".$commonPk." = ".$model2::DB_TABLE.".".$commonPk,$joinType,"left outer");
      }
    }
  }
  private function update(){
    $this->db->where($this::DB_TABLE_PK, $this->{$this::DB_TABLE_PK});
    $this->db->update($this::DB_TABLE,$this);
  }
  private function addOrder(){
    if($this->sqlQueries['order_field'] != '' and $this->sqlQueries['order_type'] != ''){
      $this->db->order_by($this->sqlQueries['order_field'],$this->sqlQueries['order_type']);
    }
  }
  private function addGroup(){
    if($this->sqlQueries['toGroup'] != ''){
      $this->db->group_by($this->sqlQueries['toGroup']);
    }
  }
}