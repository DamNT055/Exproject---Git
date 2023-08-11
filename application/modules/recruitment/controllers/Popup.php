<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Popup extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Popup_model", "popup_model");
        $this->load->model("RecruitLog_model", "logRecruitment");
    }

    /**
     * Prepare data for Datatable.
     *
     * @return Response
     */
    public function get_items()
    {
        header("Content-type: application/json; charset=utf-8");
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $query = $this->popup_model->make_datatables();
        $data = array();
        foreach ($query as $row) {
            $sub_array = array();
            $sub_array['id'] = $row->id;
            $sub_array['name'] = '<a style="cursor:pointer;" class="update" data-id="' . $row->id . '">'.$row->name.'</a>';
            $sub_array['status'] = $row->status;
            //$sub_array['action'] .= '<button type="button" data-id="' . $row->id . '" class="btn btn-default btn-flat update"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
            $sub_array['action'] = '<button onclick="remove_popup(' . $row->id . ')" type="button" data-id="' . $row->id . '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
            $data[] = (object) $sub_array;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->popup_model->get_all_data(),
            "recordsFiltered" => $this->popup_model->get_filtered_data(),
            "data" => $data,
        );

        echo json_encode($result);
        exit();
    }
    
    public function create()
    {
        $data = array(
            'popup_id' => $_GET['popup_id'],
      
        );
        return $this->load->view('popup/partials/popup_modal',$data);
    }

    public function edit($id)
    {
        $data = array(
            'detail' => $this->popup_model->GetId($id),
        );
        return $this->load->view('popup/partials/edit_popup_modal',$data);
    }

    public function store(){

        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        

        if ($this->form_validation->run()) {
         
            $data = array(
                'created_at' => time(),
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'status' => intval($this->input->post('status')),
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
            

            $insert = $this->popup_model->Insert($data);
            if ($insert) {
                $popup =  $this->popup_model->GetId($insert);
                $respone = array (
                    'error' => false,
                    'message' => $popup
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

            $popup = $this->popup_model->GetId($this->input->post("popup_id"));

            if (!$popup) {
                return showMes(true, "Không tìm thấy popup này");
            }

            $data = array(
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'status' => intval($this->input->post('status')),
                'url' => $this->input->post('url'),
            );
      
            if (!empty($_FILES['image']['name'])) {
                $upload = $this->upload_file('image');
                if($upload) {
                    $data['image'] = $upload['file_name'];
                }else{
                    return showMes(true, "Lỗi không thể upload file.");
                }
            }


            if (!$this->popup_model->Update($data, $popup->id)) {
                return showMes(true, "Lỗi Data");
            }

            /* Update Log */
            $last_query = $this->db->last_query();
            $content = "Cập nhật popup " . $data['name'];
            $log = array(
                'employee_id' => $this->userLogin->id,
                'detail_id' => $this->input->post("popup_id"),
                'content' => $content,
                'query' => $last_query,
                'time' => time(),
                'module' => 'popup',
            );
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            }

            if (isset($_SERVER['REMOTE_ADDR'])) {
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
            }
            $this->logRecruitment->Insert($log);

            header("Content-type: application/json; charset=utf-8");
            $popup =  $this->popup_model->GetId($this->input->post("popup_id"));
            $respone = (object)array (
                'error' => false,
                'message' => $popup
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
        $config['upload_path']   = './assets/uploads'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 2048;
        $this->load->library('upload', $config);

        if (!is_dir('./assets/uploads')) {
            mkdir('./assets/uploads', 0777, TRUE);
        }
            
        if ( ! $this->upload->do_upload($field)) {
            return false;
        }else { 
            $file = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $file['full_path']; //get original image
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 1920;
            $config['height'] = 1;
            $config['maintain_ratio']   = TRUE;
            $config['master_dim'] = 'width';
            $config['overwrite'] = TRUE;
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                return showMes(true, $this->image_lib->display_errors());
                
            }
           
            return $file;
        
        } 
    }

    public function delete($id)
    {
        $check = $this->checkPermission("recruitment",'index', 'add');if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $dataEm = $this->popup_model->GetId($id);
        if (!$dataEm) {
            return showMes(true, "Không tìm thấy popup này");
        }

        if (!$this->popup_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }
        clear_cache();
        showMes(false, "Đã xoá");
    }

    public function deactive($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment','index', "add");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->popup_model->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->popup_model->Update(array('status' => 0), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }
        clear_cache();
        return showMes(false, 'Đã bỏ kích hoạt thành công');
    }
    public function active($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment','index', "add");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->popup_model->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->popup_model->Update(array('status' => 1), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }
        clear_cache();
        return showMes(false, 'Đã kích hoạt');
    }

}