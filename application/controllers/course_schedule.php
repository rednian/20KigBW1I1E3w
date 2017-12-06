<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_schedule extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Subject');
        $this->load->model('Room_list');
        $this->load->model("Sched_subj");
        $this->load->model("Sched_day");
        $this->load->model("Block_section");
        $this->load->model("Plotted_time");
    }
	
	public function index()
	{

        $this->load->model('Sched_time');
        $time = new Sched_time;
        $plot = new Plotted_time;
        $day = new Sched_day;
        $room = new Room_list;

        $time->load_last_input();
        $plotted = $plot->search(["st_id"=>$time->st_id]);
        
        $data['time'] = $time;
        $data['programList'] = $this->programList();
        $data['lectureRooms'] = $this->getRooms("Lecture");
        $data['labRooms'] = $this->getRooms("Laboratory");
        $data['subjectList'] = $this->loadSubjects();
        $data['plotted'] = $plotted;
        $data['days'] = $day->get();
        $data['rooms'] = $room->get();
        $data['title'] = 'Course Schedule';
        
        $this->load->view('includes/header',$data);
        $this->load->view('includes/menu');
        $this->load->view('course_sched/css');
        $this->load->view('course_sched/index', $data);
        $this->load->view('includes/footer');
        $this->load->view('includes/js');
        $this->load->view('course_sched/js');
	}

	public function programList()
    {
        $query = $this->db->query("SELECT * from program_list WHERE dep_id = {$this->userInfo->dep_id}");
        $programs = $query->result();
        return $programs;
    }

    public function getRooms($type)
    {
        $room = new Room_list;
        $list = $room->show(array("type" => $type));
        if (!empty($list)) {
            return $list;
        }
    }

    public function loadSubjects()
    {
        $subject = new Subject;
        $list = $subject->get();
        return $list;
    }

    public function generateSectionCode($length = 5)
    {
        $alphabets = range('A', 'Z');
        $numbers = range('0', '9');

        $final_array = array_merge($alphabets, $numbers);
        $password = '';

        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }
        echo $password;
    }

    public function subject_scheduling(){

    	$type = $this->input->get('type');
        $data = $this->input->get('sched');
    	// $type = "curriculum";
    	// $data = ['program'=>2,"curryearlvl"=>"1st", "currsemister"=>"1st Semester", "currsy"=>"2016-2017"];
        $bs_id = 0;

        $this->db->trans_begin();

        $secExists = $this->isSectionExist($data);

        if(!$secExists){
            $bs = new Block_section;

            $bs->sec_code   = $data["section"];
            $bs->activation = "active";
            $bs->year_lvl   = $data["year"];
            $bs->semister   = $data["semister"];
            $bs->sy         = $data["sy"];
            $bs->pl_id      = $data['program'];
            $bs->save();

            $bs_id = $bs->db->insert_id();
        }

        if($type == "curriculum"){
            $subjects = $this->getCurriculumSubject($data['program'], $data['curryearlvl'], $data['currsemister'], $data['currsy']);
        }
        elseif($type == "subject"){
            $subjects = $data['subjects'];
        }

        $lectSubj = [];
        $labSubj  = [];
        $bss = [];

        if(!empty($subjects)){
        	foreach ($subjects as $key => $value) {
        		if($value["lec_unit"] != "" || $value["lec_unit"] != 0){
                    $bss[] = array(
                                "bs_id"          => $bs_id,
                                "subj_id"        => $value["subj_id"],
                                "type"           => "lec",
                                "remaining_hour" => $value["lec_hour"]
                                );
        		}
        		if($value["lab_unit"] != "" || $value["lab_unit"] != 0){
                    $bss[] = array(
                                "bs_id"          => $bs_id,
                                "subj_id"        => $value["subj_id"],
                                "type"           => "lab",
                                "remaining_hour" => $value["lab_hour"]
                                );

				}		
        	}

            if(!$secExists){
                $this->db->insert_batch("block_section_subjects", $bss);
            }
        }

        if($this->db->trans_status() == true){
             echo json_encode(["result"=>true,"lec"=>$this->getSectionSubjects($bs_id, "lec"), "lab"=>$this->getSectionSubjects($bs_id, "lab"), "bs_id"=>$bs_id, "isExist"=>$secExists]);
            $this->db->trans_commit();
        }
        else{
            echo json_encode(["result"=>false]);
            $this->db->trans_rollback();
        }
       
    }

    private function getSectionSubjects($bs_id, $type){
        $this->load->model("Block_section_subjects");
        $sub = new Block_section_subjects;

        $sub->toJoin = ["Subject"=>"Block_section_subjects", "Block_section"=>"Block_section_subjects"];
        $subjects = $sub->search(["block_section_subjects.bs_id"=>$bs_id, "type"=>$type]);

        if(!empty($subjects)){
            foreach ($subjects as $key => $value) {
                $value->countSched = $this->countSubjectSchedules($value->subj_id, $type, $value->sy, $value->semister);
            }
            return $subjects;
        }
        else{
            return [];
        }
    }

    private function countSubjectSchedules($subj_id, $type, $sy, $sem){

        $this->load->model("Block_section_sched");
        $sched = new Block_section_sched;

        $sched->toJoin = array("Sched_subj"=>"Block_section_sched");
        $sched->db->group_by("block_section_sched.bs_id");
        $schedules = $sched->search(["subj_id"=>$subj_id, "sched_type"=>$type, "sy"=>$sy, "sem"=>$sem]);

        $count = 0;

        if(!empty($schedules)){
            foreach ($schedules as $key => $value) {
                $count++;
            }
        }

        return $count;
    }

    private function isSectionExist($data=[]){
    	$section = new Block_section;

        $prog  = $data["program"];
        $yrlvl = $data["year"];
        $sem   = $data["semister"];
        $sy    = $data["sy"];
        $sec   = $data["section"];

        $result = $section->search(["sec_code"=>$sec, "year_lvl"=>$yrlvl, "semister"=>$sem, "sy"=>$sy, "pl_id"=>$prog]);
    	if(!empty($result)){
            return true;
        }
        else{
            return false;
        }
    }

    private function getCurriculumSubject($pl_id, $y, $s, $sy)
    {
        $subject = new Subject;

        $year = array("1st" => "First Year", "2nd" => "Second Year", "3rd" => "Third Year", "4th" => "Forth Year", "5th" => "Fifth Year");
        $semister = array("1st Semester" => "First Semester", "2nd Semester" => "Second Semester");
        $array = array();
        $query = $subject->db->query("SELECT
										`subject`.subj_id,
										`subject`.subj_code,
										`subject`.subj_name,
										`subject`.subj_desc,
										`subject`.lec_unit,
										`subject`.lab_unit,
                                        `subject`.lec_hour,
                                        `subject`.lab_hour,
                                        `subject`.split,
										split_no_per_week.number
									FROM
										split_no_per_week,
										`subject`,
										year_sem,
										cur_subject,
										curr_codelist
									WHERE
										curr_codelist.pl_id = {$pl_id}
									AND curr_codelist.eff_sy = '{$sy}'
									AND year_sem.`year` = '{$year[$y]}'
									AND year_sem.semister = '{$semister[$s]}'
									AND year_sem.cur_id = curr_codelist.cur_id
									AND year_sem.ys_id = cur_subject.ys_id
									AND cur_subject.subj_id = `subject`.subj_id
									AND split_no_per_week.subj_id = `subject`.subj_id");

        $list = $query->result();
        foreach ($list as $key => $value) {

        	$array[] = array("subj_id"=>$value->subj_id,
        					 "subj_code"=>$value->subj_code,
        					 "lec_unit"=>$value->lec_unit,
        					 "lab_unit"=>$value->lab_unit,
        					 "subj_name"=>$value->subj_name,
                             "lab_hour"=>$value->lab_hour,
                             "lec_hour"=>$value->lec_hour,
                             "split"=>$value->split);
        }
        return $array;
    }

    public function saveSchedule(){
        $this->load->model("Block_section_sched");
        $this->load->model("Block_section_subjects");

        $bss = new Block_section_subjects;
    	$bs = new Block_section;

    	$subj_id    = $this->input->post("subj_id");
    	$days       = $this->input->post("sd_id");
    	$time_start = $this->input->post("time_start");
		$time_end   = $this->input->post("time_end");
		$rl_id      = $this->input->post("rl_id");
        $type       = $this->input->post('type');
        $hours      = $this->input->post('hours');
        $bs_id      = $this->input->post("bs_id");
        $bss_id     = $this->input->post("bss_id");
        $sy         = $this->input->post("sy");
        $sem        = $this->input->post("sem");

    	$this->db->trans_begin();
		
        if(strtotime($time_start) < strtotime($time_end)){

            // CHECK IF TOTAL HOURS <= TOTAL TIME DURATION
            $difference = 0;

            foreach ($days as $key => $value) {
                $difference += round(abs(strtotime($time_end) - strtotime($time_start)) / 3600, 2);
            }

            if($difference <= $hours){

                // UPDATE SUBJECT REMAINING HOUR
                $bss->load($bss_id);
                $bss->remaining_hour = $this->getRemainingHour($bss_id) - $difference;
                $bss->save();

                // SAVE SCHEDULE
                $conflict = $this->hasConflict($days, $time_start, $time_end, $rl_id, $sy, $sem);
                $conflictSectionSched = $this->hasConflictSection($days, $time_start, $time_end, $bs_id, $sy, $sem);
            
                if($conflict != "" || $conflictSectionSched != ""){
                    echo json_encode(["result"=>$conflict.$conflictSectionSched]);
                }
                else{
                    $sub_sched = [];

                    foreach ($days as $key => $value) {
                        $sec_sched = new Block_section_sched;
                        $sched     = new Sched_subj;

                        $subject = explode("-", $subj_id);

                        $sched->year_lvl   = $this->input->post("year");
                        $sched->sy         = $sy;
                        $sched->sem        = $sem;
                        $sched->subj_id    = $subject[1];
                        $sched->sd_id      = $value;
                        $sched->rl_id      = $rl_id;
                        $sched->time_start = $time_start;
                        $sched->time_end   = $time_end;
                        $sched->avs_status = "active";

                        $sched->save();
                        $ss_id = $sched->db->insert_id();

                        $sec_sched->bs_id       = $bs_id;
                        $sec_sched->ss_id       = $ss_id;
                        $sec_sched->sched_type  = $type;
                        $sec_sched->save();        
                    }

                    if($this->db->trans_status() == true){
                        echo json_encode(["result"=>true, "bs_id"=>$bs_id, "hours"=>$difference]);
                        $this->db->trans_commit();
                    }
                    else{
                        echo json_encode(["result"=>false]);
                        $this->db->trans_rollback();
                    }
                }
            }
            else{
                echo json_encode(["result"=>"hour exceeds"]);
            }
            
        }
        else{
            echo json_encode(["result"=>"invalid time"]);
        }
    }

    private function getRemainingHour($bss_id){
        $this->load->model("Block_section_subjects");
        $subject = new block_section_subjects;

        $sub = $subject->search(["bss_id"=>$bss_id]);

        return $sub[$bss_id]->remaining_hour;
    }

    public function hasConflict($days=array(), $start=false, $end=false, $rl_id=false, $sy=false, $sem=false){
    	$daystr= "";
    	$sql =  "SELECT
				sched_subj.*,sched_day.abbreviation,composition,room_list.room_code,room_name,
				subject.subj_name
				FROM
					sched_subj,
					sched_day,
					room_list,
					subject
				WHERE
                    sched_subj.sy = '{$sy}'
                AND sched_subj.sem = '{$sem}'
                AND
					(
						'{$start}' < sched_subj.time_end
						AND '{$end}' > sched_subj.time_start
					)
				AND ";

				foreach ($days as $key => $value) {
				 	$daystr .= "sched_subj.sd_id = ".$value." || ";
				}

		$sql .= "(".substr($daystr, 0, -4).")
				AND sched_subj.rl_id = {$rl_id}
				AND sched_subj.rl_id = room_list.rl_id
				AND sched_subj.sd_id = sched_day.sd_id
				AND sched_subj.subj_id = subject.subj_id";

    	$query = $this->db->query($sql);
    	$result = $query->result();

    	$conflict = "";
    	if(!empty($result)){
    		foreach ($result as $key => $value) {
    			$conflict .= "Conflict Schedule: ".$value->subj_name." (".$value->composition." ".date("h:i A", strtotime($value->time_start))." - ".date("h:i A", strtotime($value->time_end)).")\n";
    		}
    	}
    	return $conflict;
    }

    public function hasConflictSection($days=array(), $start=false, $end=false, $bs_id=false, $sy=false, $sem=false){
        $daystr= "";
        $sql =  "SELECT
                    sched_subj.ss_id,
                    sched_subj.year_lvl,
                    sched_subj.sy,
                    sched_subj.sem,
                    sched_subj.subj_id,
                    sched_subj.sd_id,
                    sched_subj.rl_id,
                    sched_subj.avs_status,
                    sched_subj.employee_id,
                    sched_subj.bs_id,
                    sched_subj.time_start,
                    sched_subj.time_end,
                    sched_subj.temp_id,
                    sched_day.abbreviation,
                    sched_day.composition,
                    room_list.room_code,
                    room_list.room_name,
                    `subject`.subj_name,
                    `subject`.subj_code,
                    block_section_sched.sched_type
                FROM
                    sched_subj
                INNER JOIN sched_day ON sched_subj.sd_id = sched_day.sd_id
                INNER JOIN room_list ON sched_subj.rl_id = room_list.rl_id
                INNER JOIN `subject` ON sched_subj.subj_id = `subject`.subj_id
                INNER JOIN block_section_sched ON sched_subj.ss_id = block_section_sched.ss_id
                WHERE
                    sched_subj.sy = '{$sy}'
                AND sched_subj.sem = '{$sem}'
                AND
                    (
                        '{$start}' < sched_subj.time_end
                        AND '{$end}' > sched_subj.time_start
                    )
                AND ";

                foreach ($days as $key => $value) {
                    $daystr .= "sched_subj.sd_id = ".$value." || ";
                }

        $sql .= "(".substr($daystr, 0, -4).")
                AND block_section_sched.bs_id = {$bs_id}";

        $query = $this->db->query($sql);
        $result = $query->result();

        $conflict = "";
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $conflict .= "Conflict Schedule: ".$value->subj_name." (".$value->composition." ".date("h:i A", strtotime($value->time_start))." - ".date("h:i A", strtotime($value->time_end)).")\n";
            }
        }
        return $conflict;
    }

    public function roomSched(){

        $room = new Room_list;
        $data = array(
                    "rl_id"=>$this->input->get("rl_id"),
                    "sem"=>$this->input->get("sem"),
                    "sy"=>$this->input->get("sy"),
                    );
        
        $sched = $room->roomSched($data);
        $sub = array();

        if(!empty($sched)){
            foreach ($sched as $key => $value) {

                $sub[] = array(
                    "bs_id"=>$value->bs_id,
                    "subj_id"=>$value->subj_id,
                    "title" => "{$value->subj_code} - {$value->subj_name}",
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
        }

        echo json_encode($sub);
    }

    public function getSectionSchedules(){

        $this->load->model("Block_section_sched");
        $sec_sched = new Block_section_sched;

        $bs_id = $this->input->get("bs_id");
        
        $sec_sched->toJoin = ["Sched_subj"=>"Block_section_sched","Subject"=>"Sched_subj","Sched_day"=>"Sched_subj","Room_list"=>"Sched_subj"];
        $sched = $sec_sched->search(["block_section_sched.bs_id"=>$bs_id]);

        $list = [];
        if(!empty($sched)){

            $type = ["lec"=>"Lecture","lab"=>"Laboratory"];

            foreach ($sched as $key => $value) {

                if(!array_key_exists($value->subj_id.$value->sched_type, $list)){

                    $list[$value->subj_id.$value->sched_type][] = array(
                                $value->subj_code,
                                $value->subj_name,
                                $value->composition,
                                date("h:i A", strtotime($value->time_start))."-".date("h:i A", strtotime($value->time_end)),
                                $value->room_code,
                                $type[$value->sched_type],
                                "<button><i class='fa fa-times'></i></button>"
                                );
                }
                else{
                    $list[$value->subj_id.$value->sched_type][] = array(
                                "",
                                "",
                                $value->composition,
                                date("h:i A", strtotime($value->time_start))."-".date("h:i A", strtotime($value->time_end)),
                                $value->room_code,
                                $type[$value->sched_type],
                                ""
                                );
                }
                
            }
            $newArr = [];
            foreach ($list as $key => $value) {
                $newArr[] = $value;
            }
        }
        // echo "<pre>";
        // print_r($newArr);
        echo json_encode(["data"=>$list]);
    }

    public function cancelScheduling(){

        $block = new Block_section;
        $sched = new Sched_subj;

        $bs_id = $this->input->get("bs_id");

        $this->db->trans_begin();

        $sched->db->query("delete from sched_subj where ss_id IN (select ss_id from block_section_sched where bs_id = {$bs_id})");

        $block->load($bs_id);
        $block->delete();

        if($this->db->trans_status() == true){
            echo json_encode(["result"=>true]);
            $this->db->trans_commit();
        }
        else{
            echo json_encode(["result"=>false]);
            $this->db->trans_rollback();
        }
    }

    public function getExistingSchedules($subj_id){

        $this->load->model("Block_section_sched");
        $sched = new Block_section_sched;

        $result = $sched->getSubjectExistSchedule($subj_id);

        $list = array();

        if(!empty($result)){

            foreach ($result as $key => $value) {
                
                if(!array_key_exists($value->bs_id, $list)){

                    // if(){
                        
                    // }

                }

                $list[$value->bs_id][] = array(

                                            );
            }
        }
        
        echo "<pre>";
        print_r($result);
    }

}
