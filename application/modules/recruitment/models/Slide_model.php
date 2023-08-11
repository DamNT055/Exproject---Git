<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Slide_model extends MY_Model
{
    public $table = 'recruit_slides';
    public $id = 'id';

    function getSlides($slider_id){
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('recruit_slides.slider_id', $slider_id); 
        $query = $this->db->get();
        return $query->result();
    }
    
}