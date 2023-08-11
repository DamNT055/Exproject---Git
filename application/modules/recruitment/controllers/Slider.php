<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Slider_model", "slider_model");

        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'recruit_sliders',
            'id' => 'id',
        );
        $this->load->library('slug', $config);

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

        $query = $this->slider_model->make_datatables();
        $data = array();
        foreach ($query as $row) {
            $sub_array = array();
            $sub_array['id'] = $row->id;
            $sub_array['name'] = $row->name;
            $sub_array['slide_count'] = $row->slide_count;
            $sub_array['action'] = '<a data-toggle="tooltip" data-placement="bottom" data-original-title="Thêm Slide ảnh" href="'.base_url('recruitment/slide/add').'?slider_id=' . $row->id . '" data-id="' . $row->id . '" class="btn btn-default btn-flat"><i class="fa fa-photo" aria-hidden="true"></i></a>';
            $sub_array['action'] .= '<button onclick="createModal(' . $row->id . ')" type="button" data-id="' . $row->id . '" class="btn btn-default btn-flat update"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
            //$sub_array['action'] .= '<button onclick="remove_slider(' . $row->id . ')" type="button" data-id="' . $row->id . '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
            $data[] = (object) $sub_array;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->slider_model->get_all_data(),
            "recordsFiltered" => $this->slider_model->get_filtered_data(),
            "data" => $data,
        );

        echo json_encode($result);
        exit();
    }

    public function fetchSingleData()
    {
        $output = array();
        $data = $this->slider_model->GetId($_POST["slider_id"]);
        foreach ($data as $row) {
            $output['name'] = $row->name;
            $output['slug'] = $row->name;

        }
        echo json_encode($data);
    }

    public function dataAction()
    {
        header("Content-type: application/json; charset=utf-8");
        $error_msg = array();
        $this->load->library('form_validation');
        if($this->input->post('slider_id')){
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
            $this->form_validation->set_rules('slug', 'Đường dẫn', 'required', array('required' => 'Vui lòng nhập %s.'));
        }else{
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]|is_unique[recruit_categories.name]', array('required' => 'Vui lòng nhập %s.'));
            $this->form_validation->set_rules('slug', 'Đường dẫn', 'required|is_unique[recruit_categories.slug]', array('required' => 'Vui lòng nhập %s.'));
        }
        
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            if (!isset($_POST["slider_id"]) || $_POST["slider_id"] == "") {
                $insert_data = array(
                    'name' => $this->input->post('name'),
                    'slug' => $this->input->post('slug'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status', 1),
                );
                if ($this->slider_model->Insert($insert_data)) {
                    return showMes(false, "Thêm tin thành công :)");
                }

            } else {
                $id = $this->input->post('slider_id');
                $updated_data = array(
                    'name' => $this->input->post('name'),
                    'slug' => $this->input->post('slug'),
                    'description' => $this->input->post('description'),
                    'status' => 1,
                );
                if ($this->slider_model->Update($updated_data, $id)) {
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

    public function create_slider($id = 0)
    {
        $data = array(
            'slider' => $this->slider_model->GetId($id),
        );
        return $this->load->view('slider/partials/slider_modal',$data);
    }

    /**
     * @param $name
     * @param int $slug_id
     * @return int|string
     */
    public function create_slug()
    {
        $slug = $this->slug->create_uri($this->input->post('name'), $this->input->post('id'));
        echo $slug;
    }


}