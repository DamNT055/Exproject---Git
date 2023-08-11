<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class JobBrand_model extends MY_Model
{
    var $table = 'recruit_job_brand';
    var $id = 'id';


        function checkExist($id, $brand_id = 0){
                $SQL = "SELECT *
                        FROM recruit_job_brand 
                        WHERE job_id = $id AND brand_id = $brand_id";
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
                        return $this->db->simple_query("DELETE FROM recruit_job_brand WHERE job_id = $job_id ");
                }
                $data = implode(",", $data);
                $SQL = "DELETE FROM recruit_job_brand WHERE job_id = $job_id AND brand_id NOT IN ($data)";
                return $this->db->simple_query($SQL);
        }

        public function get_brands($job_id = 0){
		
		$this->db->select('recruit_brands.id, recruit_brands.name');
		$this->db->from($this->table);
		$this->db->join('recruit_brands', 'recruit_brands.id = recruit_job_brand.brand_id', 'left');
		if($job_id != 0 || $job_id != ''){
			$this->db->where('recruit_job_brand.job_id =',$job_id);
		}
		
		$this->db->order_by("recruit_brands.name", "asc");
		$query = $this->db->get();
		if(!$query) return false;
		return $query->result();
	}

}