<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Recruitment extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Recruitment_model", "list");
        $this->load->model("Category_model", "category");
        $this->load->model("Branch_model", "branch");
        $this->load->model("Brand_model", "brand");
        $this->load->model("RecruitLog_model", "logRecruitment");
        $this->load->model("JobBranch_model","job_branch_model");
        $this->load->model("JobBrand_model","job_brand_model");

        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'recruit_jobs',
            'id' => 'id',
        );
        $this->load->library('slug', $config);

    }

    public function index()
    {
        $check = $this->checkPermission('recruitment');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'className' => "recruitment",
            "method" => "index",
            "type_menu" => "eoffice",
            'collapse' => true,

        );
        if($this->agent->is_mobile()){
			$this->getView('index-mobile',$data);
		}else{
			$this->getView('index',$data);
		}
    }

    public function all()
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission('recruitment');
        if (!$check) {
            $data = array();
        } else {
            $data = $this->list->listAll();
        }
        $json = (object) array('data' => $data);
        echo json_encode($json);
    }

    public function deactive($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "index", "add");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->list->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->list->Update(array('status' => 0), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }

        return showMes(false, 'Đã bỏ kích hoạt thành công');
    }
    public function active($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "index", "add");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->list->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->list->Update(array('status' => 1), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }

        return showMes(false, 'Đã kích hoạt');
    }

    public function add()
    {
        $check = $this->checkPermission('recruitment', 'index','add');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'className' => "recruitment",
            "method" => "index",
            "type_menu" => "eoffice",
            "categories" => $this->category->GetAll(),
            "branch" => $this->branch->GetAll(),
            "brand" => $this->brand->GetAll(),
            'collapse' => true,
        );
        $this->getView('add', $data);
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
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]|is_unique[recruit_jobs.name]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('slug', 'Đường dẫn', 'required|is_unique[recruit_jobs.slug]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('quantity', 'Số lượng', 'numeric', array('required' => 'Trường bắt buộc là số.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {
            $start_date = $this->getTimeFormat($this->input->post('start_date'));
            $end_date = $this->getTimeFormat($this->input->post('end_date'));

            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);

            if ($start_date > $end_date) {
                return showMes(true, 'Ngày bắt đầu không thể lớn hơn ngày kết thúc');
            }
            $branch_id  = $this->input->post('branch_id');
            $branch_ids  = $this->input->post('branch_work');
            $brand_ids  = $this->input->post('brand_ids');

            $data = array(
                'created_at' => time(),
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'quantity' => $this->input->post('quantity'),
                'work_time' => $this->input->post('work_time'),
                'type' => $this->input->post('type'),
                'position' => $this->input->post('position'),
                'description' => $this->input->post('description'),
                'requirement' => $this->input->post('requirement'),
                'benefit' => $this->input->post('benefit'),
                'category_id' => intval($this->input->post('category_id')),
                'branch_id' => intval($this->input->post('branch_id')),
                'brand_id' => intval($this->input->post('brand_id')),
                'status' => intval($this->input->post('status')),
                'featured' => intval($this->input->post('featured')),
                'employee_id' => $this->userLogin->id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'is_student' => $this->input->post('is_student'),
                'seo_title' => $this->input->post('seo_title'),
                'seo_keyword' => $this->input->post('seo_keyword'),
                'seo_description' => $this->input->post('seo_description'),
                'salary' => $this->input->post('salary'),
                'cv_required' => intval($this->input->post('cv_required')),
                'mail_required' => intval($this->input->post('mail_required')),

            );

            $insert = $this->list->Insert($data);

            

            if ($insert) {
                

                if(!empty($branch_ids)){
                    foreach($branch_ids as $branch_id){
                        $branch_id = intval($branch_id);
                        if(!$this->job_branch_model->checkExist($insert, $branch_id)){
                            $add_branch = $this->job_branch_model->Insert(array(
                                'job_id' => $insert,
                                'branch_id' => $branch_id,
                            ));
                            if(!$add_branch) return showMes(true, "Có lỗi trong quá trình xử lý. Liên hệ IT để xử lý");
                        }
                    
                    }
                }
    
                if(!empty($brand_ids)){
                    foreach($brand_ids as $brand_id){
                        $brand_id = intval($brand_id);
                        if(!$this->job_brand_model->checkExist($insert, $brand_id)){
                            $add_brand = $this->job_brand_model->Insert(array(
                                'job_id' => $insert,
                                'brand_id' => $brand_id,
                            ));
                            if(!$add_brand) return showMes(true, "Có lỗi trong quá trình xử lý. Liên hệ IT để xử lý");
                        }
                    
                    }
                }
                clear_cache();
                return showMes(false, $insert);

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

    public function getTimeFormat($str)
    {
        $time = explode('/', $str);
        $timestr = "$time[2]-$time[1]-$time[0]";
        return $timestr;
    }
    /**
     * Edit Data from this method.
     *
     * @return Response
     */
    public function edit($id)
    {

        $check = $this->checkPermission('recruitment','index', 'add');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $recruitment = $this->list->GetId($id);
        $selected_branch = $this->job_branch_model->get_branchs($id);
        $selected_branch_arr = array();
        foreach($selected_branch as $branch){
            $selected_branch_arr[] = $branch->id;
        }

        $selected_brand = $this->job_brand_model->get_brands($id);
        $selected_brand_arr = array();
        foreach($selected_brand as $brand){
            $selected_brand_arr[] = $brand->id;
        }

        $data = array(
            'className' => "recruitment",
            "method" => "index",
            'collapse' => true,
            'type_menu' => "eoffice",
            'recruitment' => $recruitment,
            "categories" => $this->category->GetAll(),
            "branch" => $this->branch->GetAll(),
            "selected_branch" => $selected_branch_arr,
            "brand" => $this->brand->GetAll(),
            "selected_brand" => $selected_brand_arr,
            'collapse' => true,
        );
        $this->getView('edit', $data);

    }
    /**
     * Update Data from this method.
     *
     * @return Response
     */
    public function update($id = 0)
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission("recruitment",'index', 'add');if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}

        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('slug', 'Đường dẫn', 'required', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('quantity', 'Số lượng', 'numeric', array('required' => 'Trường bắt buộc là số.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {
            
            $list = $this->list->GetId($this->input->post("id"));

            if (!$list) {
                return showMes(true, "Không tìm thấy thông tin ứng tuyển này");
            }
            $id = $this->input->post("id");
            $start_date = $this->getTimeFormat($this->input->post('start_date'));
            $end_date = $this->getTimeFormat($this->input->post('end_date'));

            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);

            if ($start_date > $end_date) {
                return showMes(true, 'Ngày bắt đầu không thể lớn hơn ngày kết thúc');
            }

            $data = array(

                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'quantity' => $this->input->post('quantity'),
                'type' => $this->input->post('type'),
                'work_time' => $this->input->post('work_time'),
                'position' => $this->input->post('position'),
                'description' => $this->input->post('description'),
                'requirement' => $this->input->post('requirement'),
                'benefit' => $this->input->post('benefit'),
                'category_id' => intval($this->input->post('category_id')),
                'branch_id' => intval($this->input->post('branch_id')),
                // 'brand_id' => intval($this->input->post('brand_id')),
                'status' => intval($this->input->post('status')),
                'featured' => intval($this->input->post('featured')),
                'employee_id' => $this->userLogin->id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'is_student' => $this->input->post('is_student'),
                'seo_title' => $this->input->post('seo_title'),
                'seo_keyword' => $this->input->post('seo_keyword'),
                'seo_description' => $this->input->post('seo_description'),
                'salary' => $this->input->post('salary'),
                'cv_required' => intval($this->input->post('cv_required')),
                'mail_required' => intval($this->input->post('mail_required')),
            );

            /* Update Branch */
       
            $branch_ids  = $this->input->post('branch_work');
            if(is_array($branch_ids) && count($branch_ids) > 0){
                foreach($branch_ids as $branch_id){
                    $insert_branch = $this->job_branch_model->attach(array(
                        'branch_id' => $branch_id,
                        'job_id' => $id
                    ));
                    if(!$insert_branch) return showMes(true, "Không thể thêm: ".$this->db->last_query());
                }
                $this->job_branch_model->detach($id, $branch_ids);
            }else{
                $this->job_branch_model->detach($id, $branch_ids);
            }

            /* Update Brand */
       
            $brand_ids  = $this->input->post('brand_id');
            if(is_array($brand_ids) && count($brand_ids) > 0){
                foreach($brand_ids as $brand_id){
                    $insert_brand = $this->job_brand_model->attach(array(
                        'brand_id' => $brand_id,
                        'job_id' => $id
                    ));
                    if(!$insert_brand) return showMes(true, "Không thể thêm: ".$this->db->last_query());
                }
                $this->job_brand_model->detach($id, $brand_ids);
            }else{
                $this->job_brand_model->detach($id, $brand_ids);
            }
            

            if (!$this->list->Update($data, $list->id)) {
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
                'module' => 'recruitment',
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

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id = 0)
    {
        $check = $this->checkPermission('recruitment', "index", "add");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->list->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->list->Delete($id)) {
            return showMes(true, "Lỗi data");
        }
        clear_cache();
        showMes(false, "Xoá thành công");
    }

    public function reports()
    {
        $check = $this->checkPermission('recruitment');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'className' => "recruitment",
            "method" => "reports",
            "type_menu" => "eoffice",
            "branch" => $this->input->get("name"),
        );
        $this->getView('reports', $data);
    }

    public function report_list()
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission('recruitment');
        if (!$check) {
            $data = array();
        } else {
            $from = $this->input->get("from");
            if (strlen($from) < 8) {
                $from = date("d/m/Y");
            }

            $to = $this->input->get("to");
            if (strlen($to) < 8) {
                $to = date("d/m/Y");
            }

            $time = explode("/", $from);
            $from = strtotime("$time[2]-$time[1]-$time[0]");
            $time = explode("/", $to);
            $to = strtotime("$time[2]-$time[1]-$time[0]");
            $data = $this->list->reports($from, $to);
        }
        $json = (object) array('data' => $data);
        echo json_encode($json);
    }
    public function report_detail()
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission('recruitment');
        $job = $this->input->get('job_id');
        if (!$check || !$job) {
            $data = array();
        } else {
            $from = $this->input->get("from");
            if (strlen($from) < 8) {
                $from = date("d/m/Y");
            }

            $to = $this->input->get("to");
            if (strlen($to) < 8) {
                $to = date("d/m/Y");
            }

            $time = explode("/", $from);
            $from = strtotime("$time[2]-$time[1]-$time[0]");
            $time = explode("/", $to);
            $to = strtotime("$time[2]-$time[1]-$time[0]");
            $data = $this->list->reports_detail($job, $from, $to);
        }
        $json = (object) array('data' => $data);
        echo json_encode($json);
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
