<?php
class ShopCart extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'product');
        $this->load->model('User_model', 'user');
        $this->load->model('OrderDetail_model', 'order_detail');
        $this->load->model('OrderItem_model', 'order_item');
    }
    function add($id = 0, $qty = 1)
    {
        $id = intval($id);
        $dataEm = $this->product->GetId($id);
        if (!$dataEm) return showMes(true, 'Không tìm thấy thông tin sản phẩm');
        $quantity = empty($this->input->get('qty')) ? 1 : intval($this->input->get('qty'));
        $qty = $quantity > $qty ? $quantity : 1;
        $dataCart = $this->cart->contents();
        $exs = array_search($id, array_column($dataCart, 'id', 'rowid'));
        $dataIn = false;
        $kq = false;
        $update = false;
        $dataSe = $this->cart->get_item($exs);
        if (!empty($exs) && $dataSe != false) {
            $dataIn = array("rowid" => $dataSe['rowid'], "qty" => intval($dataSe["qty"]) + $qty);
            $update = true;
        } else $dataIn = array(
            'id' => $dataEm->id,
            'name' => $dataEm->name,
            'price' => $dataEm->price,
            'qty'   => $qty,
            'options' => array(),
            'cover' => $dataEm->cover,
            'max_qty' => $dataEm->quantity
        );
        if ($dataIn['qty'] > $dataEm->quantity) return showMes(true, "Số lượng sản phẩm không đủ");
        $kq = $update ? $this->cart->update($dataIn) : $this->cart->Insert($dataIn);
        if (!$kq) return showMes(true, "Lỗi thêm sản phẩm");
        return showMes(false, 'Thành công', $this->cart->contents());
    }
    function update_all()
    {
        $kq = false;
        $ids = empty($this->input->post('id')) ? array() : $this->input->post('id');
        $dataCart = $this->cart->contents();
        $cart_id = array_column($dataCart, 'id', 'rowid');
        $diff = array_diff($cart_id, $ids);
        foreach ($ids as $id) {
            $id = intval($id);
            $exs = array_search($id, $cart_id);
            if (empty($exs)) {
                $dataEm = $this->product->GetId($id);
                if (!$dataEm) continue;
                $dataIn = array(
                    'id' => $dataEm->id,
                    'name' => $dataEm->name,
                    'price' => $dataEm->price,
                    'qty'   => 1,
                    'options' => array(),
                    'cover' => $dataEm->cover,
                    'max_qty' => $dataEm->quantity
                );
                $kq = $this->cart->insert($dataIn);
                if (!$kq) return showMes(true, "Lỗi cập nhật sản phẩm");
            } else {
                $dataIn = array("rowid" => $exs, "qty" => intval($this->input->post('val_' . $id)));
                $kq = $this->cart->update($dataIn);
                if (!$kq) return showMes(true, "Lỗi cập nhật sản phẩm");
            }
        };
        foreach ($diff as $id) {
            $exs = array_search($id, $cart_id);
            $dataIn = array("rowid" => $exs, "qty" => 0);
            $kq = $this->cart->update($dataIn);
            if (!$kq) return showMes(true, "Lỗi cập nhật sản phẩm");
        }
        return showMes(false, 'Cập nhật thành công', $this->cart->contents());
    }
    function remove($id = 0)
    {
        $id = intval($id);
        $dataCart = $this->cart->contents();
        $exs = array_search($id, array_column($dataCart, 'id', 'rowid'));
        if (empty($exs)) return showMes(true, 'Sản phẩm không có trong giỏ hàng');
        $dataIn = array("rowid" => $exs, "qty" => 0);
        $kq = $this->cart->update($dataIn);
        if (!$kq) return showMes(true, "Lỗi xóa sản phẩm");
        return showMes(false, 'Xóa Thành công', $this->cart->contents());
    }

    function checkOut()
    {   
        $phone = empty($this->input->post('phone')) ? '0948498651' : $this->input->post('phone');
        $sexual = empty($this->input->post('sexual')) ? '1' : intval($this->input->post('sexual'));
        $username = empty($this->input->post('username')) ? 'Nguyen Thanh Dam' : $this->input->post('username');
        $email = empty($this->input->post('email')) ? 'nguyendam521@gmail.com' : $this->input->post('email');
        $province = empty($this->input->post('province')) ? '1' : intval($this->input->post('province'));
        $district = empty($this->input->post('district')) ? '1' : intval($this->input->post('district'));
        $ward = empty($this->input->post('ward')) ? '1' : intval($this->input->post('ward'));
        $address = empty($this->input->post('address')) ? 'Long Truong Q9' : $this->input->post('address');
        $comments = empty($this->input->post('comments')) ? 'Day la ghi chu' : $this->input->post('comments');
        $pay_type = empty($this->input->post('pay_type')) ? '1' : intval($this->input->post('pay_type'));
        $dataUser = array(
            'username' => $username,
            'phone' => $phone,
            'male' => $sexual,
            'email' => $email,
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
            'note' => $comments
        );
        $checkUser = $this->user->GetIdWhere(array('phone' => trim($phone)));
        if (!$checkUser) {
            $kq =  $this->user->Insert($dataUser);
            if (!$kq) return showMes(true, 'Lỗi thêm user');
        } else {
            $kq = $this->user->Update($dataUser, $checkUser->id);
            if (!$kq) return showMes(true, 'Lỗi cập nhật user');
        }
        $dataOrder = array(
            'phone' => $phone,
            'total' => $this->cart->total() + 20000,
            'created_at' => time(),
            'updated_at' => 0,
            'pay_type' => $pay_type
        );
        $order_id =  $this->order_detail->Insert($dataOrder);
        if (!$order_id) return showMes(true, 'Lỗi thêm phiếu mua hàng');

        $itemCard = $this->cart->contents();
        foreach($itemCard as $item) {
            $dataInsert = array(
                'order_id' => $order_id,
                'product_id' => $item['id'],
                'quantity'=> $item['qty'],
                'created_at' => time()
            );
            $this->order_item->Insert($dataInsert);
        }
        $this->cart->destroy();
        $url = base_url('shop/order_success/' . $order_id);
        return showMes(false, 'Thành công', $url);
    }
}
