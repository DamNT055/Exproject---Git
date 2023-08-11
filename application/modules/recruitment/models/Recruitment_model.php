<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Recruitment_model extends MY_Model
{
    public $table = 'recruit_jobs';
    public $id = 'id';

    public function listAll($id = 0)
    {
        $SQL = "SELECT recruit_jobs.* ,
              recruit_categories.name as category_name ,
              emp_branch.name as location,
              emp_branch.address as address,
              recruit_brands.name as brand,
              COUNT(recruit_apply.id) AS count
              FROM recruit_jobs
              LEFT JOIN recruit_apply ON recruit_apply.job_id = recruit_jobs.id
              LEFT JOIN recruit_categories ON recruit_categories.id = recruit_jobs.category_id
              LEFT JOIN emp_branch ON emp_branch.id = recruit_jobs.branch_id
              LEFT JOIN recruit_brands ON recruit_brands.id = recruit_jobs.brand_id
              GROUP BY recruit_jobs.id
              ORDER BY recruit_jobs.status DESC, recruit_jobs.end_date DESC, recruit_jobs.id desc";
        return $this->db->query($SQL)->result();
    }

    public function reports($from = 0, $to = 0)
    {
        $SQL = "SELECT


                            jobs.id,
                            jobs.name,
                            DATE_FORMAT(FROM_UNIXTIME(jobs.start_date), '%d/%m/%Y') start_date,
                            DATE_FORMAT(FROM_UNIXTIME(jobs.end_date), '%d/%m/%Y') end_date,
                            COUNT(recruit_apply.id) AS count
                        FROM recruit_jobs as jobs
                        LEFT JOIN recruit_apply ON recruit_apply.job_id = jobs.id
                        WHERE jobs.start_date >= $from AND jobs.start_date <= $to
                        GROUP BY jobs.id
                        ORDER BY jobs.name ASC

                ";
        //echo $SQL;
        return $this->db->query($SQL)->result();
    }

    public function reports_detail($job = '', $from = 0, $to = 0)
    {

        $SQL = "SELECT
                            recruit_apply.id,
                            DATE_FORMAT(FROM_UNIXTIME(recruit_apply.created_at), '%d/%m/%Y') created_at,
                            recruit_apply.name as candidate_name,
                            jobs.name
                   
                        FROM recruit_apply
                        LEFT JOIN recruit_jobs as jobs ON jobs.id = recruit_apply.job_id
                        WHERE recruit_apply.created_at >= $from AND recruit_apply.created_at <= $to AND jobs.id = '$job'
                        ORDER BY recruit_apply.id DESC
                ";

        return $this->db->query($SQL)->result();
    }

    public function get_job_filter($s = "",$date_from = 0, $date_to = 0, $source_id = 0, $status_id = 0, $gender = ""){
        $SQL = "SELECT *, (SELECT COUNT(recruit_apply.id) FROM recruit_apply WHERE recruit_apply.job_id = recruit_jobs.id) as count FROM recruit_jobs ORDER BY name ASC";
        return $this->db->query($SQL)->result();
    }

}
