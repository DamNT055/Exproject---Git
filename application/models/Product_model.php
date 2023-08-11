<?php 
class Product_model extends MY_Model {
    var $table = 'product';
    var $id = 'id';
    
    function GetDetail($id = array(0), $all = false, $limit = 0, $category_id = 0) {
        $where = array();
        $limit_qr = '';
        if (!$all && !empty($id)) $where[] = " product.id IN (".implode(',', $id).") ";
        if ($category_id!=0) $where[] = " product_category.id = $category_id "; 
        if ($limit!=0) $limit_qr = " LIMIT $limit "; 
        if (count($where)>0) $where = " WHERE ".implode(' AND ', $where);
        else $where = '';
        $where .= $limit_qr;
        $SQL = "SELECT product.*, product_category.name as category_name, product_category.icon
                FROM product
                LEFT JOIN product_category ON product.category_id = product_category.id
                $where ";
        return $this->db->query($SQL)->result();
    }
}