<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Subject extends MY_Model
{

  const DB_TABLE = 'subject';
  const DB_TABLE_PK = 'subj_id';

  public $subj_id;
  public $subj_code;
  public $subj_name;
  public $subj_desc;
  public $lec_unit;
  public $lab_unit;
  public $lec_hour;
  public $lab_hour;
  public $split;
  public $subj_type;

  public function all()
  {
    $this->db->order_by('LOWER(subj_name)','ASC');
    return $this->get();

  }

  public function get_curriculum($data = array())
  {
    $year = array("1st" => "First Year", "2nd" => "Second Year", "3rd" => "Third Year", "4th" => "Forth Year", "5th" => "Fifth Year");
    $semister = array("1st Semester" => "First Semester", "2nd Semester" => "Second Semester");
    $array = array();
    $query = $this->db->query("SELECT
										`subject`.subj_id,
										`subject`.subj_code,
										`subject`.subj_name,
										`subject`.subj_desc,
										`subject`.lec_unit,
										`subject`.lab_unit,
                                        `subject`.lec_hour,
                                        `subject`.lab_hour,
                                        `subject`.split
										-- split_no_per_week.number
									FROM
										-- split_no_per_week,
										`subject`,
										year_sem,
										cur_subject,
										curr_codelist
									WHERE
										curr_codelist.pl_id = {$data['program_id']}
									AND curr_codelist.eff_sy = '{$data['sy']}'
									AND year_sem.`year` = '{$year[$data['year_level']]}'
									AND year_sem.semister = '{$semister[$data['semester']]}'  
									AND year_sem.cur_id = curr_codelist.cur_id
									AND year_sem.ys_id = cur_subject.ys_id
									AND cur_subject.subj_id = `subject`.subj_id
									");
    return $query->result();
  }

  public function get_subject($subj_id = false, $lab_unit = 0){
      $this->db->where('lab_unit >=' . $lab_unit);
      $this->db->where('subj_id',$subj_id);
      return $this->get();
  }


  public function get_by_type($data = false)
  {
    if (!empty($data)) {
      $this->db->where('lab_unit >=' . trim($data));
    }
    $this->db->order_by('subj_name');
    return $this->get();
  }

  public function add($data = array()){
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        if ($key != "subj_id" && $key != "number" && $key != "rate") {
          if ($key == 'subj_code') {
             $this->$key = strtoupper($value);
          }
          else{
            $this->$key = $value;
          }
        }
      }
      $this->save();
      if ($this->db->affected_rows() > 0) {
        return array("result" => true, "type" => "new", 'subject_id' => $this->db->insert_id());
      } else {
        return false;
      }
    }
  }

  public function show($data = array())
  {
    $this->db->order_by('subj_name','ASC'); 
    $_result = array();

    if (empty($data)) {
      // $this->db->limit(10); 
    
      $_result =  $this->get();
    } else {
      $_result =  $this->search($data);
    }

    return $_result;
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
      if ($key != "subj_id" && $key != "number" && $key != "rate") {
        $this->$key = $value;
      }
    }
    $this->save();
    if ($this->db->affected_rows() >= 0) {
      return array("result" => true, "type" => "update");
    } else {
      return false;
    }
  }
}