<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	public function index()
	{
		$check = $this->session->has_userdata('logged_in') && !empty($this->session->userdata('logged_in'));
		if (!$check) return redirect(base_url('signin'));
		$data = array(
			'view' => 'user.php',
			'user_type' => empty($this->session->userdata('type')) ? 0 : 1,
		);
		$this->load->view('home', $data);
	}
	public function post()
	{
		$check = $this->session->has_userdata('logged_in') && !empty($this->session->userdata('logged_in'));
		if (!$check) return redirect(base_url('signin'));
		$data = array(
			'view' => 'post.php',
			'user_type' => empty($this->session->userdata('type')) ? 0 : 1
		);
		$this->load->view('home', $data);
	}
	public function photo()
	{
		$check = $this->session->has_userdata('logged_in') && !empty($this->session->userdata('logged_in'));
		if (!$check) return redirect(base_url('signin'));
		$data = array(
			'view' => 'upload.php',
			'user_type' => empty($this->session->userdata('type')) ? 0 : 1,

		);
		$this->load->view('home', $data);
	}
	public function mailbox()
	{
		$check = $this->session->has_userdata('logged_in') && !empty($this->session->userdata('logged_in'));
		if (!$check) return redirect(base_url('signin'));
		$data = array(
			'view' => 'email.php',
			'user_type' => empty($this->session->userdata('type')) ? 0 : 1,
		);
		$this->load->view('home', $data);
	}
	public function youtube() {
		$check = $this->session->has_userdata('logged_in') && !empty($this->session->userdata('logged_in'));
		if (!$check) return redirect(base_url('signin'));
		$data = array(
			'view' => 'youtube.php',
			'user_type' => empty($this->session->userdata('type')) ? 0 : 1,
		);
		$this->load->view('home', $data);
	}
}
