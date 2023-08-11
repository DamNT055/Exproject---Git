<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Category extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Category_model", "category_model");
        $this->load->database();

        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'recruit_categories',
            'id' => 'id',
        );
        $this->load->library('slug', $config);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $check = $this->checkPermission('recruitment','category');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'categories' => $this->category_model->GetAll("asc", false, "name"),
            'className' => "recruitment",
            "method" => "category",
            "type_menu" => "eoffice",
        );
        $this->getView('category/index', $data);
    }

    /**
     * Prepare data for Datatable.
     *
     * @return Response
     */
    public function getItems()
    {
        header("Content-type: application/json; charset=utf-8");
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $query = $this->category_model->make_datatables();
        $data = array();
        foreach ($query as $row) {
            $sub_array = array();
            $sub_array['id'] = $row->id;
            $sub_array['name'] = '<a style="cursor:pointer;" class="update" data-id="' . $row->id . '">'.$row->name.'</a>';
            $sub_array['description'] = $row->description;
            $sub_array['job_count'] = $row->job_count;
            $sub_array['apply_count'] = $row->apply_count;
            $sub_array['status'] = $row->status;
            //$sub_array['action'] .= '<button type="button" data-id="' . $row->id . '" class="btn btn-default btn-flat update"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
            $sub_array['action'] = '<button onclick="remove(' . $row->id . ')" type="button" data-id="' . $row->id . '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
            $data[] = (object) $sub_array;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->category_model->get_all_data(),
            "recordsFiltered" => $this->category_model->get_filtered_data(),
            "data" => $data,
        );

        echo json_encode($result);
        exit();
    }

    public function fetchSingleData()
    {
        $output = array();
        $data = $this->category_model->GetId($_POST["category_id"]);
        foreach ($data as $row) {
            $output['name'] = $row->name;
            $output['slug'] = $row->name;
            $output['description'] = $row->description;
            $output['status'] = $row->status;

        }
        echo json_encode($data);
    }

    public function dataAction()
    {
        $error_msg = array();
        $this->load->library('form_validation');
        if($this->input->post('category_id')){
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
            $this->form_validation->set_rules('slug', 'Đường dẫn', 'required', array('required' => 'Vui lòng nhập %s.'));
        }else{
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]|is_unique[recruit_categories.name]', array('required' => 'Vui lòng nhập %s.'));
            $this->form_validation->set_rules('slug', 'Đường dẫn', 'required|is_unique[recruit_categories.slug]', array('required' => 'Vui lòng nhập %s.'));
        }
        
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            if (!isset($_POST["category_id"]) || $_POST["category_id"] == "") {
                $insert_data = array(
                    'name' => $this->input->post('name'),
                    'slug' => $this->input->post('slug'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status', 1),
                    'order' => $this->input->post('order'),
                );
                if ($this->category_model->Insert($insert_data)) {
                    clear_cache();
                    return showMes(false, "Thêm tin thành công :)");
                }

            } else {
                $id = $this->input->post('category_id');
                $updated_data = array(
                    'name' => $this->input->post('name'),
                    'slug' => $this->input->post('slug'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status'),
                    'order' => $this->input->post('order'),
                );
                if ($this->category_model->Update($updated_data, $id)) {
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

    public function create()
    {
        return $this->load->view('category/partials/category_modal');
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
            'category' => $this->category_model->GetId($id),
        );
        return $this->load->view('category/partials/edit_category_modal',$data);
    }
    /**
     * Update Data from this method.
     *
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id = 0)
    {
        $check = $this->checkPermission('recruitment', "category");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->category_model->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->category_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }
        clear_cache();
        showMes(false, "Xoá thành công");
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function deleteBulk()
    {
        $check = $this->checkPermission('recruitment', "category");
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $ids = $this->input->post('ids');

        // $this->db->where_in('id', $ids);
        // $this->db->delete('recruit_categories');

        if (!empty($ids)) {
            if (is_array($ids)) {

                $this->db->where_in('id', $ids);
            } else {
                $this->db->where('id', $ids);
            }

            if (!$this->db->delete('recruit_categories')) {
                return showMes(true, 'Lỗi xóa dữ liệu!');
            }
        }

        return showMes(false, 'Xóa thành công!');
    }

    public function deactive($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "category");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->category_model->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->category_model->Update(array('status' => 0), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }

        return showMes(false, 'Đã bỏ kích hoạt thành công');
    }
    public function active($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "category");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->category_model->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->category_model->Update(array('status' => 1), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }

        return showMes(false, 'Đã kích hoạt');
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
