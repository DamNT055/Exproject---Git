<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Apply extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Apply_model", "apply_model");
        $this->load->model("Status_model", "status_model");
        $this->load->model("RecruitLog_model", "logRecruitment");
        $this->load->model("Employee_model", "employee_model");
        $this->load->model("Schedule_model", "schedule_model");
        $this->load->model("Source_model", "source_model");
        $this->load->model("Recruitment_model", "job_model");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $check = true;//$this->checkPermission('recruitment','apply');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        if(!$date_from){
            $date_from = '01/01/2017';
        }
        if(!$date_to){
            $date_to = date('d/m/Y');
        }
        $from = format_timestamp($date_from);
        $to = format_timestamp($date_to);

        $filter_status = $this->input->get("filter_status");
        if(!$filter_status || $filter_status == '' || strstr($filter_status, 'all')) $filter_status = 'all';

        $filter_job = $this->input->get("filter_job");
        if(!$filter_job || $filter_job == '' || strstr($filter_job, 'all')) $filter_job = 'all';
        
        $filter_gender = $this->input->get("filter_gender");
        if(!$filter_gender || $filter_gender == '' || strstr($filter_gender, 'all')) $filter_gender = 'all';
        
        $filter_source = $this->input->get("filter_source");
        if(!$filter_source || $filter_source == '' || strstr($filter_source, 'all')) $filter_source = 'all';

        $data = array(
            'apply' => $this->apply_model->GetAll("asc", false, "name"),
            'className' => "recruitment",
            "method" => "apply",
            "type_menu" => "eoffice",
            'collapse' => true,
            'search_text' => $this->input->get('search_text'),
            'date_from' => $date_from,
            'date_to' => $date_to,
            'filter_status' => explode(",",$filter_status),
            'filter_source' => explode(",",$filter_source),
            'filter_gender' => explode(",",$filter_gender),
            'filter_job' => explode(",",$filter_job),
            'status' => $this->status_model->GetCount($search_text, $from, $to, $source_ip, $gender_ip, $job_ip),
            'gender' => $this->apply_model->get_gender_filter($search_text, $from, $to, $status_ip, $gender_ip, $job_ip),
            'source' => $this->source_model->get_source_filter($search_text, $from, $to, $status_ip, $gender_ip, $job_ip),
            'jobs' => $this->job_model->get_job_filter($search_text, $from, $to, $source_ip, $status_ip, $gender_ip),
        );

        $this->getView('apply/index', $data);
    }

    public function get_filter(){
        $s = $this->input->get('s');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $selected_status = $this->input->get('selected_status');
        $selected_source = $this->input->get('selected_source');
        $selected_gender = $this->input->get('selected_gender');
        $selected_job = $this->input->get('selected_job');
        $from = format_timestamp($date_from);
        $to = format_timestamp($date_to);
        
        $status = $this->status_model->GetCount($s, $from, $to, $selected_source, $selected_gender, $selected_job);
        $source = $this->source_model->get_source_filter($s, $from, $to, $selected_status, $selected_gender, $selected_job);
        $gender = $this->apply_model->get_gender_filter($s, $from, $to, $selected_status, $selected_gender, $selected_job);
        $jobs = $this->job_model->get_job_filter($s, $from, $to, $selected_source, $selected_status, $selected_gender);

        $response = array();
        $response['status'] = '<option value="">- Trạng thái -</option>';
        foreach($status as $row){
            if($row->id == $selected_status){
                $response['status'] .= '<option selected value="'.$row->id.'">'.$row->name.' ('.$row->count.')</option>';
            }else{
                $response['status'] .= '<option value="'.$row->id.'">'.$row->name.' ('.$row->count.')</option>';
            }
            
        }

        $response['gender'] = '<option value="">- Giới tính -</option>';
        foreach($gender as $row){
            if($row->gender_id == $selected_gender){
                $response['gender'] .= '<option selected value="'.$row->gender_id.'">'.$row->gender_name.' ('.$row->count.')</option>';
            }else{
                $response['gender'] .= '<option value="'.$row->gender_id.'">'.$row->gender_name.' ('.$row->count.')</option>';
            }
            
        }
    
        $response['source'] = '<option value="">- Nguồn ứng tuyển -</option>';
        foreach($source as $row){
            if($row->id == $selected_source){
                $response['source'] .= '<option selected value="'.$row->id.'">'.$row->name.' ('.$row->count.')</option>';
            }else{
                $response['source'] .= '<option value="'.$row->id.'">'.$row->name.' ('.$row->count.')</option>';
            }
            
        }

        $response['job'] = '<option value="">- Công việc -</option>';
        foreach($jobs as $row){
            if($row->id == $selected_job){
                $response['job'] .= '<option selected value="'.$row->id.'">'.$row->name.' ('.$row->count.')</option>';
            }else{
                $response['job'] .= '<option value="'.$row->id.'">'.$row->name.' ('.$row->count.')</option>';
            }
            
        }

        echo json_encode($response);
        exit();
    }
    public function all()
    {
        header("Content-type: application/json; charset=utf-8");
        $check = true;//$this->checkPermission('recruitment','apply');
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $length = ($length >= 1) ? $length : 50;
        
        $page = round($start/$length) + 1;
        $page = ($page >= 1) ? $page : 1;
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        if(!$check){
            $data = array();
            $count = 0;
        }else{
            
            $filter_status = $this->input->post("filter_status");
            if(!$filter_status || $filter_status == '' || strstr($filter_status, 'all')) $filter_status = '';

            $filter_job = $this->input->post("filter_job");
            if(!$filter_job || $filter_job == '' || strstr($filter_job, 'all')) $filter_job = '';
            
            $filter_gender = $this->input->post("filter_gender");
            if($filter_gender == '' || strstr($filter_gender, 'all')) $filter_gender = '';
            
            $filter_source = $this->input->post("filter_source");
            if(!$filter_source || $filter_source == '' || strstr($filter_source, 'all')) $filter_source = '';

            $date_from = $this->input->post('date_from');
            $date_to = $this->input->post('date_to');
            if(!$date_from){
                $date_from = date('Y-m-01');
            }
            if(!$date_to){
                $date_to = date('Y-m-d');
            }
            $filter = array(
                'date_from' => $date_from,
                'date_to' => $date_to,
                'filter_status' => $filter_status,
                'filter_job' => $filter_job,
                'filter_gender' => $filter_gender,
                'filter_source' => $filter_source,
                's' => trim($this->input->post("s"))
            );


            $data = $this->apply_model->GetListNew($filter,$start,$length);
            $count = $this->apply_model->GetListNew($filter,-1);
        }
        $json = (object) array('recordsFiltered' => $count, 'recordsTotal' => $count, 'totalPage' => ceil($count/$length), 'data' => $data);
        echo json_encode($json);
        exit();
    }

    

    public function update($id){
        $check = $this->checkPermission("recruitment", "apply");
        if(!$check) return showMes(true, "Bạn không có quyền truy cập");
        $dataEm = $this->apply_model->GetId($id);
        if(!$dataEm) return showMes(true, "Không tìm thấy thông tin Hóa đơn này");
        
        $type = $this->input->post('update_type');
        $content = array();
        $data = array(
            'updated_at' => time()
        );
        
        $old_source = $this->source_model->GetId($dataEm->source_id);
        $input = "source_id";
        $data[$input] = $this->input->post($input)?$this->input->post($input):$dataEm->$input;
        $new_source = $this->source_model->GetId($data[$input]);
        if($data[$input] != $dataEm->source_id) $content[] = "<b>Nguồn ứng viên: </b>". $old_source->name . " -> " . $new_source->name;

        if(!$this->apply_model->Update($data, $id)) return showMes(true, "Có lỗi trong quá trình sửa. Liên hệ IT để xử lý");

        $last_query = $this->db->last_query();
        if(count($content) > 0){
            $content = implode("<br>",$content);
                $this->logRecruitment->Insert(array(
                    'employee_id' => $this->userLogin->id,
                    'detail_id' => $id,
                    'content' => $content,
                    'query' => $last_query,
                    'time' => time(),
                    'module' => 'apply'
                ));
        }

        return showMes(false, "Cập nhật thành công");

    }

    public function fetchSingleData()
    {
        $data = $this->apply_model->getDetail($_POST["apply_id"]);
        echo json_encode($data);
    }

    /**
     * Delete Data from this method.
     *
     * @return Response
     */
    public function delete($id = 0)
    {
        $check = $this->checkPermission('recruitment', "apply");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->apply_model->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->apply_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }

        showMes(false, "Xoá thành công");
    }

    public function updateStatus($id = 0)
    {
        $check = $this->checkPermission("recruitment", "apply");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }

        $job_apply = $this->apply_model->GetId($id);
        if (!$job_apply) {
            return showMes(true, "Không tìm thấy thông tin Ứng viên này");
        }

        $data = array(
            'status_id' => $this->input->post('status_id'),
            'updated_at' => time(),
        );

        $status = $this->status_model->GetId($data['status_id']);
        if (!$status) {
            return showMes(true, "Không tìm thấy Trạng thái");
        }

        if (!$this->apply_model->Update($data, $id)) {
            return showMes(true, "Có lỗi trong quá trình cập nhật. Liên hệ IT để xử lý");
        }

        $content = "Cập nhật thông tin ứng tuyển";
        if ($data['status_id'] != $job_apply->status_id) {
            $content = "Cập nhật Trạng thái ứng tuyển thành <b>$status->name</b>";
        }

        /* Update Log */
        $last_query = $this->db->last_query();
        $log = array(
            'employee_id' => $this->userLogin->id,
            'detail_id' => $id,
            'content' => $content,
            'query' => $last_query,
            'time' => time(),
            'module' => 'apply',
        );
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        }

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
        }
        $this->logRecruitment->Insert($log);

        return showMes(false, "Cập nhật thành công");
    }

    public function detail_apply($id)
    {
        $schedule = $this->schedule_model->getSchedule($id);
        $schedule_object = array();
        $index = 0;

        foreach ($schedule as $value => $item) {
            $sub_array = array();

            $sub_array['schedule_date'] = date("d/m/Y", $item->schedule_date);
            $sub_array['schedule_time'] = $item->schedule_time;

            $sub_array['employee'] = $this->employee_model->getEmp($id);
            $schedule_object = (object) $sub_array;

        }
        $data = array(
            'candidate' => $this->apply_model->getDetail($id),
            'schedule' => $schedule_object,
        );
        return $this->load->view('apply/partials/detail_apply', $data);
    }

    public function createSchedule($id)
    {
        $data = array(
            'candidate' => $this->apply_model->getDetail($id),
            'employees' => $this->employee_model->GetAll("asc", false, "full_name"),
        );
        return $this->load->view('apply/partials/schedule', $data);
    }

    public function storeSchedule()
    {
        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('candidate', 'Ứng viên', 'required', array('required' => 'Chưa chọn %s.'));
        $this->form_validation->set_rules('schedule_date', 'Ngày', 'required', array('required' => 'Vui lòng chọn %s.'));
        $this->form_validation->set_rules('schedule_time', 'Giờ', 'required', array('required' => 'Vui lòng chọn %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            $schedule_date = strtotime($this->input->post('schedule_time'));

            $employees = $this->input->post('employee');

            $data = array(
                'created_at' => time(),
                'updated_at' => time(),
                'schedule_date' => $schedule_date,
                'schedule_time' => $this->input->post('schedule_time'),
                'apply_id' => $this->input->post('candidate'),
            );

            $insert = $this->schedule_model->Insert($data);
            foreach ($employees as $emp) {
                $this->schedule_model->insert_schedule_assign($insert, $emp);
            }

            $content = "Thêm lịch hẹn cho ứng viên";
            /* Update Log */
            $last_query = $this->db->last_query();
            $log = array(
                'employee_id' => $this->userLogin->id,
                'detail_id' => $insert,
                'content' => $content,
                'query' => $last_query,
                'time' => time(),
                'module' => 'apply',
            );
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            }

            if (isset($_SERVER['REMOTE_ADDR'])) {
                $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
            }
            $this->logRecruitment->Insert($log);

            if ($insert) {
                return showMes(false, "Thêm lịch hẹn thành công :)");
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

    // File upload
    public function file_upload_cv(){

        if(!empty($_FILES['file']['name'])){
    
        // Set preference
        $config['upload_path'] = 'uploads/'; 
        $config['allowed_types'] = 'doc|docx|pdf|jpg|png';
        $config['max_size'] = '1024'; // max_size in kb
        $config['file_name'] = $_FILES['file']['name'];
    
        //Load upload library
        $this->load->library('upload',$config); 
    
        // File upload
            if($this->upload->do_upload('file')){
                // Get data about the file
                $uploadData = $this->upload->data();
            }
        }
    }

    /**
     * Edit Data from this method.
     *
     * @return Response
     */
    public function edit($id)
    {
        $check = true;//$this->checkPermission('recruitment', 'apply');
        if (!$check && $this->userLogin->title_id != 17) {
            //var_dump($this->userLogin);
            $this->getView('no-permission');
            return false;
        }
        $detail = $this->apply_model->getDetail($id);
        if (empty($detail)) {
            redirect(base_url('recruitment/apply'));
        }
        $schedule = $this->schedule_model->getSchedule($id);
        $schedule_object = array();


        foreach ($schedule as $value => $item) {
            $sub_array = array();

            $sub_array['schedule_date'] = date("d/m/Y", $item->schedule_date);
            $sub_array['schedule_time'] = $item->schedule_time;

            $sub_array['employee'] = $this->employee_model->getEmp($id);
            $schedule_object = (object) $sub_array;

        }

        $data = array(
            'className' => "recruitment",
            "method" => "apply",
            'collapse' => true,
            'type_menu' => "eoffice",
            'detail' => $detail,
            'status' => $this->status_model->GetCount(),
            'sources' => $this->source_model->GetAll(),
            'schedule' => $schedule_object,
            'current_status' => $this->status_model->GetId($detail->status_id),
        );
        $this->getView('apply/edit', $data);

    }

    function change_log($id = 0)
	{
		$check = $this->checkPermission('recruitment', 'apply');
        if(!$check) return showMes(true, "Bạn không có quyền truy cập");
        $apply = $this->apply_model->GetId($id);
        if(!$apply) return showMes(true, "Không tìm thấy thông tin Phiếu này");
        $update_status = false;
        $content = array();

        $status_id = $this->input->post('status_id') ? intval($this->input->post('status_id')) : false;
        if ($status_id) {
            $status = $this->status_model->GetId($status_id);
            if ($status_id != $apply->status_id) {
                $data = array(
                    'status_id' => $status_id,
                    'updated_at' => time(),
                );
                if (!$this->apply_model->Update($data, $id)) {
                    return showMes(true, "Có lỗi trong quá trình sửa phiếu. Liên hệ IT để xử lý");
                }
                $content[] = "Cập nhật Trạng thái ứng tuyển thành <b>$status->name</b>";
                $update_status = true;
            }
        }

        

        $last_query = $this->db->last_query();
        $note = $this->input->post('note')?($this->input->post('note')): "";
        if($note)
        $content[] = "Ghi chú: ".$note;

        if (count($content) > 0) {
            $content = implode("<br>", $content);
            $data_log = array(
                'employee_id' => $this->userLogin->id,
                'detail_id' => $id,
                'content' => $content,
                'query' => $last_query,
                'time' => time(),
                'module' => 'apply'
            );
            if($update_status){
                $data_log['state'] = $status->class_name;
                $data_log['status_id'] = $status->id;
            }

            $log = $this->logRecruitment->Insert($data_log);
            if(!$log) return showMes(true, "Không thể ghi LOG: ".$this->db->last_query());
        }

        
        
		return showMes(false, "Cập nhật thành công");
    }

    public function history($id = 0)
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission('recruitment', 'apply');
        if (!$check) {
            $data = array();
        } else {
            $data = $this->logRecruitment->GetList($id, "apply");

        }
        $json = (object) array('data' => $data);
        echo json_encode($json);
    }

    function import(){
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission('recruitment', 'apply');
        if(!$check) return showMes(true, "Bạn không có quyền truy cập");
        
        if(isset($_FILES["file"]) && isset($_FILES["file"]["name"]) && strlen($_FILES["file"]["name"]) > 3){
            $this->load->library('excel');
            $filename = time()."-".convert_name($_FILES["file"]["name"]);
            $config = array();
            $config['upload_path'] = './assets/uploads/apply/import/';
            $config['file_name'] = $filename;
            $config['allowed_types'] = 'xls|xlsx';
            $config['max_size'] = '1048576';
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            if($this->upload->do_upload('file')){
                $dataUpload = $this->upload->data();
                $filename = $dataUpload['file_name'];
                $file = './assets/uploads/apply/import/'.$filename;
                require_once APPPATH . "/third_party/PHPExcel.php";
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($file);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($file);
                    //$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $row=0;

                    $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Numbe of rows avalable in excel      	 
                    $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);                
                    //loop from first data untill last data
                    for($i=2;$i<=$totalrows;$i++)
                    {
                        $name = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
                        if($name){
                            $inserdata[$row]['name'] = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();			
                            $inserdata[$row]['gender'] = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); //Excel Column 2
                            if($inserdata[$row]['gender'] == 'Nam'){
                                $inserdata[$row]['gender'] = 1;
                            }else{
                                $inserdata[$row]['gender'] = 0;
                            }
                            $birthday =  $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
                            if($birthday){
                                $inserdata[$row]['birthday'] = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
                            }
                            $inserdata[$row]['phone'] = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
                            $inserdata[$row]['email'] = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue(); 
                            $inserdata[$row]['facebook'] = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
                            
                            $job_id =  $objWorksheet->getCellByColumnAndRow(7,$i)->getValue() ?  $objWorksheet->getCellByColumnAndRow(7,$i)->getValue() : 1;
                            $inserdata[$row]['job_id'] = $job_id;
                            $inserdata[$row]['source_id'] = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
                            $inserdata[$row]['created_at'] = time();
                            $inserdata[$row]['status_id'] = 1;
                            $row++;
                        }
                        
                    } 
                    //var_dump($inserdata);die;
                    $result = $this->apply_model->importData($inserdata);   
                    if($result){
                        return showMes(false, "Import thành công");
                    }else{
                        @unlink('./assets/uploads/apply/import/'.$filename);
                        return showMes(true, "Không tìm thấy dữ liệu Import");
                    }             
    
                } catch (Exception $e) {
           
                    return showMes(true, 'Error loading file "' . pathinfo($file, PATHINFO_BASENAME)
                    . '": ' .$e->getMessage());
                }

                
            }else{
                $error = strip_tags($this->upload->display_errors());
                return showMes(true, $error);
            }
        }
        return showMes(true, "Lỗi không thể tải file");
    }

}
