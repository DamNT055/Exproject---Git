<?php 
class OrderDetail_model extends MY_Model {
    var $table = "order_detail";
    var $id = "id";
    
    function GetDetail($phone = '') {
        if ($phone!='') $where = "WHERE detail.phone = ".$phone;
        else $where="";
        $SQL = "SELECT detail.*, GROUP_CONCAT(product.name separator ', ') AS product_name, 
                from_unixtime(detail.created_at, '%d-%m-%Y') AS date,
                status_detail.name AS status_name,
                status_detail.class as status_class
                FROM order_detail as detail
                LEFT JOIN order_item as item ON detail.id = item.order_id
                LEFT JOIN product ON item.product_id = product.id
                LEFT JOIN status_detail ON detail.status = status_detail.id
                $where
                GROUP BY detail.id";
        return $this->db->query($SQL)->result();
    }
}