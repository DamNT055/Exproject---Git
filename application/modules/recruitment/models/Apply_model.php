<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Apply_model extends MY_Model
{
    public $table = 'recruit_apply';
    public $id = 'id';

    private $__select_column = array("id", "name", "description", "status");
    private $__order_column = array("recruit_apply.id", "recruit_apply.name");
    
    
    function GetListNew($filter = array(), $start = 0, $length = 50){
        $data = array();
        $time = time();
        $count = 0;
        $s = isset($filter['s']) ? trim($filter['s']) : '';
        $date_from = strtotime(isset($filter['date_from']) ? trim($filter['date_from']) : date("Y-m-01"));
        $date_to = strtotime(isset($filter['date_to']) ? trim($filter['date_to']) : date("Y-m-d"));        


        $filter_status = isset($filter['filter_status']) ? trim($filter['filter_status']) : '';
        $filter_job = isset($filter['filter_job']) ? trim($filter['filter_job']) : '';
        $filter_gender = isset($filter['filter_gender']) ? trim($filter['filter_gender']) : '';
        $filter_source = isset($filter['filter_source']) ? trim($filter['filter_source']) : '';


        $where = array();
        if(strlen($s) > 0){
            $where[] = "(recruit_apply.id = ".intval($s)." OR recruit_apply.name LIKE '%$s%' OR recruit_apply.phone LIKE '%$s%')";
        }
        if(strlen($filter_status) > 0){
            $where[] = "recruit_apply.status_id IN ($filter_status)";
        }
        if(strlen($filter_gender) > 0){
            $where[] = "recruit_apply.gender IN ($filter_gender)";
        }
        if(strlen($filter_job) > 0){
            $where[] = "recruit_apply.job_id IN ($filter_job)";
        }
        if(strlen($filter_source) > 0){
            $where[] = "recruit_apply.source_id IN ($filter_source)";
        }


        $date_from = strtotime(isset($filter['date_from']) ? trim($filter['date_from']) : date("Y-m-01"));
        $date_to = strtotime(isset($filter['date_to']) ? trim($filter['date_to']) : date("Y-m-d"));
        $where[] = "recruit_apply.created_at >= $date_from AND recruit_apply.created_at <= $date_to + 86400";
        $where = count($where) > 0 ? " $left_join WHERE ".implode(" AND ", $where) : '';
        if($start < 0){
            $SQL = "SELECT count(recruit_apply.id) as total
				FROM recruit_apply
                LEFT JOIN recruit_jobs as jobs ON jobs.id = recruit_apply.job_id
                LEFT JOIN recruit_status ON recruit_status.id = recruit_apply.status_id
                $where";
            $kq = $this->db->query($SQL)->result();
            return isset($kq[0]->total) ? intval($kq[0]->total) : 0;
        }
        $SQL = "SELECT
                    recruit_apply.id as id,
                    recruit_apply.name as name,
                    recruit_apply.phone as phone,
                    recruit_apply.gender as gender,
                    recruit_apply.birthday as birthday,
                    jobs.name as job,
                    recruit_status.id as status_id,
                    recruit_status.name as status_name,
                    recruit_status.class_name as status_class,
                    (SELECT recruit_log.content FROM recruit_log WHERE recruit_log.detail_id = recruit_apply.id AND recruit_log.module = 'apply' ORDER BY id DESC LIMIT 1) as last_log,
                    DATE_FORMAT(FROM_UNIXTIME(recruit_apply.created_at), '%d/%m/%Y %h:%i') created_at
				FROM recruit_apply
                LEFT JOIN recruit_jobs as jobs ON jobs.id = recruit_apply.job_id
                LEFT JOIN recruit_status ON recruit_status.id = recruit_apply.status_id
                $where
                GROUP BY recruit_apply.id
                ORDER BY recruit_apply.id DESC
                LIMIT $length OFFSET $start";
        //echo $SQL; die();
		return $this->db->query($SQL)->result();
    }

    public function getDetail($id)
    {

        $this->db->select('
        recruit_apply.*,
        jobs.name as job,
        recruit_status.id as status_id,
        recruit_status.name as status_name,
        recruit_status.class_name as status_class,
        branch.name as location,
        recruit_source.name as source,
        recruit_source.id as source_id
    ');
        //(SELECT GROUP_CONCAT(emp_branch.name) FROM emp_branch INNER JOIN recruit_job_branch ON emp_branch.id = recruit_job_branch.branch_id WHERE recruit_job_branch.job_id = recruit_apply.job_id) AS location,
        $this->db->from($this->table);
        $this->db->join('recruit_jobs as jobs', 'jobs.id = recruit_apply.job_id', 'left');
        $this->db->join('emp_branch as branch', 'branch.id = jobs.branch_id', 'left');
        $this->db->join('recruit_status', 'recruit_status.id = recruit_apply.status_id', 'left');
        $this->db->join('recruit_source', 'recruit_source.id = recruit_apply.source_id', 'left');
        $this->db->where('recruit_apply.id', $id);
        $query = $this->db->get();
        return $query->result()[0];

    }
    public function make_query()
    {
        $time = time();
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];

        $this->db->select('
        recruit_apply.id as id,
        recruit_apply.name as name,
        recruit_apply.phone as phone,
        recruit_apply.gender as gender,
        recruit_apply.birthday as birthday,
        jobs.name as job,
        recruit_status.id as status_id,
        recruit_status.name as status_name,
        recruit_status.class_name as status_class,
        (SELECT recruit_log.content FROM recruit_log WHERE recruit_log.detail_id = recruit_apply.id AND recruit_log.module = "apply" ORDER BY id DESC LIMIT 1) as last_log,
        DATE_FORMAT(FROM_UNIXTIME(recruit_apply.created_at), "%d/%m/%Y %h:%i") created_at');

        $this->db->from($this->table);
        $this->db->join('recruit_jobs as jobs', 'jobs.id = recruit_apply.job_id', 'left');
        // $this->db->join('emp_branch as branch', 'branch.id = jobs.branch_id', 'left');
        $this->db->join('recruit_status', 'recruit_status.id = recruit_apply.status_id', 'left');

        if (isset($_POST["s"]) && !empty($_POST["s"]) ) {
            $this->db->group_start();
            $this->db->or_like("recruit_apply.id", $_POST["s"]);
            $this->db->or_like("recruit_apply.name", $_POST["s"]);
            $this->db->or_like("recruit_apply.phone", $_POST["s"]);
            $this->db->group_end();
        }
        if (isset($_POST["status_id"]) && !empty($_POST["status_id"])) {
            $this->db->where('recruit_apply.status_id =',$_POST["status_id"]);
        }

        if (isset($_POST["gender_id"]) &&  $_POST["gender_id"] != "") {
            $this->db->where('recruit_apply.gender =',$_POST["gender_id"]);
        }

        if (isset($_POST["source_id"]) && !empty($_POST["source_id"])) {
            $this->db->where('recruit_apply.source_id =',$_POST["source_id"]);
        }

        if (isset($_POST["job_id"]) && !empty($_POST["job_id"])) {
    
            $this->db->where('recruit_apply.job_id', $_POST["job_id"]);
        }

        if (isset($_POST["search"]["value"])) {
            
            $this->db->like("recruit_apply.name", $_POST["search"]["value"]);
            //$this->db->or_like("recruit_apply.id", $_POST["search"]["value"]);
        }
        
        if(isset($date_from) && isset($date_to) && $date_from != '-1' && $date_to != '-1'){
            $date_from = strtotime(str_replace("/","-", $date_from));
            $date_to = strtotime(str_replace("/","-", $date_to));
            $this->db->where('recruit_apply.created_at >=', $date_from);
            $this->db->where('recruit_apply.created_at <=', $date_to + 86400);
        }
    
        if (isset($_POST["order"])) {
            $this->db->order_by($this->__order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('recruit_apply.id', 'DESC');
        }

    }
    public function make_datatables()
    {
        $this->make_query();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_all_data()
    {
        $this->db->select("recruit_apply.id");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function importData($data){
        $res = $this->db->insert_batch($this->table,$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function get_gender_filter($s = "", $date_from = 0, $date_to = 0, $status_id = 0, $source_id = 0, $job_id = 0){
        $this->db->select("recruit_apply.gender as gender_id,
        CASE
            WHEN recruit_apply.gender = 1 THEN 'Nam'
            ELSE 'Nữ'
        END gender_name,
		COUNT(recruit_apply.id) as count
		");
		$this->db->from($this->table);

        if ($s != "") {
            $this->db->group_start();
            $this->db->or_like("recruit_apply.id", $s);
            $this->db->or_like("recruit_apply.name", $s);
            $this->db->or_like("recruit_apply.phone", $s);
            $this->db->group_end();
        }

        if($date_from > 0 && $date_to > 0){
            $this->db->where('recruit_apply.created_at >=', $date_from);
            $this->db->where('recruit_apply.created_at <=', $date_to + 86400);
        }

        if($status_id > 0 ){
            $this->db->where('recruit_apply.status_id =', $status_id);
        }

        if($job_id > 0){
            $this->db->where('recruit_apply.job_id =', $job_id);
        }

        if($source_id > 0 ){
            $this->db->where('recruit_apply.source_id =', $source_id);
        }

        $this->db->group_by('recruit_apply.gender');
		$this->db->order_by('recruit_apply.gender', 'ASC');
  
        $query = $this->db->get();
		return $query->result();
    }
}
