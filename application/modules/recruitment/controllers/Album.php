<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Album extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Album_model", "album_model");
        $this->load->model("RecruitLog_model", "logRecruitment");
        $config = array(
            'field' => 'slug',
            'title' => 'name',
            'table' => 'recruit_albums',
            'id' => 'id',
        );
        $this->load->library('slug', $config);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $check = $this->checkPermission('recruitment','album');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'album' => $this->album_model->GetAll("asc", false, "name"),
            'className' => "recruitment",
            "method" => "album",
            "type_menu" => "eoffice",
        );
        $this->getView('album/index', $data);
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

        $query = $this->album_model->make_datatables();
  
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $this->album_model->get_all_data(),
            "recordsFiltered" => $this->album_model->get_filtered_data(),
            "data" => $query,
        );

        echo json_encode($result);
        exit();
    }

    public function add()
    {
        $check = $this->checkPermission('recruitment', 'album');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $data = array(
            'className' => "recruitment",
            "method" => "album.add",
            "type_menu" => "eoffice",
        );
        $this->getView('album/add', $data);
    }

    /**
     * Store a newly created resource in storage.

     */
    public function store()
    {
        header("Content-type: application/json; charset=utf-8");
        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]|is_unique[recruit_albums.name]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('slug', 'Đường dẫn', 'required|is_unique[recruit_albums.slug]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            $data = array(
                'created_at' => time(),
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'status' => intval($this->input->post('status')),
                'seo_title' => $this->input->post('seo_title'),
                'seo_keyword' => $this->input->post('seo_keyword'),
                'seo_description' => $this->input->post('seo_description'),

            );

            if (!empty($_FILES['image']['name'])) {
                $upload = $this->upload_file('image');
                if($upload) {
                    $data['image'] = $upload['file_name'];
                }else{
                    return showMes(true, "Lỗi không thể upload file");
                }
            }

            $data_image = array();
            $list_img = $this->input->post('list_img');
            if($list_img){
                if (!is_dir('./assets/uploads/album')) {
                    mkdir('./assets/uploads/album', 0777, TRUE);
                    if (!is_dir('./assets/uploads/album/temp')) {
                        mkdir('./assets/uploads/album/temp', 0777, TRUE);
                    }
                }
                $image_sizes = array('_thumb' => array(350, 250), 'full'=>array(1200,1));
                $this->load->library('image_lib');
                foreach($list_img as $img){
                    
                        $dataimg = str_replace('data:image/png;base64,', '', $img);
                        $dataimg = str_replace('data:image/jpg;base64,', '', $dataimg);
                        $dataimg = str_replace('data:image/jpeg;base64,', '', $dataimg);
                        $dataimg = str_replace(' ', '+', $dataimg);
                        $md_name = md5($dataimg.time());
                        $file_name = $md_name.".jpg";   $file_thumb = $md_name."_thumb.jpg";
                        $dataimg = base64_decode($dataimg);
                        file_put_contents('./assets/uploads/album/temp/'.$file_name, $dataimg);
                        foreach ($image_sizes as $key=>$resize) {
                        $config = array();
                        $config['image_library']    = 'GD2';
                        $config['source_image']     = './assets/uploads/album/temp/'.$file_name;
                        //$config['new_image']        = './assets/uploads/album/'.$file_name;
                        $config['width'] = $resize[0];
                        $config['height'] = $resize[1];
                        $config['maintain_ratio']   = TRUE;
                        
                        $config['master_dim'] = 'width';
                        $config['overwrite'] = TRUE;              

                        if($key != 'full'){
                            $config['maintain_ratio'] = true;
                            $config['create_thumb'] = TRUE;
                            $config['thumb_marker'] = $key;
                        }
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);				
                        if (!$this->image_lib->resize()){
                            return showMes(true, "Lỗi Upload hình ảnh! " . $this->image_lib->display_errors());
                        }
                    }

                    $this->load->library('ftp'); 
                    $this->ftp->connect($this->mia_config_ftp()); 
                    $up = $this->ftp->upload('./assets/uploads/album/temp/'.$file_name, '/var/www/tuyendung.mia.vn/public/uploads/album/'.$file_name);
                    $up = $this->ftp->upload('./assets/uploads/album/temp/'.$file_thumb, '/var/www/tuyendung.mia.vn/public/uploads/album/'.$file_thumb); 
                    $this->ftp->close(); 
                    if(!$up){ 
                        return showMes(true, 'Lỗi Upload hình ảnh! (FTP)');
                    }
                    $data_image[] = $file_name;
                    @unlink('./assets/uploads/album/temp/'.$file_name);
                    @unlink('./assets/uploads/album/temp/'.$file_thumb);
                }
            }


        
            if (count($data_image) > 0) {
                $data['images'] = json_encode($data_image);
            }

            $insert = $this->album_model->Insert($data);
            if ($insert) {
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

    /**
     * Edit Data from this method.
     *
     * @return Response
     */
    public function edit($id)
    {
        $check = $this->checkPermission('recruitment', 'album');
        if (!$check) {
            $this->getView('no-permission');
            return false;
        }
        $detail = $this->album_model->GetId($id);
        if (empty($detail)) {
            redirect(base_url('recruitment/album'));
        }
        $data = array(
            'className' => "recruitment",
            'method' => "album",
            'collapse' => true,
            'type_menu' => "eoffice",
            'detail' => $detail,
        );
        $this->getView('album/edit', $data);

    }

    /**
     * Update Data from this method.
     *
     * @return Response
     */
    public function update($id = 0)
    {
        header("Content-type: application/json; charset=utf-8");
        $check = $this->checkPermission("recruitment", 'album');if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}

        $error_msg = array();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tiêu đề', 'required|min_length[5]', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_rules('slug', 'Đường dẫn', 'required', array('required' => 'Vui lòng nhập %s.'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run()) {

            $album = $this->album_model->GetId($this->input->post("id"));

            if (!$album) {
                return showMes(true, "Không tìm thấy thông tin album này");
            }

            $data = array(
                'updated_at' => time(),
                'name' => $this->input->post('name'),
                'slug' => $this->input->post('slug'),
                'description' => $this->input->post('description'),
                'status' => intval($this->input->post('status')),
                'order' => intval($this->input->post('order')),
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

            if (!$this->album_model->Update($data, $album->id)) {
                return showMes(true, "Lỗi Data");
            }

            /* Update Log */
            $last_query = $this->db->last_query();
            $content = "Sửa tin " . $data['title'];
            $log = array(
                'employee_id' => $this->userLogin->id,
                'detail_id' => $this->input->post("id"),
                'content' => $content,
                'query' => $last_query,
                'time' => time(),
                'module' => 'album',
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
        $config['upload_path']   = './assets/uploads/album/'; 
        $config['file_name'] = $this->input->post('slug').'-thumb.jpg';
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size']      = 1024;
        $this->load->library('upload', $config);

        if (!is_dir('./assets/uploads/album')) {
            mkdir('./assets/uploads/album', 0777, TRUE);
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

            $this->load->library('ftp'); 
            $this->ftp->connect($this->mia_config_ftp()); 
            $up = $this->ftp->upload('./assets/uploads/album/'.$file['file_name'], '/var/www/tuyendung.mia.vn/public/uploads/album/'.$file['file_name']);
            $this->ftp->close(); 
            if(!$up){ 
                return showMes(true, 'Lỗi Upload hình ảnh! (FTP)');
            }
            @unlink('./assets/uploads/album/'.$file['file_name']);
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
        $check = $this->checkPermission('recruitment', "album");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $item = $this->album_model->GetId($id);
        if (!$item) {
            return showMes(true, "Không tìm thấy bản ghi này");
        }

        if (!$this->album_model->Delete($id)) {
            return showMes(true, "Lỗi data");
        }
        $images = json_decode($item->images);

        foreach($images as $img){
            //@unlink('./assets/uploads/album/' . $img);
            preg_match('/(.*)\.([^.]*)$/', $img, $matches);
            $image_name = $matches[1];
            $ext = $matches[2];
            $this->load->library('ftp'); 
            $this->ftp->connect($this->mia_config_ftp()); 
            $del1 = $this->ftp->delete_file('/var/www/tuyendung.mia.vn/public/uploads/album/'. $img);
            $del2 = $this->ftp->delete_file('/var/www/tuyendung.mia.vn/public/uploads/album/'. $image_name . '_thumb.'. $ext);
            $this->ftp->close();  
            if(!$del1 || ! $del2){ 
                return showMes(true, 'Lỗi Xoá hình ảnh! (FTP)');
            }
        }

        clear_cache();
        showMes(false, "Xoá thành công");
    }

    public function deactive($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "album");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->album_model->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->album_model->Update(array('status' => 0), $id);
        if (!$kq) {
            return showMes(true, 'Lỗi data');
        }

        return showMes(false, 'Đã bỏ kích hoạt thành công');
    }
    public function active($id = 0)
    {
        header('Content-Type: application/json; charset=utf-8');
        $check = $this->checkPermission('recruitment', "album");
        if (!$check) {
            return showMes(true, "Bạn không có quyền truy cập");
        }
        $checkEm = $this->album_model->GetId($id);
        if (!$checkEm) {
            return showMes(true, 'Không tìm thấy bản ghi này');
        }

        $kq = $this->album_model->Update(array('status' => 1), $id);
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

    public function upload($id)
    {
        $check = $this->checkPermission('recruitment', "album");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $dataEm = $this->album_model->GetId($id);
        if (!$dataEm) {
            return showMes(true, "Không tìm thấy thông tin album này");
        }

        $img = $this->input->post("file");
        if (!$img) {
            return showMes(true, "Không tìm thấy hình ảnh");
        }
        $images = array();
        if (!file_exists('./assets/uploads/album')) {
            mkdir('./assets/uploads/album', 0777, TRUE);
        }
        if (!file_exists('./assets/uploads/album/temp')) {
            mkdir('./assets/uploads/album/temp', 0777, TRUE);
        }

        $dataimg = str_replace('data:image/png;base64,', '', $img);
        $dataimg = str_replace('data:image/jpg;base64,', '', $dataimg);
        $dataimg = str_replace('data:image/jpeg;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        $md_name = md5($dataimg.time());
        $file_name = $md_name.".jpg";   $file_thumb = $md_name."_thumb.jpg";
        $dataimg = base64_decode($dataimg);
        if (!$dataimg) {
            return showMes(true, "Không tìm thấy hình ảnh");
        }

        file_put_contents('./assets/uploads/album/temp/' . $file_name, $dataimg);
        // create Thumbnail -- IMAGE_SIZES;
        $image_sizes = array('_thumb' => array(350, 250), 'full'=>array(1200,1));

        $this->load->library('image_lib');
        foreach ($image_sizes as $key=>$resize) {
            $config = array();
            $config['image_library'] = 'GD2';
            $config['source_image'] = './assets/uploads/album/temp/' . $file_name;
            //$config['new_image'] = './assets/uploads/album/' . $file_name;
            $config['width'] = $resize[0];
            $config['height'] = $resize[1];
            
            
            $config['master_dim'] = 'width';
            $config['overwrite'] = true;
            if($key != 'full'){
                $config['maintain_ratio'] = true;
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = $key;
            }
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                return showMes(true, "Lỗi Upload hình ảnh! " . $this->image_lib->display_errors());
            }
        }
        $images = json_decode($dataEm->images);
        $images = (!$images || $images == null) ? array() : $images;
        array_push($images, $file_name);
        $data = array(
            'images' => json_encode($images)
        );
        //return showMes(true, "Lỗi cập nhật Data", $data);
        if (!$this->album_model->Update($data, $dataEm->id)) {
            @unlink('./assets/uploads/album/temp/' . $file_name);
            @unlink('./assets/uploads/album/temp/' . $file_thumb);
            return showMes(true, "Lỗi cập nhật Data");
        } 
        $this->load->library('ftp'); 
        $this->ftp->connect($this->mia_config_ftp()); 
        $up = $this->ftp->upload('./assets/uploads/album/temp/'.$file_name, '/var/www/tuyendung.mia.vn/public/uploads/album/'.$file_name); 
        $up = $this->ftp->upload('./assets/uploads/album/temp/'.$file_thumb, '/var/www/tuyendung.mia.vn/public/uploads/album/'.$file_thumb); 
        $this->ftp->close(); 
        if(!$up){ 
            return showMes(true, 'Lỗi Upload hình ảnh! (FTP)');
        }
        @unlink('./assets/uploads/album/temp/' . $file_name);
        @unlink('./assets/uploads/album/temp/'.$file_thumb);
        
        clear_cache();
        showMes(false, $file_name);
        
    }
    public function delete_img($id)
    {
        $check = $this->checkPermission('recruitment', "album");if (!$check) {return showMes(true, 'Bạn không có quyền truy cập');}
        $dataEm = $this->album_model->GetId($id);
        if (!$dataEm) {
            return showMes(true, "Không tìm thấy thông tin sản phẩm này");
        }

        $img = $this->input->post("file");
        if (!$img) {
            return showMes(true, "Không tìm thấy hình ảnh");
        }

        //@unlink('./assets/uploads/album/' . $img);
        preg_match('/(.*)\.([^.]*)$/', $img, $matches);
        $image_name = $matches[1];
        $ext = $matches[2];
        // Remove Thumb
        //@unlink('./assets/uploads/album/' . $image_name . '_thumb.'. $ext);

        $this->load->library('ftp'); 
        $this->ftp->connect($this->mia_config_ftp()); 
        $del1 = $this->ftp->delete_file('/var/www/tuyendung.mia.vn/public/uploads/album/'. $img);
        $del2 = $this->ftp->delete_file('/var/www/tuyendung.mia.vn/public/uploads/album/'. $image_name . '_thumb.'. $ext);
        $this->ftp->close(); 

        if(!$del1 || ! $del2){ 
            return showMes(true, 'Lỗi Xoá hình ảnh! (FTP)');
        }
        $dataEm->images = json_decode($dataEm->images);
        $newImg = array();
        for ($i = 0; $i < count($dataEm->images); $i++) {
            $image = $dataEm->images[$i];
            if ($image != $img) {
                $newImg[] = $image;
            }

        }
        $data = array(
            'images' => json_encode($newImg),
        );
        if (!$this->album_model->Update($data, $dataEm->id)) {
            return showMes(true, "Lỗi cập nhật Data");
        }
        clear_cache();
        showMes(false, "Đã xoá");
    }

    function mia_config_ftp(){ 
        return array( 
         'hostname'  => MIA_FPT_HOST, 
         'username'  => MIA_FPT_USER, 
         'password'  => MIA_FPT_PASS, 
         'port'  => MIA_FPT_PORT, 
         'debug'     => TRUE 
        ); 
       }

}
