<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Gen_info extends MY_Controller
{

  public function __construct(){
    parent::__construct();
    $config['csrf_protection'] = false;
    $this->load->model("Room_list");
    $this->load->model("Sched_day");
    $this->load->model("Sched_time");
    $this->load->model("Plotted_time");
    $this->load->model("Subject");
    $this->load->model("Split_no_per_week");
    $this->load->model("InstructorModel");
    $this->load->model("Other_sched");
  }

  public function index(){


    $this->load->model("Department");
    $dep = new Department;

    $data['dep'] = $dep->get();
    $data['title'] = 'General Information';

    $this->load->view('includes/header', $data);
    $this->load->view('includes/menu');
    $this->load->view('geninfo/css');
    $this->load->view('geninfo/index', $data);
    $this->load->view('includes/footer');
    $this->load->view('includes/js');
    $this->load->view('geninfo/js');
  }

  // ROOM METHODS //

  public function is_room_code_exist(){
    if ($this->input->method() == 'post' && array_key_exists('room_code', $_POST)) {

        $r = new Room_list();
        $valid = TRUE;
        $code = array();
        foreach ($r->lists() as $room) {
          array_push($code , $room->room_code);
        }
        if (isset($_GET['room_code']) && in_array(strtolower($_GET['room_code']) , $code)) {
          $valid = FALSE;
        }
        echo json_encode(array('valid' => $valid));
      }
  }

  public function roomSave(){

    $room = new Room_list;
    $data = $this->input->post();
    $result = "";

    if ($this->input->post('rl_id') == "") {

      $this->form_validation->set_rules('room_code', 'Room code', 'required|is_unique[room_list.room_code]',
        array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
      $this->form_validation->set_rules('room_name', 'Room name', 'required|is_unique[room_list.room_name]',
        array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
      $this->form_validation->set_rules('capacity', 'Capacity', 'required|is_natural_no_zero',
        array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
      $this->form_validation->set_rules('room_name', 'Room name', 'required',
        array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));

      if ($this->form_validation->run() == false) {
        $errors = validation_errors();
        echo json_encode(["result" => "validateError", "errors" => $errors]);
      } else {
        $result = $room->add($data);
        echo json_encode(array("result" => $result['result'], "type" => $result['type']));
      }

    } else {
      $result = $room->modify($data['rl_id'], $data);
      echo json_encode(array("result" => $result['result'], "type" => $result['type']));
    }
    // echo json_encode(array("result" => $result['result'], "type" => $result['type']));
  }

  public function roomList(){
    $room = new Room_list;
    $list = $room->show();
    echo json_encode($list);
  }

  public function roomDelete(){
    $room = new Room_list();
    $rl_id = $this->input->get('rl_id');
    $result = $room->remove(array("rl_id" => $rl_id));
    echo json_encode(array("result" => $result));
  }

  public function roomEdit(){
    $room = new Room_list;
    $rl_id = $this->input->get('rl_id');
    $data = $room->show(array('rl_id' => $rl_id));
    echo json_encode($data);
  }

  // END ROOM METHODS //

  // DAYS METHOD //
  public function daySave(){
    $this->form_validation->set_rules('abbreviation', 'Abbreviation', 'required|is_unique[sched_day.abbreviation]',
      array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
    $this->form_validation->set_rules('composition', 'Composition', 'required|is_unique[sched_day.composition]',
      array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));

    if ($this->form_validation->run() == false) {
      $errors = validation_errors();
      echo json_encode(["result" => "validateError", "errors" => $errors]);
    } else {
      $day = new Sched_day;
      $data = $this->input->post();
      $result = "";

      if ($this->input->post('sd_id') == "") {
        $result = $day->add($data);
      } else {
        $result = $day->modify($data['sd_id'], $data);
      }
      echo json_encode(array("result" => $result['result'], "type" => $result['type']));
    }
  }

  public function dayList(){
    $day = new Sched_day;
    $list = $day->show();
    echo json_encode($list);
  }

  public function dayDelete(){
    $day = new Sched_day();
    $sd_id = $this->input->get('sd_id');
    $result = $day->remove(array("sd_id" => $sd_id));
    echo json_encode(array("result" => $result));
  }

  public function dayEdit(){
    $room = new Sched_day;
    $sd_id = $this->input->get('sd_id');
    $data = $room->show(array('sd_id' => $sd_id));
    echo json_encode($data);
  }
  // END DAYS METHOD //

  // TIME METHOD //
  public function timeSave(){
    $time = new Sched_time;
    $data = $this->input->post();
    $result = "";

    if ($this->input->post('st_id') == "") {
      $result = $time->add($data);
      if ($result['result'] == true) {
        $st_id = $this->db->insert_id();
        $this->saveInterval($data['time_start'], $data['time_end'], $data['interval'], $data['unit'], $st_id);
      }
    } else {
      $result = $time->modify($data['st_id'], $data);
    }
    echo json_encode(array("result" => $result['result'], "type" => $result['type']));

  }

  public function timeList(){
    $time = new Sched_time;
    $list = $time->show();
    echo json_encode($list);
  }

  // END TIME METHOD /

  public function saveInterval($start, $end, $interval, $unit, $st_id){

    $startTime = strtotime($start);
    $endTime = strtotime($end);
    $interval = $interval;
    $time = $startTime;

    while ($time <= $endTime) {
      $plot = new Plotted_time;
      $data = array(
        "time"  => date('H:i', $time),
        "st_id" => $st_id
      );

      $plot->add($data);

      $time = strtotime('+' . $interval . ' ' . $unit, $time);
    }
  }

  public function previewInterval(){
    $startTime = strtotime($this->input->get('start'));
    $endTime = strtotime($this->input->get('end'));
    $interval = $this->input->get('interval');
    $unit = $this->input->get('unit');
    $time = $startTime;
    $data = array();

    while ($time <= $endTime) {
      $data[] = date('h:i A', $time);
      $time = strtotime('+' . $interval . ' ' . $unit, $time);
    }
    echo json_encode($data);
  }

  // SUBJECT METHOD //
  public function subjectList(){
    $subject = new Subject();
    $data =array();

    $list = $subject->show();

    if (!empty($list)) {
      foreach ($list as $subject) {
        $lab_unit = '';
        if (!empty($subject->lab_unit)) {
          $lab_unit = $subject->lab_unit;
        }
        $data[] = array(
          'subj_id'=>$subject->subj_id,
          'subj_code'=>$subject->subj_code,
          'subj_name'=>$subject->subj_name,
          'subj_desc'=>$subject->subj_desc,
          'lec_unit'=>$subject->lec_unit,
          'lab_unit'=>$lab_unit,
          'lec_hour'=>$subject->lec_hour,
          'lab_hour'=>$subject->lab_hour,
          'split' =>$subject->split,
          'subj_type' =>$subject->subj_type
        );
      }
    }

    echo json_encode($data);
  }

  public function subjectSave(){
    $this->form_validation->set_rules('subj_code', 'Subject Code', 'required|is_unique[subject.subj_code]',
      array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
    $this->form_validation->set_rules('subj_name', 'Subject Name', 'required|is_unique[subject.subj_name]',
      array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
    $this->form_validation->set_rules('lab_unit', 'Laboratory Unit', 'required|is_natural',
      array('required' => 'You must provide a %s.'));
    $this->form_validation->set_rules('lab_hour', 'Laboratory no of hours', 'required|is_natural',
      array('required' => 'You must provide a %s.'));
    $this->form_validation->set_rules('lec_unit', 'Lecture Unit', 'required|is_natural',
      array('required' => 'You must provide a %s.'));
    $this->form_validation->set_rules('lec_hour', 'Lecture no of hours', 'required|is_natural',
      array('required' => 'You must provide a %s.'));
    $this->form_validation->set_rules('split', 'Split', 'required|is_natural_no_zero',
      array('required' => 'You must provide a %s.'));

    if ($this->form_validation->run() == false) {
      $errors = validation_errors();
      echo json_encode(["result" => "validateError", "errors" => $errors]);
    } else {
      $subject = new Subject;
      $split = new Split_no_per_week;

      $data = $this->input->post();

      // $data['rate'] = array();
      // $data['subj_type'] = "College";

      $result = "";

      if ($this->input->post('subj_id') == "") {

        $result = $subject->add($data);

        if ($result['result'] == true) {

          $subj_id = $result['subject_id'];


          $rateArr = array();

          if (!empty($data['rate'])) {
            foreach ($data['rate'] as $key => $value) {
              $rateArr[] = array(
                "rate_num" => $value['rate_num'],
                "subj_id"  => $subj_id,
                "rn_id"    => $value['rn_id']
              );
            }
            $this->db->insert_batch('rate_percentage_subj', $rateArr);
          }
        }
      } else {
        $result = $subject->modify($data['subj_id'], $data);
        if ($result['result'] == true) {

        }
      }
      echo json_encode(array("result" => $result['result'], "type" => $result['type']));
    }
  }

  private function isCodeExist($code){
    $subject = new Subject;

    $search = $subject->search(array('subj_code' => $code));

    if (!empty($search)) {
      $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');

      return false;
    } else {
      return true;
    }
  }

  private function saveSplit($num, $subj_id){
    $split = new Split_no_per_week;
    $data = array("number" => $num, "subj_id" => $subj_id);
    $split->add($data);
  }

  public function subjectEdit(){
    $this->load->model("Rate_percentage_subj");

    $subject = new Subject;
    $rate = new Rate_percentage_subj;

    $subj_id = $this->input->get("subj_id");

    $data = $subject->show(array('subject.subj_id' => $subj_id));
    $rates = $rate->search(array("subj_id" => $subj_id));

    echo json_encode(["subjData" => $data, "rate" => $rates]);
  }

  public function subjectDelete(){
    $subject = new Subject();
    $subj_id = $this->input->get('subj_id');
    $result = $subject->remove(array("subj_id" => $subj_id));
    echo json_encode(array("result" => $result));
  }

  private function get_snpw_id($subj_id){
    $split = new Split_no_per_week;
    $data = $split->search(array('subj_id' => $subj_id));
    foreach ($data as $key => $value) {
      return $value->snpw_id;
    }
  }

  // INSTRUCTOR METHOD //
  public function get_instructor_list(){
    $instructor = new InstructorModel;
    $list = $instructor->get_list();
    // echo json_encode(array('data'=>$list));
    
    echo json_encode($list);
  }

  public function get_instuctor_sched(){
    $sem = $this->input->get('sem');

    $sy = $this->input->get('sy');

    $ins_id = $this->input->get('ins_id');


    $semister = array("1st Semester" => "First Semester", "2nd Semester" => "Second Semester");

    $instructor = new InstructorModel;

    $sched = $this->db->query("
        SELECT 
        * 
        FROM subj_sched_day
        INNER JOIN sched_subj ON subj_sched_day.ss_id = sched_subj.ss_id
        INNER JOIN room_list ON subj_sched_day.rl_id = room_list.rl_id
        INNER JOIN sched_day ON subj_sched_day.sd_id = sched_day.sd_id
        INNER JOIN `subject` ON sched_subj.subj_id = `subject`.subj_id
        WHERE sched_subj.employee_id = '{$ins_id}'
        AND sched_subj.sem = '{$semister[$sem]}'
        AND sched_subj.sy = '{$sy}'
      ");

    $list = $sched->result();

    $data = array();

    if(!empty($list)) {
      foreach ($list as $key => $value) {
        $data[] = array(
          "title"       => "{$value->subj_code}",
          "start"       => date("Y-m-d {$value->time_start}", strtotime("{$value->composition} this week")),
          "end"         => date("Y-m-d {$value->time_end}", strtotime("{$value->composition} this week")),
          "allDay"      => false,
          "color"       => "rgb(0, 133, 178)",
          "textColor"   => "#FFF",
          "time_start"  => date_format(date_create($value->time_start), 'h:i A'),
          "time_end"    => date_format(date_create($value->time_end), 'h:i A'),
          "composition" => $value->composition,
          "subject"     => $value->subj_name,
          "room"        => $value->room_code
        );
      }
    }
    echo json_encode($data);
  }

  // OTHER SCHED METHOD
  public function otherSave(){
    $other = new Other_sched;
    $data = $this->input->post();
    $result = "";

    if ($this->input->post('os_id') == "") {
      $result = $other->add($data);
    } else {
      $result = $other->modify($data['os_id'], $data);
    }
    echo json_encode(array("result" => $result['result'], "type" => $result['type']));
  }

  public function otherList(){
    $other = new Other_sched;
    $list = $other->show();
    echo json_encode($list);
  }

  public function otherDelete(){
    $other = new Other_sched();
    $os_id = $this->input->get('os_id');
    $result = $other->remove(array("os_id" => $os_id));
    echo json_encode(array("result" => $result));
  }

  public function otherEdit(){
    $other = new Other_sched;
    $os_id = $this->input->get('os_id');
    $data = $other->show(array('os_id' => $os_id));
    echo json_encode($data);
  }

  public function rate(){
    $this->load->model("Rate_source");
    $rate = new Rate_source;

    echo json_encode($rate->get());
  }

  // -------------------------------------------------------------- PROGRAM ---------------------------------------------------------

  public function programList(){

    $this->load->model("Program_list");
    $pl = new Program_list();
    $data = array();
    $result = $pl->all();
    if (!empty($result)) {
      $data = $result;
    }
    echo json_encode($result);

    // $pl->toJoin = ["Department"=>"Program_list", "Usage_status"=>"Program_list"];
    // $list = $pl->get();
    // dd($list);

    // if(!empty($list)){
    //     foreach ($list as $key => $value) {
    //        $value->prog_name = ucwords($value->prog_name);
    //        $value->level = ucwords($value->level);
    //        $value->major = ucwords($value->major);
    //        $value->prog_type = ucwords($value->prog_type);
    //        $value->dep_name = ucwords($value->dep_name);
    //     }
    //     echo json_encode($list);
    // }
  }

  public function addProgram(){

    $this->form_validation->set_rules('prog_name', 'Program Name', 'required|callback_is_program_exist');
    $this->form_validation->set_rules('prog_abv', 'Program Abbreviation', 'required|callback_is_abv_exist');
    $this->form_validation->set_rules('prog_code', 'Program Code', 'required|callback_is_code_exist');
    $this->form_validation->set_rules('prog_type', 'Program Type', 'required');
    $this->form_validation->set_rules('level', 'Level', 'required');
    $this->form_validation->set_rules('dep_id', 'Department', 'required');

    if ($this->form_validation->run() == false) {
      echo json_encode(["result" => strip_tags(validation_errors())]);
    } else {
      $this->load->model("Program_list");
      $this->load->model("Usage_status");

      $usage = new Usage_status();
      $pl = new Program_list();

      $data = $this->input->post();

      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');

      $this->db->trans_begin();

      $pl->saveProgram($data);
      $pl_id = $pl->db->insert_id();

      // SAVE PROGRAM STATUS
      $usage->pl_id = $pl_id;
      $usage->status = "active";
      $usage->save();

      if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();
        echo json_encode(["result" => false]);
      } else {
        $this->db->trans_commit();
        echo json_encode(["result" => true]);
      }
    }
  }

  public function is_program_exist($str){
    $this->load->model("Program_list");
    $pl = new Program_list;

    $search = $pl->search(["prog_name" => $str]);
    if (!empty($search)) {
      $this->form_validation->set_message('is_program_exist', 'The {field} must be unique.');

      return false;
    } else {
      return true;
    }
  }

  public function is_abv_exist($str){

    $this->load->model("Program_list");
    $pl = new Program_list;

    $search = $pl->search(["prog_abv" => $str]);
    if (!empty($search)) {
      $this->form_validation->set_message('is_abv_exist', 'The {field} must be unique.');

      return false;
    } else {
      return true;
    }
  }

  public function is_code_exist($str){
    $this->load->model("Program_list");
    $pl = new Program_list;

    $search = $pl->search(["prog_code" => $str]);
    if (!empty($search)) {
      $this->form_validation->set_message('is_code_exist', 'The {field} must be unique.');

      return false;
    } else {
      return true;
    }
  }

  public function is_dep_exist($str){
    $this->load->model("Department");
    $pl = new Department;

    $search = $pl->search(["dep_name" => $str]);
    if (!empty($search)) {
      $this->form_validation->set_message('is_dep_exist', 'The {field} must be unique.');

      return false;
    } else {
      return true;
    }
  }

  public function addDepartment(){

    $this->load->model("Department");
    $dep = new Department;

    $this->form_validation->set_rules('dep_name', 'Department Name', 'required|callback_is_dep_exist');

    if ($this->form_validation->run() == false) {
      echo json_encode(["result" => strip_tags(validation_errors())]);
    } else {
      $data = $this->input->post();
      if (!empty($data)) {
        foreach ($data as $key => $value) {
          $dep->$key = $value;
        }
        $dep->save();

        if ($dep->db->affected_rows()) {
          echo json_encode(["result" => true, "last" => $this->loadDepartmentLastInput()]);
        } else {
          echo json_encode(["result" => false]);
        }
      }
    }
  }

  private function loadDepartmentLastInput(){
    $this->load->model("Department");
    $dep = new Department;

    $dep->db->order_by("dep_id", "DESC");
    $dep->db->limit(1);
    $last = $dep->get();

    if (!empty($last)) {
      foreach ($last as $key => $value) {
        return [$value->dep_id, $value->dep_name];
      }
    }
  }

  public function programAcronym(){
    $phrase = $this->input->post("prog_name");
    echo set_acronym($phrase);
  }

  public function modifyProgram(){
    $this->load->model("Program_list");
    $pl = new Program_list;

    $pl_id = $this->input->get("pl_id");

    $data = $pl->search(["pl_id" => $pl_id]);

    foreach ($data as $key => $value) {

      $this->prevProg_name = $value->prog_name;
      $this->prevProg_abv = $value->prog_abv;
      $this->prevProg_code = $value->prog_code;
      $this->prevpl_id = $value->pl_id;

    }
    echo json_encode($data);
  }

  public function updateProgram(){

    $this->form_validation->set_rules('prog_name', 'Program Name', 'required|callback_is_program_exist_update[' . $this->input->post("pl_id") . ']');
    $this->form_validation->set_rules('prog_abv', 'Program Abbreviation', 'required|callback_is_abv_exist_update[' . $this->input->post("pl_id") . ']');
    $this->form_validation->set_rules('prog_code', 'Program Code', 'required|callback_is_code_exist_update[' . $this->input->post("pl_id") . ']');
    $this->form_validation->set_rules('prog_type', 'Program Type', 'required');
    $this->form_validation->set_rules('level', 'Level', 'required');
    $this->form_validation->set_rules('dep_id', 'Department', 'required');

    if ($this->form_validation->run() == false) {
      echo json_encode(["result" => strip_tags(validation_errors())]);
    } else {
      $this->load->model("Program_list");
      $pl = new Program_list;

      $this->db->trans_begin();

      $pl->load($this->input->post("pl_id"));
      $pl->prog_code = $this->input->post("prog_code");
      $pl->prog_abv = $this->input->post("prog_abv");
      $pl->prog_name = $this->input->post("prog_name");
      $pl->prog_desc = $this->input->post("prog_desc");
      $pl->prog_type = $this->input->post("prog_type");
      $pl->level = $this->input->post("level");
      $pl->major = $this->input->post("major");
      $pl->dep_id = $this->input->post("dep_id");
      $pl->save();

      if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();
        echo json_encode(["result" => false]);
      } else {
        $this->db->trans_commit();
        echo json_encode(["result" => true]);
      }
    }
  }

  public function is_program_exist_update($str, $pl_id){

    $this->load->model("Program_list");
    $pl = new Program_list;

    $search = $pl->search(["pl_id" => $pl_id]);

    if (!empty($search)) {
      foreach ($search as $key => $value) {

        if ($value->prog_name == $str) {
          return true;
        } else {
          $dup = $pl->search(["prog_name" => $str]);
          if (!empty($dup)) {
            $this->form_validation->set_message('is_program_exist_update', 'The {field} must be unique.');

            return false;
          } else {
            return true;
          }
        }
      }
    }
  }

  public function is_abv_exist_update($str, $pl_id){

    $this->load->model("Program_list");
    $pl = new Program_list;

    $search = $pl->search(["pl_id" => $pl_id]);

    if (!empty($search)) {
      foreach ($search as $key => $value) {

        if ($value->prog_abv == $str) {
          return true;
        } else {
          $dup = $pl->search(["prog_abv" => $str]);
          if (!empty($dup)) {
            $this->form_validation->set_message('is_abv_exist_update', 'The {field} must be unique.');

            return false;
          } else {
            return true;
          }
        }
      }
    }
  }

  public function is_code_exist_update($str, $pl_id){

    $this->load->model("Program_list");
    $pl = new Program_list;

    $search = $pl->search(["pl_id" => $pl_id]);

    if (!empty($search)) {
      foreach ($search as $key => $value) {

        if ($value->prog_abv == $str) {
          return true;
        } else {
          $dup = $pl->search(["prog_code" => $str]);
          if (!empty($dup)) {
            $this->form_validation->set_message('is_code_exist_update', 'The {field} must be unique.');

            return false;
          } else {
            return true;
          }
        }
      }
    }
  }

  public function changeProgStatus(){

    $this->load->model("Usage_status");
    $usage = new Usage_status;

    $status = $this->input->get("status");
    $pl_id = $this->input->get("pl_id");

    $this->db->trans_begin();

    $usage->db->where('pl_id', $pl_id);
    $usage->db->update("sis_main_db.usage_status", ["status" => $status]);

    if ($this->db->trans_status() === false) {
      $this->db->trans_rollback();
      echo json_encode(["result" => false]);
    } else {
      $this->db->trans_commit();
      echo json_encode(["result" => true]);
    }
  }
}
