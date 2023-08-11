
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Brand_model", "brand_model");
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

        $query = $this->brand_model->make_datatables();
        $data = array();
        foreach ($query as $row) {
            $sub_array = array();
            $sub_array['id'] = $row->id;
            $sub_array['name'] = '<a style="cursor:pointer;" class="update" data-id="' . $row->id . '">'.$row->name.'</a>';
            $sub_array['job_count'] = $row->job_count;
            $sub_array['apply_count'] = $row->apply_count;
            //$sub_array['action'] = '<button type="button" data-id="' . $row->id . '" class="btn btn-default btn-flat update"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
            $sub_array['action'] = '<button onclick="remove_brand(' . $row->id . ')" type="button" data-id="' . $row->id . '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
            $data[] = (object) $sub_array;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->brand_model->get_all_data(),
            "recordsFiltered" => $this->brand_model->get_filtered_data(),
            "data" => $data,
        );

        echo json_encode($result);
        exit();
    }

    public function fetch_single_data()
    {
        $output = array();
        $data = $this->brand_model->GetId($_POST["brand_id"]);
        foreach ($data as $row) {
            $output['name'] = $row->name;
            $output['description'] = $row->description;

        }
        echo json_encode($data);
    }

    public function data_action()
    {
        $error_msg = array();
        $this->load->library('form_validation');
        if($this->input->post('brand_id')){
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        }else{
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]|is_unique[recruit_brands.name]', array('required' => 'Vui lòng nhập %s.'));
        }
        
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            if (!isset($_POST["brand_id"]) || $_POST["brand_id"] == "") {
                $insert_data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                );
                if ($this->brand_model->Insert($insert_data)) {
                    clear_cache();
                    return showMes(false, "Thêm tin thành công :)");
                }

            } else {
                $id = $this->input->post('brand_id');
                $updated_data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                );
                if ($this->brand_model->Update($updated_data, $id)) {
                    clear_cache();
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

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id = 0)
    {
        $check = $this->checkPermission('recruitment', "config");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->brand_model->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->brand_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }

        showMes(false, "Xoá thành công");
    }

}
