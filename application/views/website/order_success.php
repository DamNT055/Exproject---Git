<div class="vh-80 d-flex justify-content-center align-items-center">
    <div class="card col-md-5 bg-white shadow-md p-5">
        <div class="mb-4 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
            </svg>
        </div>
        <div class="text-center">
            <h1>Đặt hàng thành công !</h1>
            <p>Shop sẽ liên lạc với bạn theo số điện thoại trong thời gian sớm nhất.</p>
            <?php if ($show_qr) { ?>
            <img src="<?= $qr_code ?>" class="rounded" alt="..." style="height: 350px; width: auto">
            <p>Vui lòng thanh toán theo mã QR để Shop tiến hành xử lý đơn hàng.</p>
            <?php } ?>
            <a href="<?= base_url() ?>" class="btn btn-outline-success">Back Home</a>
        </div>
    </div>
</div>