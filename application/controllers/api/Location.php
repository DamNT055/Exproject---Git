<?php 
class Location extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model', 'location');
        $this->load->model('District_model', 'district');
        $this->load->model('Ward_model', 'ward');
    }
    function getDistrict() {
        $province_id = empty($this->input->get('province_id')) ? 0 : intval($this->input->get('province_id'));
        $data = array();
        if ($province_id!=0) $data = $this->district->GetAllWhere(array('province_code' => $province_id));
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }
    function getWard() {
        $district_id = empty($this->input->get('district_id')) ? 0 : intval($this->input->get('district_id'));
        $data = array();
        if ($district_id!=0) $data = $this->ward->GetAllWhere(array('district_code' => $district_id));
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }
}