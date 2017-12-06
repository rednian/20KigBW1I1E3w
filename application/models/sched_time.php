<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Sched_time extends MY_Model
{

  const DB_TABLE = 'sched_time';
  const DB_TABLE_PK = 'st_id';

  public $st_id;
  public $interval;
  public $time_end;
  public $time_start;

  public function add($data = array())
  {
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        if ($key != "st_id" && $key != "unit") {
          $this->$key = $value;
        }
      }
      $this->save();
      if ($this->db->affected_rows() > 0) {
        return array("result" => true, "type" => "new");
      } else {
        return false;
      }
    }
  }

  public function show($data = array())
  {
    if (empty($data)) {
      return $this->get();
    } else {
      return $this->search($data);
    }
  }

  public function remove($data)
  {
    foreach ($data as $key => $value) {
      $this->load($value);
      $this->delete();

      if ($this->db->affected_rows() > 0) {
        return true;
      } else {
        return false;
      }
    }
  }

  public function modify($rl_id, $data)
  {
    $this->load($rl_id);
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }
    $this->save();
    if ($this->db->affected_rows() >= 0) {
      return array("result" => true, "type" => "update");
    } else {
      return false;
    }
  }
}