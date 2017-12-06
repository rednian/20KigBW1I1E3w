<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends MY_Controller {

  	public function __construct(){
		parent::__construct();
		$this->load->model("InstructorModel");
		$this->load->model("Curr_codelist");
		$this->load->model("Block_section");
        $this->load->model("Sched_subj");
		$this->load->model("subj_sched_day");
	}

  	public function index()
	{
        $cur = new Curr_codelist();

        $data['title'] = 'Instructor Course Loading';
        $data['curriculum'] = $cur->active_curriculum();

		$this->load->view('includes/header',$data);
		$this->load->view('includes/menu');
		$this->load->view('instructor/css');
		$this->load->view('instructor/index');
		$this->load->view('includes/footer');
		$this->load->view('includes/js');
		$this->load->view('instructor/js');
	}

    public function printCalendar(){

        $ins_id = $this->input->get("ins");
        $sem = $this->input->get("sem");
        $sy = $this->input->get("sy");
       
        $instructor = new InstructorModel;
    
        $sched = $instructor->db->query("
                    SELECT
                    *
                    FROM subj_sched_day
                    INNER JOIN sched_day ON subj_sched_day.sd_id = sched_day.sd_id
                    INNER JOIN room_list ON subj_sched_day.rl_id = room_list.rl_id
                    INNER JOIN sched_subj ON subj_sched_day.ss_id = sched_subj.ss_id
                    INNER JOIN `subject` ON sched_subj.subj_id = `subject`.subj_id
                    WHERE
                    sched_subj.employee_id = '{$ins_id}'
                    AND sched_subj.sem = '{$sem}'
                    AND sched_subj.sy = '{$sy}'
                    AND sched_subj.avs_status = 'active'
                    -- 
                                        ");
        $list = $sched->result();
        $sub = array();
        foreach ($list as $key => $value) {
            $sub[] = array(
                "bs_id"=>$value->bs_id,
                "subj_id"=>$value->subj_id,
                "title" => "{$value->subj_code} - {$value->room_code}",
                "start" => date("Y-m-d {$value->time_start}", strtotime("{$value->composition} this week")),
                "end" => date("Y-m-d {$value->time_end}", strtotime("{$value->composition} this week")),
                "allDay" => false,
                "color" => "rgb(0, 133, 178)",
                "textColor" => "#FFF",
                "time_start" => date_format(date_create($value->time_start), 'h:i A'),
                "time_end" => date_format(date_create($value->time_end), 'h:i A'),
                "composition" => $value->composition,
                "subject" => $value->subj_name,
                "room" => $value->room_code
            );
        }
        $data['sched'] = $sub;
        $this->load->view("instructor/print", $data);
    }

  	public function listInstructor()
    {
    	$instructor = new InstructorModel;
        $list = $instructor->get_list();
        echo json_encode($list);
    }

    public function activeCurriculum(){
    	
        $query = $this->db->query("
                        SELECT
							curr_codelist.*, program_list.prog_name,major,
							prog_abv
						FROM
							curr_codelist,
							program_list
						WHERE
							curr_codelist. STATUS = 'active'
                        AND program_list.dep_id = {$this->userInfo->dep_id}
						AND curr_codelist.pl_id = program_list.pl_id"
                    );

    	$list = $query->result();
    	$tblData = array();
    	foreach ($list as $key => $value) {
    		$tblData[] = array($value->cur_id,"<span class=\"f-s-15\">".strtoupper($value->prog_abv)." - </span>".ucwords($value->major)."
    					  <ul class=\"m-b-0\">
    						<li><small>".$value->eff_sem." SY: ".$value->eff_sy."</small></li>
    					  </ul>",$value->pl_id,$value->eff_sem,$value->eff_sy);
    	}
    	echo json_encode($tblData);
    }

    public function loadBlockSection(){
    	$block = new Block_section();

    	$semister = array("1st Semester"=>"First Semester", "2nd Semester"=>"Second Semester");

    	$request = $this->input->get();
    	
    	$list = $block->search(array("cur_id"=>$request['cur_id']));
    	if(!empty($list)){
    		echo json_encode($list);
    	}
    	else{
    		echo json_encode(array());
    	}  
    }

    public function loadOffSection(){
    	$block = new Block_section;
    	$list = $block->search(array("pl_id"=>0));
    	if(!empty($list)){
    		echo json_encode($list);
    	}
    	else{
    		echo json_encode(array());
    	}
    }

    public function loadSubject(){
    	$sched_subj = new Sched_subj;
        $status = "";

    	$bs_id = $this->input->get("bs_id");
    	$sched_subj->toJoin = array("Subject"=>"Sched_subj");
    	$sched_subj->db->group_by("sched_subj.subj_id");

    	$list = $sched_subj->search(array("bs_id"=>$bs_id));

        foreach ($list as $key => $value) {
           if($value->employee_id != ""){
                $value->status = "taken";
           }
           else{
                $value->status = "vacant";
           }
        }
        echo json_encode($list);
    }

    public function loadAllSubject(){
        $sched_subj = new Sched_subj;
        $sched_subj->toJoin = array("Subject"=>"Sched_subj", "Block_section"=>"Sched_subj");
        $sched_subj->db->group_by("sched_subj.bs_id");
        $sched_subj->db->group_by("sched_subj.subj_id");
        $sched_subj->db->order_by("subject.subj_name", "ASC");
        $list = $sched_subj->get();

        foreach ($list as $key => $value) {
           if($value->employee_id != ""){
                $value->status = "taken";
           }
           else{
                $value->status = "vacant";
           }
        }
        echo json_encode($list);
    }

    public function get_instuctor_sched()
    {
        $sem = $this->input->get('sem');
        $sy = $this->input->get('sy');
        $ins_id = $this->input->get('ins_id');


        $instructor = new InstructorModel();
            $sched =$instructor->db->query("
                SELECT 
                * 
                FROM subj_sched_day
                INNER JOIN sched_subj ON subj_sched_day.ss_id = sched_subj.ss_id
                INNER JOIN room_list ON subj_sched_day.rl_id = room_list.rl_id
                INNER JOIN sched_day ON subj_sched_day.sd_id = sched_day.sd_id
                INNER JOIN `subject` ON sched_subj.subj_id = `subject`.subj_id
                WHERE sched_subj.employee_id = '{$ins_id}'
                AND sched_subj.sem = '{$sem}'
                AND sched_subj.sy = '{$sy}'
                ");
            $result = $sched->result();

        $sub = array();

        foreach ($result as $key => $value) {
            $sub[] = array(
                "bs_id"=>$value->bs_id,
                "subj_id"=>$value->subj_id,
                "title" => "{$value->subj_code} - {$value->room_code}",
                "start" => date("Y-m-d {$value->time_start}", strtotime("{$value->composition} this week")),
                "end" => date("Y-m-d {$value->time_end}", strtotime("{$value->composition} this week")),
                "allDay" => false,
                "color" => "rgb(0, 133, 178)",
                "textColor" => "#FFF",
                "time_start" => date_format(date_create($value->time_start), 'h:i A'),
                "time_end" => date_format(date_create($value->time_end), 'h:i A'),
                "composition" => $value->composition,
                "subject" => $value->subj_name,
                "room" => $value->room_code
            );
        }
        echo json_encode($sub);
    }

    public function getSubjectSchedule(){
        $sched_subj = new Subj_sched_day();

        $subj_id = $this->input->get('subj_id');
        $bs_id = $this->input->get('bs_id');

        $sched_subj->toJoin = array(
                                "room_list"=>"subj_sched_day",
                                "sched_subj"=>"subj_sched_day",
                                "sched_day"=>"subj_sched_day"
                                );

        $sched['Lecture'] = array();
        $sched['Laboratory'] = array();

        $list = $sched_subj->search(array("bs_id"=>$bs_id, "subj_id"=>$subj_id));

        foreach ($list as $key => $value) {
            if($value->type == "Lecture"){

                $sched['Lecture'][] = array(
                                            "ss_id"=>$value->ss_id,
                                            "rl_id"=>$value->rl_id,
                                            "sd_id"=>$value->sd_id,
                                            "start"=>$value->time_start,
                                            "end"=>$value->time_end,
                                            "room"=>$value->room_code,
                                            "sched"=>$value->abbreviation,
                                            "time_start"=>date_format(date_create($value->time_start), "h:i A"),
                                            "time_end"=>date_format(date_create($value->time_end), "h:i A"),
                                            );
            }
            elseif($value->type == "Laboratory"){
                
                $sched['Laboratory'][] = array(
                                            "ss_id"=>$value->ss_id,
                                             "rl_id"=>$value->rl_id,
                                            "sd_id"=>$value->sd_id,
                                            "start"=>$value->time_start,
                                            "end"=>$value->time_end,
                                            "room"=>$value->room_code,
                                            "sched"=>$value->abbreviation,
                                            "time_start"=>date_format(date_create($value->time_start), "h:i A"),
                                            "time_end"=>date_format(date_create($value->time_end), "h:i A"),
                                            );
            }
        }
        echo json_encode($sched);
    }

    public function giveInSchedule(){

        $employee_id = $this->input->get('employee_id');

        $data = $this->input->get('data');

        $hasConflict = false;
        $transResult = array();



        foreach ($data as $key => $value) {

            $rl_id = $value['rl_id'];
            $time_end = $value["time_end"];
            $time_start = $value['time_start'];
            $sd_id = $value['sd_id'];
            
            $query = $this->db->query("
                            SELECT *
                            FROM subj_sched_day
                            INNER JOIN sched_subj ON subj_sched_day.ssd_id = sched_subj.ss_id
                            WHERE subj_sched_day.rl_id = {$rl_id}
                            AND subj_sched_day.sd_id = {$sd_id} 
                            AND sched_subj.employee_id = '{$employee_id}'
                            AND (
                                subj_sched_day.time_start <= '{$time_end}' 
                                AND subj_sched_day.time_end >= '{$time_start}'
                                )
                            ");
          

            $result = $query->result();


             if(!empty($result)){
                $hasConflict = true;
                break;
             }
        }

      
        if ($hasConflict) {
            $transResult = array("result"=>"hasConflict");
        }
        elseif(!$hasConflict){
            foreach ($data as $key => $value) {
                $sched = new Sched_subj;
                $sched->load($value['ss_id']);
                $sched->employee_id = $employee_id;
                $sched->save();
            }
            $transResult = array("result"=>"updated");
        }
        echo json_encode($transResult);
    }

    public function removeSubjectFromInstructor(){
        $sched = new Sched_subj;

        $subj_id = $this->input->get("subj_id");
        $bs_id = $this->input->get("bs_id");
        
        $result = $this->db->simple_query("UPDATE sched_subj set employee_id='' WHERE subj_id = {$subj_id} AND bs_id = {$bs_id}");
        echo json_encode(array("result"=>$result));
    }
    
}
