<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Plotted_schedule extends MY_Model
{

  const DB_TABLE = 'plotted_schedule';
  const DB_TABLE_PK = 'ps_id';

  public $ps_id;
  public $user_id;
  public $subj_id;
  public $sd_id;
  public $rl_id;
  public $time_start;
  public $time_end;
  public $key;


  public function get_room($room_code = false)
  {
    $this->toJoin = array(
      'room_list' => 'plotted_schedule',
      'sched_day' => 'plotted_schedule',
      'subject'   => 'plotted_schedule',
    );
    
    if (!empty($room_code)) {
      $this->db->where('room_list.room_code', $room_code);
    }
    

    return $this->get();

  }


  public function get_by_user()
  {
    $this->toJoin = array(
      "Room_list" => "Plotted_schedule",
      "Sched_day" => "Plotted_schedule",
      "Subject"   => "Plotted_schedule"
    );
    $this->db->where("plotted_schedule.user_id != " . $this->userInfo->user_id);

    return $this->get();
  }

}