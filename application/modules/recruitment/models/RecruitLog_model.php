<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RecruitLog_model extends MY_Model
{
    var $table = 'recruit_log';
    var $id = 'id';
    function GetList($id = 0, $module = ''){
            $SQL = "SELECT logs.*, employee.full_name
                    FROM recruit_log as logs
                    LEFT JOIN emp_employee as employee ON employee.id = logs.employee_id
                    WHERE logs.detail_id = $id AND logs.module = '$module'
                    ORDER BY logs.id ASC ";
            return $this->db->query($SQL)->result();
    }
}