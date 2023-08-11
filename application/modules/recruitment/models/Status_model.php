<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Status_model extends MY_Model
{
    public $table = 'recruit_status';
    public $id = 'id';

    function GetCount($s= "", $from = 0, $to = 0, $source_id = 0, $gender_id = "", $job_id = 0){
        $where = $add_where = "";
        if($from > 0 && $to > 0){
            $where = "AND recruit_apply.created_at >= $from AND recruit_apply.created_at <= $to + 86400";
        }
        if($source_id > 0){
            $where .= " AND recruit_apply.source_id = $source_id";
        }

        if($gender_id != ""){
          $where .= " AND recruit_apply.gender = $gender_id";
        }

        if($job_id > 0){
            $where .= " AND recruit_apply.job_id = $job_id";
        }

        if($s != ""){
            $where .= " WHERE recruit_apply.name LIKE '%$s%'";
        }

        $SQL = "SELECT statuss.*, count(recruit_apply.id) count
				FROM recruit_status as statuss
				LEFT JOIN recruit_apply ON statuss.id = recruit_apply.status_id
                $where
                GROUP BY statuss.id
                ORDER BY statuss.order ASC, statuss.id DESC";
		    return $this->db->query($SQL)->result();
    }

}