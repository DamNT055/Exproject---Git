<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Slide extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Slide_model", "slide_model");
        $this->load->model("Slider_model", "slider_model");
        $this->load->model("RecruitLog_model", "logRecruitment");
    }

    public function add()
    {
        $check = $this->checkPermission('recruitment','index', 'add');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $slider_id = $_GET['slider_id'];
        $data = array(
            'className' => "recruitment",
            "method" => "config",
            "type_menu" => "eoffice",
            "slider_id" => $slider_id,
            'collapse' => true,
            "slides" => $this->slide_model->getSlides($slider_id)
        );
        $this->getView('slide/add', $data);
    }

    public function create()
    {
        $data = array(
            'slider_id' => $_GET['slider_id'],
      
        );
        return $this->load->view('slide/partials/slide_modal',$data);
    }

    public function edit($id)
    {
        $data = array(
            'detail' => $this->slide_model->GetId($id),
        );
        return $this->load->view('slide/partials/edit_slide_modal',$data);
    }

    public function store(){

        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        

        if ($this->form_validation->run()) {
            $slider = $this->slider_model->GetId($this->input->post('slider_id'));
            if(empty($slider)){
                return showMes(true, "Slider id không tồn tại");
            }
            $data = array(
                'created_at' => time(),
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'status' => intval($this->input->post('status')),
                'order' => $this->input->post('order'),
                'url' => $this->input->post('url'),
                'slider_id' => $this->input->post('slider_id'),
            );
            
            $target =  $this->input->post('target');
            $options = array(
                'target' => $target,
            );
            $data['options'] = json_encode($options);

            if (!empty($_FILES['image']['name'])) {
                $upload = $this->upload_file('image');
                if($upload) {
                    $data['image'] = $upload['file_name'];
                }else{
                    return showMes(true, "Lỗi không thể upload file.");
                }
            }
            

            $insert = $this->slide_model->Insert($data);
            if ($insert) {
                $slide =  $this->slide_model->GetId($insert);
                $respone = array (
                    'error' => false,
                    'message' => $slide
                );
                clear_cache();
                echo json_encode($respone);die;
            } else {
                return showMes(true, "Lỗi rồi liên hệ IT đê :v");
            }

        } else {

            foreach ($_POST as $key => $value) {
                $error_msg[$key] = form_error($key);
            }
        }
        
        return showMes(true, $error_msg);
    }

   


    /**
     * Update Data from this method.
     *
     * @return Response
     */
    public function update($id = 0)
    {
      

        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            $slide = $this->slide_model->GetId($this->input->post("slide_id"));

            if (!$slide) {
                return showMes(true, "Không tìm thấy slide này");
            }

            $data = array(
          
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'status' => intval($this->input->post('status')),
                'order' => $this->input->post('order'),
                'url' => $this->input->post('url'),
            );

            $target =  $this->input->post('target');
            $options = array(
                'target' => $target,
            );
            $data['options'] = json_encode($options);
      
            if (!empty($_FILES['image']['name'])) {
                $upload = $this->upload_file('image');
                if($upload) {
                    $data['image'] = $upload['file_name'];
                }else{
                    return showMes(true, "Lỗi không thể upload file.");
                }
            }


            if (!$this->slide_model->Update($data, $slide->id)) {
                return showMes(true, "Lỗi Data");
            }

            /* Update Log */
            $last_query = $this->db->last_query();
            $content = "Cập nhật slide " . $data['name'];
            $log = array(
                'employee_id' => $this->userLogin->id,
                'detail_id' => $this->input->post("slide_id"),
                'content' => $content,
                'query' => $last_query,
                'time' => time(),
                'module' => 'slider',
            );
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            }

            if (isset($_SERVER['REMOTE_ADDR'])) {
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
            }
            $this->logRecruitment->Insert($log);

            header("Content-type: application/json; charset=utf-8");
            $slide =  $this->slide_model->GetId($this->input->post("slide_id"));
            $respone = (object)array (
                'error' => false,
                'message' => $slide
            );
            clear_cache();
            echo json_encode($respone, JSON_PRETTY_PRINT);die;

        } else {

            foreach ($_POST as $key => $value) {
                $error_msg[$key] = form_error($key);
            }
        }
        
        return showMes(true, $error_msg);

    }

    public function upload_file($field){
        header('Content-Type: application/json');
        $config['upload_path']   = './assets/uploads/slides/'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        if (!is_dir('./assets/uploads/slides')) {
            mkdir('./assets/uploads/slides', 0777, TRUE);
        }
            
        if ( ! $this->upload->do_upload($field)) {
            return false;
        }else { 
            $file = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $file['full_path']; //get original image
            $config['maintain_ratio'] = TRUE;
            if ($file['image_width']> "1920"){
                $config['width'] = 1920;
            }
            
            //$config['master_dim'] = 'auto';
            $config['overwrite'] = TRUE;
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                return showMes(true, $this->image_lib->display_errors());
            }
     
           
            $data = array(
                'file_name' => $file['raw_name'].'.jpg'
            );
            return $data;
        
        } 
    }

    public function delete($id)
    {
        $check = $this->checkPermission("recruitment",'index', 'add');if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $dataEm = $this->slide_model->GetId($id);
        if (!$dataEm) {
            return showMes(true, "Không tìm thấy slide này");
        }

        if (!$this->slide_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }

        $img = $this->input->post("file");
        if (!$img) {
            return showMes(true, "Không tìm thấy hình ảnh");
        }
        @unlink('./assets/uploads/slides/' . $img);
        clear_cache();
        showMes(false, "Đã xoá");
    }

}