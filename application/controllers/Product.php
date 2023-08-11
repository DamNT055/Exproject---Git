<?php
class Product extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'product');
    }
    public function index($id = 0)
    {
        $id = intval($id);
        $dataDe = $this->product->GetDetail(array($id));
        if (!$id || !$dataDe) return show_404();
        $data['detail'] = $dataDe[0];
        $data['images'] = json_decode($dataDe[0]->images);
        $data['product'] = $this->product->GetDetail(array(), false, 5, $dataDe[0]->category_id);
        $this->getView('website/product_detail', $data);
    }
}
