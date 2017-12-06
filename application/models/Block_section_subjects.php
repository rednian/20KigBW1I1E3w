<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Block_section_subjects extends MY_Model
{

    const DB_TABLE = 'block_section_subjects';
    const DB_TABLE_PK = 'bss_id';

    public $bss_id;
    public $bs_id;
    public $subj_id;
    public $type;
    public $status;
    public $remaining_hour;

    public function check_plotted($bs_id = false){
        $this->db->where('bs_id', $bs_id);

        return $this->get();
    }

    public function get_subject($data =array())
    {
        $this->toJoin = array('subject'=>'block_section_subjects');
        $this->db->where('type',$data['type']);
        $this->db->where('bs_id',$data['bs_id']);

        return $this->get();
    }

    public function get_by_block($data = array())
    {
        $this->toJoin = array(
            'subject' => 'block_section_subjects',
            'block_section' => 'block_section_subjects',
        );
        $this->db->where('block_section_subjects.bs_id', $data[0]);
        if (!empty($data[1])) {
            $this->db->where("block_section_subjects.type > $data[1]");
        }

        return $this->get();
    }
}