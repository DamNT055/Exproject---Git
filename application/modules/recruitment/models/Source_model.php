<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Source_model extends MY_Model
{
    public $table = 'recruit_source';
    public $id = 'id';

    private $__select_column = array("id", "name");
    private $__order_column = array("id", "name");

    public function make_query()
    {
        $this->db->select($this->__select_column);
        $this->db->from($this->table);
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("name", $_POST["search"]["value"]);
            $this->db->or_like("id", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->__order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }

       
    }
    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }
    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_source_filter($s = "",$date_from = 0, $date_to = 0, $status_id = 0, $gender = "", $job_id = 0){
        $this->db->select("recruit_source.id,
        recruit_source.name,
		COUNT(recruit_apply.id) as count
		");
		$this->db->from($this->table);
        $this->db->join('recruit_apply', 'recruit_source.id = recruit_apply.source_id', 'left');

        if ($s != "") {
            $this->db->group_start();
            $this->db->or_like("recruit_apply.id", $s);
            $this->db->or_like("recruit_apply.name", $s);
            $this->db->or_like("recruit_apply.phone", $s);
            $this->db->group_end();
        }

        if($date_from > 0 && $date_to > 0){
            $this->db->where('recruit_apply.created_at >=', $date_from);
            $this->db->where('recruit_apply.created_at <=', $date_to + 86400);
        }

        if($status_id > 0 ){
            $this->db->where('recruit_apply.status_id =', $status_id);
        }

        if($job_id > 0 ){
            $this->db->where('recruit_apply.job_id =', $job_id);
        }

        if($gender != "" ){
            $this->db->where('recruit_apply.gender =', $gender);
        }
        
        $this->db->group_by('recruit_source.id');
		$this->db->order_by('recruit_source.name', 'ASC');
  
        $query = $this->db->get();
		return $query->result();
    }



}