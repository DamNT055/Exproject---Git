
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Source extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Source_model", "source_model");
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

        $query = $this->source_model->make_datatables();
     
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->source_model->get_all_data(),
            "recordsFiltered" => $this->source_model->get_filtered_data(),
            "data" => $query,
        );

        echo json_encode($result);
        exit();
    }


    public function data_action()
    {
        $error_msg = array();
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('name', 'Tên nguồn', 'required|min_length[3]', array('required' => 'Vui lòng nhập %s.'));
        
        
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            if (!isset($_POST["source_id"]) || $_POST["source_id"] == "") {
                $insert_data = array(
                    'name' => $this->input->post('name')
                );
                if ($this->source_model->Insert($insert_data)) {
                    return showMes(false, "Thêm thành công :)");
                }

            } else {
                $id = $this->input->post('source_id');
                $updated_data = array(
                    'name' => $this->input->post('name')
                );
                if ($this->source_model->Update($updated_data, $id)) {
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
        return $this->load->view('config/source/source_modal');
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
            'source' => $this->source_model->GetId($id),
        );
        return $this->load->view('config/source/edit_source_modal',$data);
    }

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id = 0)
    {
        $check = $this->checkPermission('recruitment', "config");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->source_model->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->source_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }

        showMes(false, "Xoá thành công");
    }

}
