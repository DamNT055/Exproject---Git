<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model
{
	var $table = '';
	var $id = '';
	var $level2 = 51;
	var $level3 = 3;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function DataTable(){
		$data = $this->GetAll(1,1);
		$datas = array();
		foreach($data as $row){
			$datas[] = "['".implode("','",$row)."']";
		}
		$datas = '['.implode(',',$datas).']';
		$output = "{
		  'draw': 1,
		  'recordsTotal': ".(count($data)-1).",
		  'recordsFiltered': ".(count($data)-1).",
		  'data': $datas
		}";
		return str_replace("'",'"',$output);
	}

	/*
	function PasswordEncode($value='')
	{
		return md5(md5($value).SECRECT_KEY_LOGIN);
	}
	*/

	public function GetAll($order = "desc", $array = false, $orderby = false)
	{
		$this->db->from($this->table);
		if($order != "asc" && $order != "ASC"){
			$order = "desc";
		}
		if(!$orderby) $orderby = $this->id;
		$this->db->order_by($orderby, $order);
		$query = $this->db->get();
		if(!$query) return false;
		if($array)return $query->result_array();
		return $query->result();
	}
	public function GetAllWhere($where = array(), $order = "desc", $array = false)
	{
		$this->db->from($this->table);
		$this->db->where($where);
		if($order != "asc"){
			$order = "desc";
		}
		$this->db->order_by($this->id, $order);
		$query = $this->db->get(); 		
		if(!$query) return false;
		if($array)return $query->result_array();
		return $query->result();
	}
	public function GetIdWhere($where = array())
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$query = $this->db->get();
		if(!$query) return false;
		$kq = $query->result();
		$kq = isset($kq[0])?$kq[0]:false;
		return $kq;
	}
	public function GetId($id)
	{
		$kq = $this->db->get_where($this->table, array($this->id => $id))->result();
		if(!$kq) return false;
		return $kq[0];
	}
	public function Insert($data)
	{
		$kq = false;
		if($this->db->insert($this->table, $data)) $kq = $this->db->insert_id();
		//echo $this->db->last_query();
		return $kq;
	}
	public function Update($data, $id)
	{
		$this->db->where($this->id, $id);
		$kq = $this->db->update($this->table, $data);
		//echo $this->db->last_query();
		return $kq;
	}
	public function UpdateWhere($data, $where = array())
	{
		$this->db->where($where);
		$kq = $this->db->update($this->table, $data);
		//echo $this->db->last_query();
		return $kq;
	}
	public function Delete($id)
	{
		$this->db->where($this->id, $id);
		return $this->db->delete($this->table);
	}
	public function DeleteWhere($where = array())
	{
		$this->db->where($where);
		return $this->db->delete($this->table);
	}
	function check_exists($where = array())
    {
			
	    $this->db->where($where);
	    //thuc hien cau truy van lay du lieu
		$query = $this->db->get($this->table);
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->result()[0];
		}else{
			return FALSE;
		}
	}
}