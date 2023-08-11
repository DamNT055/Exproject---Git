<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category_model extends MY_Model
{
    public $table = 'recruit_categories';
    public $id = 'id';
    private $__select_column = array("id", "name", "description", "status");
    private $__order_column = array("recruit_categories.id", "recruit_categories.name", null, "status");

    public function listAll($id = 0)
    {
        $SQL = "SELECT recruit_categories.*
              FROM recruit_categories
              ORDER BY name asc";
        return $this->db->query($SQL)->result();
    }

    public function make_query()
    {
        $this->db->select('
        recruit_categories.id,
        recruit_categories.name,
        recruit_categories.description,
            
            recruit_categories.status,
            COUNT(distinct recruit_jobs.id) AS job_count,
            COUNT(recruit_apply.id) AS apply_count
            
           
        ');
        $this->db->from($this->table);
        $this->db->join('recruit_jobs', 'recruit_jobs.category_id = recruit_categories.id', 'left');
        $this->db->join('recruit_apply', 'recruit_apply.job_id = recruit_jobs.id', 'left');
        
        if (isset($_POST["search"]["value"])) {
            $this->db->like("recruit_categories.name", $_POST["search"]["value"]);
            $this->db->or_like("recruit_categories.id", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->__order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->group_by('recruit_categories.id');
       
    }
    public function make_datatables()
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
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

}
