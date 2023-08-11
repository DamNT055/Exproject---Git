<?php
defined('BASEPATH') or exit('No direct script access allowed');
class News_model extends MY_Model
{
    public $table = 'recruit_news';
    public $id = 'id';
    private $__select_column = array("id", "name", "description", "status","created_at","slug");
    private $__order_column = array("recruit_news.id", "recruit_news.name", null, "recruit_news.status");

    public function make_query()
    {
        $this->db->select('
        recruit_news.id,
        recruit_news.name,
        recruit_news.status,
        recruit_news.created_at,
        recruit_news.slug,
        emp_employee.full_name as created_by
        ');
        $this->db->from($this->table);
        $this->db->join('emp_employee', 'emp_employee.id = recruit_news.employee_id', 'left');

        if (isset($_POST["search"]["value"])) {
            $this->db->like("recruit_news.name", $_POST["search"]["value"]);
            $this->db->or_like("recruit_news.id", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->__order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
        $this->db->group_by('recruit_news.id');
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

}
