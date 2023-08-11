<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Config extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Setting_model", "setting_model");

    }
    public function index()
    {
        $check = $this->checkPermission("recruitment", "config");if (!$check) {$this->getView('no-permission');return false;}
        $data = array(
            'className' => 'recruitment',
            'method' => 'config',
            "type_menu" => "eoffice",
            'collapse' => true
            
        );
        $this->getView('config/index', $data);
    }

    public function store(){
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission("recruitment", "config");if (!$check) {$this->getView('no-permission');return false;}
    }

}
