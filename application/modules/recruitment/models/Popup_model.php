<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Popup_model extends MY_Model
{
    public $table = 'recruit_popups';
    public $id = 'id';

    private $__select_column = array("id", "name",  "status", "created_at");
    private $__order_column = array("id", "name", "status");

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



}