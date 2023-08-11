<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class ShopApi extends MY_controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'product');
        $this->load->model('OrderDetail_model', 'order_detail');
    }    
    function productDe($id = 0) {
        $id = intval($id);
        $dataEm = $this->product->GetId($id);
        if (!$dataEm) return showMes(true, 'Không tìm thấy sản phẩm');
        return showMes(false, 'Thanh cong', $this->product->GetDetail([$id])[0]);
    }

    function orderByPhone() {
        header('Content-type: application/json; charset=utf-8;');
        $phone = $this->input->post('phone');
        $phone = trim($phone);
        $json = (object) [
            'data' => $this->order_detail->GetDetail($phone)
        ];
        echo json_encode($json, JSON_PRETTY_PRINT);
    }
    
}