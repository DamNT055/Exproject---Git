<?php

defined('BASEPATH') or exit('No direct script access allowed');

class News extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("News_model", "news");
        $this->load->model("RecruitLog_model", "logRecruitment");
        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'recruit_news',
            'id' => 'id',
        );
        $this->load->library('slug', $config);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $check = $this->checkPermission('recruitment','news');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'news' => $this->news->GetAll("asc", false, "name"),
            'className' => "recruitment",
            "method" => "news",
            "type_menu" => "eoffice",
            'collapse' => true,
        );
        $this->getView('news/index', $data);
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

        $query = $this->news->make_datatables();
        $data = array();
        foreach ($query as $row) {
            $sub_array = array();
            $sub_array['id'] = $row->id;
            $sub_array['name'] = $row->name;
            $sub_array['slug'] = $row->slug;
            $sub_array['created_by'] = $row->created_by;
            $sub_array['created_at'] = $row->created_at ? date("d/m/Y", $row->created_at) : '';
            $sub_array['status'] = $row->status;
            //$sub_array['action'] = '<a href="' . base_url('recruitment/news/edit/') . $row->id . '" data-id="' . $row->id . '" class="btn btn-default btn-flat edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            $sub_array['action'] = '<button id="butt_remove_' . $row->id . '"  onclick="remove(' . $row->id . ')" type="button" data-id="' . $row->id . '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
            $data[] = (object) $sub_array;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->news->get_all_data(),
            "recordsFiltered" => $this->news->get_filtered_data(),
            "data" => $data,
        );

        echo json_encode($result);
        exit();
    }

    public function add()
    {
        $check = $this->checkPermission('recruitment', 'news');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'className' => "recruitment",
            "method" => "news.add",
            "type_menu" => "eoffice",
        );
        $this->getView('news/add', $data);
    }

    /**
     * Store a newly created resource in storage.

     */
    public function store()
    {
        header("Content-type: application/json; charset=utf-8");
        //$data = array('error' => false, 'messages' => array());
        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]|is_unique[recruit_news.name]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('slug', 'Đường dẫn', 'required|is_unique[recruit_news.slug]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            $data = array(
                'created_at' => time(),
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'content' => $this->input->post('content'),
                'status' => intval($this->input->post('status')),
                'featured' => intval($this->input->post('featured')),
                'employee_id' => $this->userLogin->id,
                'seo_title' => $this->input->post('seo_title'),
                'seo_keyword' => $this->input->post('seo_keyword'),
                'seo_description' => $this->input->post('seo_description'),

            );
            
            if (!empty($_FILES['image']['name'])) {
                $upload = $this->upload_file('image');
                if($upload) {
                    $data['image'] = $upload['file_name'];
                }else{
                    return showMes(true, "Lỗi không thể upload file.");
                }
            }

            $insert = $this->news->Insert($data);
            if ($insert) {
                clear_cache();
                return showMes(false, "Thêm tin tức thành công :)");
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
     * Edit Data from this method.
     *
     * @return Response
     */
    public function edit($id)
    {
        $check = $this->checkPermission('recruitment', 'news');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $detail = $this->news->GetId($id);

        $data = array(
            'className' => "recruitment",
            'method' => "news",
            'collapse' => true,
            'type_menu' => "eoffice",
            'detail' => $detail,
        );
        $this->getView('news/edit', $data);

    }

    /**
     * Update Data from this method.
     *
     * @return Response
     */
    public function update($id = 0)
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission('recruitment',"news");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}

        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('slug', 'Đường dẫn', 'required', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            $news = $this->news->GetId($this->input->post("id"));

            if (!$news) {
                return showMes(true, "Không tìm thấy thông tin sản phẩm này");
            }

            $data = array(
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'content' => $this->input->post('content'),
                'status' => intval($this->input->post('status')),
                'featured' => intval($this->input->post('featured')),
                'employee_id' => $this->userLogin->id,
                'seo_title' => $this->input->post('seo_title'),
                'seo_keyword' => $this->input->post('seo_keyword'),
                'seo_description' => $this->input->post('seo_description'),
            );

            if (!empty($_FILES['image']['name'])) {
                $upload = $this->upload_file('image');
                if($upload) {
                    $data['image'] = $upload['file_name'];
                }else{
                    return showMes(true, "Lỗi không thể upload file.");
                }
            }

            // if($thumbnail){
         
            //     $this->load->library('image_lib');

            //         $dataimg = str_replace('data:image/png;base64,', '', $img);
            //         $dataimg = str_replace('data:image/jpg;base64,', '', $dataimg);
            //         $dataimg = str_replace('data:image/jpeg;base64,', '', $dataimg);
            //         $dataimg = str_replace(' ', '+', $dataimg);
            //         $file_name = md5($dataimg.time()).".jpg";
            //         $dataimg = base64_decode($dataimg);
            //         file_put_contents('./assets/uploads/news/temp/'.$file_name, $dataimg);
            //         $config = array();
            //         $config['image_library']    = 'GD2';
            //         $config['source_image']     = './assets/uploads/news/temp/'.$file_name;
            //         $config['new_image']        = './assets/uploads/news/'.$file_name;
            //         $config['width'] = '600';
            //         $config['height']           = 1;
            //         $config['maintain_ratio']   = TRUE;
            //         $config['master_dim'] = 'width';
            //         $config['overwrite'] = TRUE;
            //         $this->image_lib->clear();
            //         $this->image_lib->initialize($config);				
            //         if (!$this->image_lib->resize()){
            //             return showMes(true, "Lỗi Upload hình ảnh! " . $this->image_lib->display_errors());
            //         }else{
                    
            //             @unlink('./assets/uploads/news/temp/'.$file_name);
            //         }
                
            // }

       

            if (!$this->news->Update($data, $news->id)) {
                return showMes(true, "Lỗi Data");
            }

            /* Update Log */
            $last_query = $this->db->last_query();
            $content = "Sửa tin " . $data['name'];
            $log = array(
                'employee_id' => $this->userLogin->id,
                'detail_id' => $this->input->post("id"),
                'content' => $content,
                'query' => $last_query,
                'time' => time(),
                'module' => 'news',
            );
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            }

            if (isset($_SERVER['REMOTE_ADDR'])) {
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
            }
            $this->logRecruitment->Insert($log);
            clear_cache();
            return showMes(false, "Cập nhật thành công");

        } else {

            foreach ($_POST as $key => $value) {
                $error_msg[$key] = form_error($key);
            }
        }
        
        return showMes(true, $error_msg);

    }

    public function upload_file($field){
        header('Content-Type: application/json');
        $config['upload_path']   = './assets/uploads/news/'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 1024;
        $this->load->library('upload', $config);

        if (!is_dir('./assets/uploads/news')) {
            mkdir('./assets/uploads/news', 0777, TRUE);
        }
            
        if ( ! $this->upload->do_upload($field)) {
            return false;
        }else { 
            $file = $this->upload->data();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $file['full_path']; //get original image
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 600;
            $config['height'] = 1;
            $config['maintain_ratio']   = TRUE;
            $config['master_dim'] = 'width';
            $config['overwrite'] = TRUE;
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                return showMes(true, $this->image_lib->display_errors());
                
            }
           
            //$data['image'] = $file['file_name'];
            return $file;
        
        } 
    }

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id)
    {
        $check = $this->checkPermission('recruitment', "news");
        if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->news->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->news->Delete($id)) {
            return showMes(true, "Lỗi data");
        }
        clear_cache();
        showMes(false, "Xoá thành công");
    }

    public function deactive($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "news");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->news->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->news->Update(array('status' => 0), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }
        clear_cache();
        return showMes(false, 'Đã bỏ kích hoạt thành công');
    }
    public function active($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "news");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->news->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->news->Update(array('status' => 1), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }
        clear_cache();
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
