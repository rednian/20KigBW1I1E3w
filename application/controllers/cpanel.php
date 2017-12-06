<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cpanel extends MY_Controller
{

  public function __construct()
  {

    parent::__construct();

    $this->load->model("User");
    $this->load->model("Stud_load_cap_set");
    $this->load->model("Block_section");
    $this->load->model("Sched_subj");
    $this->load->model("Department");
    $this->load->model("curr_codelist");
    $this->load->model("subj_sched_day");

  }

  public function index(){

    $this->load->model("User_type");
    $type = new User_type;

    $cur = new Curr_codelist();

    $data['user_type'] = $type->get();
    $data['department'] = $this->department();
    $data['curriculum'] = $cur->active_curriculum();
    $data['title'] = 'C-Panel';





    $this->load->view('includes/header', $data);
    $this->load->view('includes/menu');
    $this->load->view('cpanel/css');
    $this->load->view('cpanel/index', $data);
    $this->load->view('includes/footer');
    $this->load->view('includes/js');
    $this->load->view('cpanel/js');

  }

  public function department(){
    $query = $this->db->query("SELECT * FROM department");
    $result = $query->result();

    if (!empty($result)) {
      return $result;
    } else {
      return array();
    }
  }

  public function saveUser()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[5]',
        array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]',
        array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));

      if ($this->form_validation->run() == FALSE) {
        $errors = validation_errors();
        echo json_encode(["result" => "validateError", "errors" => $errors]);
      } else {
        $user = new User();
        $data = $this->security->xss_clean($this->input->post());
        foreach ($data as $key => $value) {

          $data['username'] = escape_str($this->input->post('username'));
          $data['password'] = doEncrypt(escape_str($this->input->post('password')));
          $data['user_fname'] = escape_str($this->input->post('user_fname'));
          $data['user_lname'] = escape_str($this->input->post('user_lname'));
          $data['user_mname'] = escape_str($this->input->post('user_mname'));
          $data['user_department'] = escape_str($this->input->post('user_department'));
          $data['user_position'] = escape_str($this->input->post('user_position'));
          $data['user_image'] = "default.png";
          $data['user_status'] = "active";
          $data['dep_id'] = escape_str($this->input->post('dep_id'));
        }
        if ($data['user_id'] != "") {
          $result = $user->modify($data['user_id'], $data);
          echo json_encode(array("result" => $result, "type" => "updated"));
        } else {
          $result = $user->add($data);
          echo json_encode(array("result" => $result, "type" => "saved"));
        }
      }

    } else {
      show_404();
    }
  }

  public function userList()
  {
    $user = new User;
    $list = $user->get_user();
    // $list = $user->data_table();
    $data = array();


    if (!empty($list)) {
      foreach ($list as $temp) {
        $data[] = array(
          'name' => ucwords($temp->user_fname) . ' ' . ucwords($temp->user_lname),
          'username' => $temp->username,
          'department' => ucwords($temp->user_department),
          'position' => ucwords($temp->user_position),
          'id' => $temp->user_id

        );
      }
    }

    $result_set = array(
      // 'draw'=> (int)$this->input->get('draw'),
      // 'recordsTotal'=> count($user->get_all_data()),
      // 'recordsFiltered'=>count($data),
      'data' => $data,
    );

    echo json_encode($result_set);
  }

  public function deleteUser()
  {
    $user = new User;
    $userID = $this->input->get('user_id');
    $result = $user->remove($userID);
    echo json_encode(array("result" => $result));
  }

  public function editUser()
  {
    $user = new User;
    $user_id = $this->input->get('user_id');
    $list = $user->get_user(array("user_id" => $user_id));
    foreach ($list as $key => $value) {
      $value->password = doDecrypt($value->password);
    }
    echo json_encode($list);
  }

  // --------------------------------- SLCS -------------------------------- //

  public function saveSLCS()
  {

    $this->form_validation->set_rules('student_type', 'Student type', 'required|is_unique[Stud_load_cap_set.student_type]',
      array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));
    $this->form_validation->set_rules('unit_capacity', 'No of units', 'required|is_natural_no_zero',
      array('required' => 'You must provide a %s.', 'is_unique' => '%s already exist.'));

    if ($this->form_validation->run() == FALSE) {
      $errors = validation_errors();
      echo json_encode(["result" => "validateError", "errors" => $errors]);
    } else {
      $slcs = new Stud_load_cap_set;
      $data = $this->input->post();
      $type = "saved";

      if (!empty($data)) {

        if ($data['slcs_id'] != "") {
          $slcs->load($data['slcs_id']);
          $type = "updated";
        }

        foreach ($data as $key => $value) {
          if ($key != "slcs_id") {
            $slcs->$key = $value;
          }
        }

        $slcs->save();
        if ($slcs->db->affected_rows() > 0 || $slcs->db->affected_rows() == 0) {
          echo json_encode(array("result" => true, "type" => $type));
        } elseif ($slcs->db->affected_rows() == 0) {
          echo json_encode(array("result" => false, "type" => $type));
        }
      }
    }

  }

  public function loadSLCS()
  {
    $slcs = new Stud_load_cap_set;
    $list = $slcs->get();
    echo json_encode($list);
  }

  public function deleteSLCS()
  {
    $slcs = new Stud_load_cap_set;
    $slcs_id = $this->input->get('slcs_id');
    $slcs->load($slcs_id);
    $slcs->delete();

    if ($slcs->db->affected_rows() > 0) {
      echo json_encode(array("result" => true));
    } else {
      echo json_encode(array("result" => false));
    }
  }

  public function editSLCS()
  {
    $slcs = new Stud_load_cap_set;
    $slcs_id = $this->input->get('slcs_id');
    $info = $slcs->search(array("slcs_id" => $slcs_id));
    echo json_encode($info);
  }

  // ---------------------------- SECTION SETTINGS -----------------------------------------//

  public function activeCurriculum()
  {

    $sy = $this->input->get("sy");
    $sem = $this->input->get("sem");

    $query = $this->db->query("SELECT
                                    curr_codelist.*, program_list.prog_name,major,
                                    prog_abv
                                FROM
                                    curr_codelist,
                                    program_list
                                WHERE
                                    curr_codelist.status = 'active' AND
                                    curr_codelist.eff_sy = '$sy' AND
                                    curr_codelist.eff_sem = '$sem'
                                AND program_list.dep_id = {$this->userInfo->dep_id}
                                AND curr_codelist.pl_id = program_list.pl_id");

    $list = $query->result();

    $tblData = array();

    foreach ($list as $key => $value) {

      $tblData[] = array($value->cur_id, "<span class=\"f-s-15\">" . strtoupper($value->prog_abv) . " - </span>" . ucwords($value->major) . "
                          <ul class=\"m-b-0\">
                            <li><small>" . $value->eff_sem . " SY: " . $value->eff_sy . "</small></li>
                          </ul>", $value->pl_id, $value->eff_sem, $value->eff_sy);
    }

    echo json_encode($tblData);
  }

  public function loadBlockSection()
  {
    $block = new Block_section;

    $semister = array("1st Semester" => "First Semester", "2nd Semester" => "Second Semester");

    $pl_id = $this->input->get('pl_id');
    $sem = $this->input->get('sem');
    $sy = $this->input->get('sy');

    $list = $block->search(array("pl_id" => $pl_id, "semister" => $semister[$sem], "sy" => $sy));
    if (!empty($list)) {
      echo json_encode($list);
    } else {
      echo json_encode(array());
    }
  }

  public function loadOffSection()
  {
    $semister = array("1st Semester" => "First Semester", "2nd Semester" => "Second Semester");
    $block = new Block_section;
    $sy = $this->input->get("sy");
    $sem = $this->input->get("sem");

    $list = $block->search(array("pl_id" => 0, "sy" => $sy, "semister" => $semister[$sem]));
    if (!empty($list)) {
      echo json_encode($list);
    } else {
      echo json_encode(array());
    }
  }

  public function loadSubject()
  {
    $sched_subj = new Sched_subj;
    $status = "";

    $bs_id = $this->input->get("bs_id");

    $sched_subj->toJoin = array("Subject" => "Sched_subj");
    $sched_subj->db->group_by("sched_subj.subj_id");
    $list = $sched_subj->search(array("bs_id" => $bs_id));


    foreach ($list as $key => $value) {
      if ($value->employee_id != "") {
        $value->status = "taken";
      } else {
        $value->status = "vacant";
      }
    }
    echo json_encode($list);
  }

  public function changeStatusSection()
  {
    $section = new Block_section;
    $bs_id = $this->input->get('bs_id');
    $status = $this->input->get('status');
    $stat = "";
    $sec = $section->search(array("bs_id" => $bs_id));
    foreach ($sec as $key => $value) {
      if ($value->activation == "open") {
        $stat = "close";
      } else {
        $stat = "open";
      }
    }

    $section->load($bs_id);
    $section->activation = $stat;
    $section->save();

    if ($section->db->affected_rows() > 0) {
      echo json_encode(array("result" => true));
    } else {
      echo json_encode(array("result" => false));
    }
  }

  // ------------------------------------ COURSE STATUS ------------------------------------------------------//

  public function courseStatusLoadAllSection()
  {

    $type = $this->input->get('type');
    $sy = $this->input->get('sy');
    $sem = $this->input->get('sem');

    $str = "SELECT
                    block_section.*, program_list.prog_name,
                    prog_code,prog_abv,
                    major
                FROM
                    block_section
                LEFT JOIN program_list ON program_list.pl_id = block_section.pl_id
                WHERE
                    block_section.semister = '{$sem}'
                AND block_section.sy = '{$sy}'";

    if ($type == "#block") {
      $str .= " AND block_section.pl_id != 0 AND program_list.dep_id = {$this->userInfo->dep_id}";
    } elseif ($type == "#off") {
      $str .= " AND block_section.pl_id = 0";
    }

    $query = $this->db->query($str);
    $list = $query->result();

    if (!empty($list)) {
      echo json_encode($list);
    } else {
      echo json_encode(array());
    }
  }

  public function courseStatusLoadSubject()
  {
    $sched_subj = new Sched_subj;
    $status = "";

    $bs_id = $this->input->get("bs_id");

    $sched_subj->toJoin = array("Subject" => "Sched_subj");
    $sched_subj->db->group_by("sched_subj.subj_id");
    $list = $sched_subj->search(array("bs_id" => $bs_id));


    foreach ($list as $key => $value) {
      $value->enrolled = $this->courseStatusCountEnrolled($value->ss_id);
      $value->class_schedule = $this->courseStatusGetSubjectSchedule($value->subj_id, $value->bs_id);
      $value->declaration = $this->getDeclarationStatus($value->ss_id);
    }
    echo json_encode($list);

  }

  private function courseStatusGetSubjectSchedule($subj_id, $bs_id)
  {
    $sched_subj = new Subj_sched_day();

    $sched_subj->toJoin = array(
      "Room_list" => "subj_sched_day",
      "Sched_day" => "subj_sched_day",
      "Sched_subj" => "subj_sched_day"
    );

    $sched['Lecture'] = array();
    $sched['Laboratory'] = array();

    $list = $sched_subj->search(array("bs_id" => $bs_id, "subj_id" => $subj_id));

    foreach ($list as $key => $value) {
      if ($value->type == "Lecture") {

        $sched['Lecture'][] = array(
          "ss_id" => $value->ss_id,
          "rl_id" => $value->rl_id,
          "sd_id" => $value->sd_id,
          "start" => $value->time_start,
          "end" => $value->time_end,
          "room" => $value->room_code,
          "sched" => $value->abbreviation,
          "time_start" => date_format(date_create($value->time_start), "h:i A"),
          "time_end" => date_format(date_create($value->time_end), "h:i A"),
        );
      } elseif ($value->type == "Laboratory") {

        $sched['Laboratory'][] = array(
          "ss_id" => $value->ss_id,
          "rl_id" => $value->rl_id,
          "sd_id" => $value->sd_id,
          "start" => $value->time_start,
          "end" => $value->time_end,
          "room" => $value->room_code,
          "sched" => $value->abbreviation,
          "time_start" => date_format(date_create($value->time_start), "h:i A"),
          "time_end" => date_format(date_create($value->time_end), "h:i A"),
        );
      }
    }
    return $sched;
  }

  private function courseStatusCountEnrolled($ss_id)
  {
    $query = $this->db->query("SELECT * FROM subject_enrolled where ss_id = {$ss_id}");
    $list = $query->result();

    $count = 0;
    if (!empty($list)) {
      $count = count($list);
    }
    return $count;
  }

  public function changeSubjectStatus()
  {

    $this->load->model("Subject_declaration");
    $sd = new Subject_declaration;

    $ss_id = $this->input->get("ss_id");
    $status = $this->input->get("status");

    // CHECK IF SS_ID EXIST
    $declaration = $sd->search(["ss_id" => $ss_id]);

    if (empty($declaration)) {
      // SAVE DECLARATION
      $sd->ss_id = $ss_id;
      $sd->declaration = $status;
      $sd->save();

      if ($sd->db->affected_rows() > 0) {
        echo json_encode(["result" => true]);
      } else {
        echo json_encode(["result" => false]);
      }
    } else {
      // UPDATE DECLARATION
      foreach ($declaration as $key => $value) {

        $sd_id = $value->sd_id;

        $sd->load($sd_id);
        $sd->declaration = $status;
        $sd->save();

        if ($sd->db->affected_rows() >= 0) {
          echo json_encode(["result" => true]);
        } else {
          echo json_encode(["result" => false]);
        }
      }
    }
  }

  private function getDeclarationStatus($ss_id)
  {

    $this->load->model("Subject_declaration");
    $sd = new Subject_declaration;

    $declaration = $sd->search(["ss_id" => $ss_id]);

    if (!empty($declaration)) {
      foreach ($declaration as $key => $value) {

        $color = array("tutorial" => "label-warning", "bridge" => "label-info", "dissolve" => "label-danger");
        return "<span class='label " . $color[$value->declaration] . "'>" . ucwords($value->declaration) . "</span>";
      }
    } else {
      return "";
    }

  }

}
