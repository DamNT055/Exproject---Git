<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Schedule_model extends MY_Model
{
    public $table = 'recruit_schedule';
    public $id = 'id';

    function insert_schedule_assign($schedule_id,$emp_id) { 
        $data = array( 
            'schedule_id' => $schedule_id, 
            'employee_id' => $emp_id,

        ); 
        return $this->db->insert('recruit_schedule_assign', $data); 
    }


    function getSchedule($apply_id){
        $this->db->select('
        recruit_schedule.*,
        emp.id as emp_id,
        emp.full_name as full_name
    ');
        $this->db->from($this->table);
        $this->db->join('recruit_schedule_assign as assign', 'assign.schedule_id = recruit_schedule.id','left');
        $this->db->join('emp_employee as emp', 'assign.employee_id = emp.id','left');
        $this->db->where('recruit_schedule.apply_id', $apply_id); 
        $this->db->group_by('recruit_schedule.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    
}