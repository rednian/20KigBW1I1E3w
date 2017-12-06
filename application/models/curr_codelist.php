<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Curr_codelist extends MY_Model
{

  const DB_TABLE = 'curr_codelist';
  const DB_TABLE_PK = 'cur_id';

  public $cur_id;
  public $c_code;
  public $pl_id;
  public $eff_sem;
  public $eff_sy;
  public $status;

  public function active_curriculum(){
    $user_id = $this->userInfo->dep_id;
    $this->toJoin = array(
      'program_list'=>'curr_codelist'
    );
    $this->db->order_by('cur_id','DESC'); 

    return $this->get();
  }

  public function get_curriculum($pl_id = false){
    $this->db->where('pl_id', $pl_id);
    $this->db->order_by('eff_sy','DESC');

    return $this->get();

  }

  public function add($data = array())
  {
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
      $this->save();
      if ($this->db->affected_rows() > 0) {
        return true;
      } else {
        return false;
      }
    }
  }
}