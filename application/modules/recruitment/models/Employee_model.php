<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Employee_model extends MY_Model
{
    public $table = 'emp_employee';
    public $id = 'id';

    function getEmp($apply_id){
        $this->db->select('
        emp_employee.full_name,
        emp_employee.id,
    ');
        $this->db->from($this->table);
        $this->db->join('recruit_schedule_assign as assign', 'assign.employee_id = emp_employee.id','left');
        $this->db->join('recruit_schedule as schedule', 'assign.schedule_id = schedule.id','left');
        $this->db->where('schedule.apply_id', $apply_id); 
        $query = $this->db->get();
        return $query->result();
    }

}