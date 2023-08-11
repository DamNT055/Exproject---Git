<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JobBranch_model extends MY_Model
{
    var $table = 'recruit_job_branch';
    var $id = 'id';


    function checkExist($id, $branch_id = 0){
            $SQL = "SELECT *
                    FROM recruit_job_branch 
                    WHERE job_id = $id AND branch_id = $branch_id";
            $kq = $this->db->query($SQL)->result();
            if(!$kq || count($kq) < 1) return false;
            return true;
    }

        function attach($data){
                $dup = $this->GetAllWhere($data);
                if(!$dup) return $this->Insert($data);
                return true;
        }
        function detach($job_id, $data){
                if($data == null || $data == ""){
                        return $this->db->simple_query("DELETE FROM recruit_job_branch WHERE job_id = $job_id ");
                }
                $data = implode(",", $data);
                $SQL = "DELETE FROM recruit_job_branch WHERE job_id = $job_id AND branch_id NOT IN ($data)";
                return $this->db->simple_query($SQL);
        }

        public function get_branchs($job_id = 0){
		
		$this->db->select('emp_branch.id, emp_branch.name');
		$this->db->from($this->table);
		$this->db->join('emp_branch', 'emp_branch.id = recruit_job_branch.branch_id', 'left');
		if($job_id != 0 || $job_id != ''){
			$this->db->where('recruit_job_branch.job_id =',$job_id);
		}
		
		$this->db->order_by("emp_branch.name", "asc");
		$query = $this->db->get();
		if(!$query) return false;
		return $query->result();
	}

}