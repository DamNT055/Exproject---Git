<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Slider_model extends MY_Model
{
    public $table = 'recruit_sliders';
    public $id = 'id';
    private $__select_column = array("id", "name", "description");
    private $__order_column = array("recruit_sliders.id", "recruit_sliders.name", null);

    public function make_query()
    {
        $this->db->select('
        recruit_sliders.id,
        recruit_sliders.name,
        recruit_sliders.description,
        COUNT(recruit_slides.id) AS slide_count
        ');
        $this->db->from($this->table);
        $this->db->join('recruit_slides', 'recruit_slides.slider_id = recruit_sliders.id', 'left');

        if (isset($_POST["search"]["value"])) {
            $this->db->like("recruit_sliders.name", $_POST["search"]["value"]);
            $this->db->or_like("recruit_sliders.id", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->__order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('recruit_sliders.id', 'DESC');
        }
        $this->db->group_by('recruit_sliders.id');
        

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