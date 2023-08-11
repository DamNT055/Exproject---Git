<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Account_model', 'account');
        $this->load->model('Email_model', 'email');
        $this->load->model('Image_model', 'image');
        $this->load->model('Blog_model', 'blog');
        $this->load->model('Video_model', 'video');
    }

    function store()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = array(
            'title' => $this->input->post('name'),
            'slug' => $this->input->post('slug'),
            'content' => $this->input->post('post'),
            'description' => $this->input->post('description'),
            'type' => $this->input->post('type'),
            'created_at' => date('Y-m-d')
        );
        if (intval($data['type']) == 0) return $this->showMes(true, 'Vui lòng chọn lại phân loại');
        $slug = $this->blog->GetIdWhere(array('slug' => $data['slug']));
        if (!empty($slug)) return $this->showMes(true, 'Slug này đã tồn tại');
        $img = $this->input->post('image');
        if (!$img) return $this->showMes(true, 'Không tìm thấy hình ảnh');
        if (!file_exists('./assets/upload/album')) {
            mkdir('./assets/upload/album', 0777, TRUE);
        }
        if (!file_exists('./assets/upload/album/temp')) {
            mkdir('./assets/upload/album/temp', 0777, TRUE);
        }
        $validExtensions = ['png', 'jpe', 'jpg'];
        if (!in_array(substr($img, 11, 3), $validExtensions)) return $this->showMes(true, 'Định dạng hình ảnh này không hợp lệ');
        $dataimg = str_replace('data:image/png;base64,', '', $img);
        $dataimg = str_replace('data:image/jpg;base64,', '', $dataimg);
        $dataimg = str_replace('data:image/jpeg;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        $md_name = md5($dataimg . time());
        $file_name = $md_name . ".jpg";
        $file_thumb = $md_name . "_thumb.jpg";
        $dataimg = base64_decode($dataimg);
        if (!$dataimg) {
            return $this->showMes(true, "Không tìm thấy hình ảnh");
        }

        file_put_contents('./assets/upload/album/temp/' . $file_name, $dataimg);
        // create Thumbnail -- IMAGE_SIZES;
        $image_sizes = array('full' => array(1200, 1), '_thumb' => array(350, 250));
        $this->load->library('image_lib');
        foreach ($image_sizes as $key => $resize) {
            $config = array();
            $config['image_library'] = 'GD2';
            $config['source_image'] = './assets/upload/album/temp/' . $file_name;
            $config['new_image'] = './assets/upload/album/' . $file_name;
            $config['width'] = $resize[0];
            $config['height'] = $resize[1];
            $config['master_dim'] = 'width';
            $config['overwrite'] = true;
            if ($key != 'full') {
                $config['maintain_ratio'] = true;
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = $key;
            }
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
                die();
                return $this->showMes(true, "Lỗi Upload hình ảnh! " . $this->image_lib->display_errors());
            }
        }
        @unlink('./assets/upload/album/temp/' . $file_name);
        @unlink('./assets/upload/album/temp/' . $file_thumb);
        $data['cover'] = $file_thumb;
        $kq = $this->blog->Insert($data);
        if (!$kq) return $this->showMes(true, 'Lỗi data');

        return $this->showMes(false, 'Thành công', $kq);
    }

    function update($id = 0)
    {
        header('Content-type: application/json; charset=UTF-8;');
        $post_id  = $this->blog->GetId(intval($id));
        if (!$post_id) return $this->showMes(true, 'Không tồn tại bài post');
        $data = array(
            'title' => $this->input->post('name'),
            'slug' => $this->input->post('slug'),
            'content' => $this->input->post('post'),
            'type' => $this->input->post('type'),
            'description' => $this->input->post('description'),
            'updated_at' => date('Y-m-d')
        );
        if (intval($data['type']) == 0) return $this->showMes(true, 'Vui lòng chọn lại phân loại');
        $slug = $this->blog->GetIdWhere(array('slug' => $data['slug'], 'id <> ' . $id => null));
        if (!empty($slug)) return $this->showMes(true, 'Slug này đã tồn tại');
        $img = $this->input->post('image');
        if (!empty($img)) {
            if (!file_exists('./assets/upload/album')) {
                mkdir('./assets/upload/album', 0777, TRUE);
            }
            if (!file_exists('./assets/upload/album/temp')) {
                mkdir('./assets/upload/album/temp', 0777, TRUE);
            }
            $validExtensions = ['png', 'jpe', 'jpg'];
            if (!in_array(substr($img, 11, 3), $validExtensions)) return $this->showMes(true, 'Định dạng này không hợp lệ');
            $dataimg = str_replace('data:image/png;base64,', '', $img);
            $dataimg = str_replace('data:image/jpg;base64,', '', $dataimg);
            $dataimg = str_replace('data:image/jpeg;base64,', '', $dataimg);
            $dataimg = str_replace(' ', '+', $dataimg);
            $md_name = md5($dataimg . time());
            $file_name = $md_name . ".jpg";
            $file_thumb = $md_name . "_thumb.jpg";
            $dataimg = base64_decode($dataimg);
            if (!$dataimg) {
                return $this->showMes(true, "Không tìm thấy hình ảnh");
            }

            file_put_contents('./assets/upload/album/temp/' . $file_name, $dataimg);
            // create Thumbnail -- IMAGE_SIZES;
            $image_sizes = array('full' => array(1200, 1), '_thumb' => array(350, 250));
            $this->load->library('image_lib');
            foreach ($image_sizes as $key => $resize) {
                $config = array();
                $config['image_library'] = 'GD2';
                $config['source_image'] = './assets/upload/album/temp/' . $file_name;
                $config['new_image'] = './assets/upload/album/' . $file_name;
                $config['width'] = $resize[0];
                $config['height'] = $resize[1];
                $config['master_dim'] = 'width';
                $config['overwrite'] = true;
                if ($key != 'full') {
                    $config['maintain_ratio'] = true;
                    $config['create_thumb'] = TRUE;
                    $config['thumb_marker'] = $key;
                }
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                    die();
                    return $this->showMes(true, "Lỗi Upload hình ảnh! " . $this->image_lib->display_errors());
                }
            }
            @unlink('./assets/upload/album/temp/' . $file_name);
            @unlink('./assets/upload/album/temp/' . $file_thumb);
            @unlink('./assets/upload/album/' . $post_id->cover);
            $data['cover'] = $file_thumb;
            ///////////
        }
        if (!$this->blog->Update($data, $id)) return $this->showMes(true, 'Lỗi data');
        return $this->showMes(false, 'Thành công');
    }

    function deletePost($id = 0)
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->blog->GetId(intval($id));
        if (!$data) return $this->showMes(true, 'Không tìm thấy bài viết');
        $this->blog->Delete(intval($id));
        return $this->showMes(false, 'Thành công');
    }

    function validate()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $account = $this->account->check_exists(array('username' => $username));
        if (!$account) return $this->showMes(true, "Tài khoản không tồn tại");
        if (!password_verify($password, $account->password)) return $this->showMes(true, "Sai thông tin tài khoản");
        $newdata = array(
            'username'  => $username,
            'type' => $account->is_admin == 1 ? true : false,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($newdata);
        return $this->showMes(false, 'Thành công');
    }

    function signout()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $array_items = array('username', 'logged_in');
        $this->session->unset_userdata($array_items);
        return $this->showMes(false, 'Thành công');
    }

    function getAllPost()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->blog->get_all_post();
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function getAccount()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->account->get_all();
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function changeAccount($id = 0)
    {
        header('Content-type: application/json; charset=UTF-8;');
        $password = $this->input->post('password');
        if (empty($password) || strlen($password) < 3) return $this->showMes(true, 'Vui lòng nhập lại mật khẩu');
        $account = $this->account->GetId($id);
        if (!$account) return $this->showMes(true, "Tài khoản không tồn tại");
        if (!$this->account->Update(array('password' => password_hash($password, PASSWORD_DEFAULT)), $id)) return $this->showMes(true, "Lỗi cập nhật");
        return $this->showMes(false, 'Thành công');
    }

    function getEmail()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->email->get_all();
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function checkMail($id = 0)
    {
        header('Content-type: application/json; charset=UTF-8;');
        $email = $this->email->GetId(intval($id));
        if (!$email) return $this->showMes(true, 'Email không tồn tại');
        $this->email->Update(array('is_read' => 1), $id);
        return $this->showMes(false, 'Thành công');
    }

    function deleteMail($id = 0)
    {
        header('Content-type: application/json; charset=UTF-8;');
        $email = $this->email->GetId(intval($id));
        if (!$email) return $this->showMes(true, 'Email không tồn tại');
        $this->email->Delete($id);
        return $this->showMes(false, 'Thành công');
    }

    function addEmail()
    {
        $email = $this->input->get('email');
        if (empty($email)) return $this->showMes(true, 'Vui lòng nhập lại email');
        $email = strtolower(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->showMes(true, 'Email không đúng');
        }
        $check_email = $this->email->GetIdWhere(array('email' => $email));
        if (!empty($check_email)) $this->email->Update(array('is_read' => 0), $check_email->id);
        else {
            $data = array(
                'email' => $email,
                'is_read' => 0
            );
            $this->email->Insert($data);
        }
        return $this->showMes(false, 'Đăng ký email thành công!');
    }

    function getImage()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->image->get_all();
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function getImageLink()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->image->get_link();
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function deleteImage($id = 0)
    {
        header('Content-type: application/json; charset=UTF-8;');
        $image = $this->image->GetId($id);
        if (!$image) return $this->showMes(true, 'Hình ảnh không tồn tại');
        $this->image->Delete($id);
        @unlink('./assets/upload/album/' . $image->name);
        return $this->showMes(false, 'Xóa thành công');
    }

    function getVideo()
    {
        header('Content-type: application/json; charset=UTF-8;');
        $data = $this->video->get_all();
        $json = (object) array('data' => $data);
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    function changeVideo($id = 0)
    {
        //header('Content-type: application/json; charset=UTF-8;');
        $id = intval($id);
        $dataEm = $this->video->GetId($id);
        if (!$dataEm) return $this->showMes(true, 'Không tồn tại ID này');
        $video = $this->input->post('url-name');
        if (empty($video) || strlen(trim($video)) < 1) return $this->showMes(true, 'Nhập lại liên kết');
        $video = $this->getYoutubeEmbedUrl(trim($video));
        if (!$video) return $this->showMes(true, 'Liên kết không hợp lệ');
        $kq = $this->video->Update(array('url' => $video), $id);
        if (!$kq) return $this->showMes(true, 'Lỗi data');
        return $this->showMes(false, 'Thành công');
    }

    function getYoutubeEmbedUrl($url)
    {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        if (empty($youtube_id)) return false;
        return 'https://www.youtube.com/embed/' . $youtube_id;
    }

    function upload()
    {
        header('Content-type: application/json; charset=UTF-8;');
        //return $this->showMes(true, 'check');
        //header('Content-type: application/json; charset=UTF-8;');
        $img = $this->input->post('file');
        if (!$img) return $this->showMes(true, 'Không tìm thấy hình ảnh');
        if (!file_exists('./assets/upload/album')) {
            mkdir('./assets/upload/album', 0777, TRUE);
        }
        if (!file_exists('./assets/upload/album/temp')) {
            mkdir('./assets/upload/album/temp', 0777, TRUE);
        }
        $validExtensions = ['png', 'jpe', 'jpg'];
        if (!in_array(substr($img, 11, 3), $validExtensions)) return $this->showMes(true, 'Định dạng này không hợp lệ');
        $dataimg = str_replace('data:image/png;base64,', '', $img);
        $dataimg = str_replace('data:image/jpg;base64,', '', $dataimg);
        $dataimg = str_replace('data:image/jpeg;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        $md_name = md5($dataimg . time());
        $file_name = $md_name . ".jpg";
        $file_thumb = $md_name . "_thumb.jpg";
        $dataimg = base64_decode($dataimg);
        if (!$dataimg) {
            return $this->showMes(true, "Không tìm thấy hình ảnh");
        }

        file_put_contents('./assets/upload/album/temp/' . $file_name, $dataimg);

        // create Thumbnail -- IMAGE_SIZES;
        $image_sizes = array('full' => array(1200, 1), '_thumb' => array(350, 250));
        $this->load->library('image_lib');
        foreach ($image_sizes as $key => $resize) {
            $config = array();
            $config['image_library'] = 'GD2';
            $config['source_image'] = './assets/upload/album/temp/' . $file_name;
            $config['new_image'] = './assets/upload/album/' . $file_name;
            $config['width'] = $resize[0];
            $config['height'] = $resize[1];
            $config['master_dim'] = 'width';
            $config['overwrite'] = true;
            if ($key != 'full') {
                $config['maintain_ratio'] = true;
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = $key;
            }
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
                die();
                return $this->showMes(true, "Lỗi Upload hình ảnh! " . $this->image_lib->display_errors());
            }
        }
        @unlink('./assets/upload/album/temp/' . $file_name);
        @unlink('./assets/upload/album/temp/' . $file_thumb);
        if (!$this->image->Insert(array('name' => $file_name))) return $this->showMes(true, "Lỗi database");
        return $this->showMes(false, 'Thành công', $file_name);
    }

    function showMes($error = false, $msg = "", $data = "")
    {
        $data = (object) array(
            'error' => $error,
            'message' => $msg,
            'data' => $data
        );
        echo json_encode($data, JSON_PRETTY_PRINT);
    }


    public function create_slug()
    {
        $slug = $this->slug($this->convert_name($this->input->get('name')));
        echo json_encode($slug, JSON_PRETTY_PRINT);
    }
    function slug($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, $divider);
        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    function convert_name($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
        $str = preg_replace("/( )/", '-', $str);
        return $str;
    }
}
