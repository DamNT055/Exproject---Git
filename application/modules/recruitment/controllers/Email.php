
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Email extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Email_model", "email_model");
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

        $query = $this->email_model->make_datatables();
     
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->email_model->get_all_data(),
            "recordsFiltered" => $this->email_model->get_filtered_data(),
            "data" => $query,
        );

        echo json_encode($result);
        exit();
    }

    public function data_action()
    {
        $error_msg = array();
        $this->load->library('form_validation');
        if($this->input->post('email_id')){
            $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        }else{
            $this->form_validation->set_rules('email', 'Email', 'required|min_length[5]|is_unique[recruit_emails.email]', array('required' => 'Vui lòng nhập %s.'));
        }
        
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            if (!isset($_POST["email_id"]) || $_POST["email_id"] == "") {
                $insert_data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                );
                if ($this->email_model->Insert($insert_data)) {
                    return showMes(false, "Thêm thành công :)");
                }

            } else {
                $id = $this->input->post('email_id');
                $updated_data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                );
                if ($this->email_model->Update($updated_data, $id)) {
                    return showMes(false, "Cập nhật thành công :)");
                }

            }
        } else {

            foreach ($_POST as $key => $value) {
                $error_msg[$key] = form_error($key);
            }
        }

        return showMes(true, $error_msg);

    }

    public function create()
    {
        return $this->load->view('email/partials/email_modal');
    }
    /**
     * Store a newly created resource in storage.

     */
    public function store()
    {

    }
    /**
     * Edit Data from this method.
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = array(
            'email' => $this->email_model->GetId($id),
        );
        return $this->load->view('email/partials/edit_email_modal',$data);
    }

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id = 0)
    {
        $check = $this->checkPermission('recruitment', "config");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->email_model->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->email_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }

        showMes(false, "Xoá thành công");
    }

}
