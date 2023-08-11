<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Product_model', 'product');
	}
	public function index()
	{	
		$data['new_product'] = $this->product->GetDetail(array(0), true, 10);
		$data['best_product'] = $this->product->GetDetail(array(5,12,30), false, 3);	
		$this->getView('website/home', $data);
	}
	public function cate() {
		$this->getView('website/shop');
	}
}
