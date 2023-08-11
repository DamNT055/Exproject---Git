<?php
class Shop extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'product');
        $this->load->model('Location_model', 'location');
        $this->load->model('District_model', 'district');
        $this->load->model('OrderDetail_model', 'order_detail');

    }
    public function index($id = 0)
    {
        $id = intval($id);
        $data = array();
        if ($id != 0) {
            $dataDe = $this->category->GetId($id);
            if (!$dataDe) return show_404();
            $data['detail'] = $dataDe;
            $data['product'] = $this->product->GetDetail(false, false, 0, $id);
        } else {
            $data['detail'] = (object) array('name' => 'Tất cả sản phẩm');
            $data['product'] = $this->product->GetDetail(array(), true);
        }
        $this->getView('website/shop', $data);
    }
    public function cart()
    {
        $data['total'] = $this->cart->total();
        $data['total_item'] = $this->cart->total_items();
        #var_dump($data);die();
        $this->getView('website/shop_cart.php', $data);
    }

    public function checkout()
    {
        $data['province'] = $this->location->GetAll();
        $data['district'] = '';
        $data['ward'] = '';
        $data['total'] = $this->cart->total();
        $data['total_item'] = $this->cart->total_items();
        $this->getView('website/shop_checkout.php', $data);
    }
    function order_success($id = 0) {
        $id = intval($id);
        $dataEm = $this->order_detail->GetId($id);
        if (!$dataEm) return show_404();
        $data['qr_code'] = '';
        $data['show_qr'] = $dataEm->pay_type==2;
        if ($dataEm->pay_type==2) $data['qr_code'] = 'https://img.vietqr.io/image/TCB-19039076780018-compact2.png?amount='.$dataEm->total.'&addInfo='.$dataEm->phone.'%20'.$dataEm->total.'vnd%20SachSanhXanh';
        $this->getView('website/order_success.php', $data);

    }
}
