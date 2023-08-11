<!-- section-->
<div class="mt-4">
    <div class="container">
        <!-- row -->
        <div class="row ">
            <!-- col -->
            <div class="col-12">
                <!-- breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url("collections") ?>">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh Toán</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- section -->
<section class="mb-lg-14 mb-8 mt-8">
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- col -->
            <div class="col-12">
                <div>
                    <div class="mb-8">
                        <!-- text -->
                        <h1 class="fw-bold mb-0">Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <!-- accordion -->
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <!-- accordion item -->
                        <div class="accordion-item py-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- heading one -->
                                <a href="https://freshcart.codescandy.com/pages/shop-checkout.html#" class="fs-5 text-inherit collapsed h4" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                    <i class="feather-icon icon-map-pin me-2 text-muted"></i> Địa chỉ nhận hàng
                                </a>
                                <!-- collapse -->
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show">
                                <div class="mt-5">
                                    <form class="row">
                                        <!-- input -->
                                        <div class="col-md-12 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="phone"> Số điện thoại<span class="text-danger">*</span></label>
                                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Nhập số điện thoại" required="">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="sexual"> Giới tính</label><br>
                                            <!-- radio-->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="input-sexual" id="male" value="1">
                                                <label class="form-check-label" for="male">Anh</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="input-sexual" id="female" value="0">
                                                <label class="form-check-label" for="female">Chị</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="username"> Họ và tên<span class="text-danger">*</span></label>
                                            <input type="text" id="username" name="username" class="form-control" placeholder="Nhập họ và tên" required="">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="email_id"> Email</label>
                                            <input type="text" id="email_id" name="email" class="form-control" placeholder="Nhập email" required="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="provine"> Tỉnh/Thành phố<span class="text-danger">*</span></label>
                                            <select id="province_id" class="form-select">
                                                <option selected="">- Chọn khu vực -</option>
                                                <?php foreach ($province as $row) { ?>
                                                    <option value="<?= $row->code ?>"><?= $row->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="district"> Quận/Huyện<span class="text-danger">*</span></label>
                                            <select id="district_id" class="form-select">
                                                <option selected="">- Chọn khu vực -</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="company"> Phường/Xã<span class="text-danger">*</span></label>
                                            <select id="ward_id" class="form-select">
                                                <option selected="">- Chọn khu vực -</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="address"> Địa chỉ<span class="text-danger">*</span></label>
                                            <input type="text" id="address" name="address" class="form-control" placeholder="Nhập số nhà, tên đường" required="">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <!-- input -->
                                            <label class="form-label" for="comments"> Ghi chú</label>
                                            <textarea rows="3" id="comments" class="form-control" placeholder="Thêm ghi chú"></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!-- accordion item -->
                        <div class="accordion-item py-4">
                            <a href="https://freshcart.codescandy.com/pages/shop-checkout.html#" class="text-inherit collapsed h5" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                <i class="feather-icon icon-clock me-2 text-muted"></i>Phương thức giao hàng</a>
                            <!-- collapse -->
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show">
                                <div class="card card-bordered shadow-none my-4">
                                    <!-- card body -->
                                    <div class="card-body p-6">
                                        <!-- check input -->
                                        <div class="d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDeliver" id="deliver_id" checked>
                                                <label class="form-check-label ms-2 h6" for="deliver_id">Giao hàng tiêu chuẩn</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- accordion item -->
                        <div class="accordion-item py-4">

                            <a href="https://freshcart.codescandy.com/pages/shop-checkout.html#" class="text-inherit h5" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                <i class="feather-icon icon-credit-card me-2 text-muted"></i>Phương thức thanh toán</a>
                            <div id="flush-collapseFour" class="accordion-collapse collapse show">

                                <div class="mt-5">
                                    <div>
                                        <div class="card card-bordered shadow-none mb-2">
                                            <!-- card body -->
                                            <div class="card-body p-6">
                                                <div class="d-flex">
                                                    <div class="form-check">
                                                        <input name="radioPay" value="1" class="form-check-input" type="radio" name="flexRadioCod" id="cod_pay" checked>
                                                        <label class="form-check-label h6" for="cod_pay">Thanh toán khi nhận hàng (COD)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-bordered shadow-none mb-2">
                                            <!-- card body -->
                                            <div class="card-body p-6">
                                                <div class="d-flex">
                                                    <div class="form-check">
                                                        <input name="radioPay" value="2" class="form-check-input" type="radio" name="flexRadioCod" id="atm_pay">
                                                        <label class="form-check-label h6" for="atm_pay">Thanh toán Online qua thẻ ATM nội địa</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Button -->
                                        <div class="mt-5 d-flex justify-content-end">
                                            <button onclick="submitOrder()" class="btn btn-primary ms-2">Đặt hàng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>

                <div class="col-12 col-md-12 offset-lg-1 col-lg-4">
                    <div class="mt-4 mt-lg-0">
                        <div class="card shadow-sm">
                            <h5 class="px-6 py-4 bg-transparent mb-0">Đơn hàng</h5>
                            <ul class="list-group list-group-flush">
                                <!-- list group item -->
                                <?php foreach ($cart as $row) { ?>
                                    <li class="list-group-item px-4 py-3">
                                        <div class="row align-items-center">
                                            <div class="col-2 col-md-2">
                                                <img src="<?= base_url('assets/images/product/' . $row['cover']) ?>" alt="Ecommerce" class="img-fluid">
                                            </div>
                                            <div class="col-5 col-md-5">
                                                <h6 class="mb-0"><?= $row['name'] ?></h6>
                                            </div>
                                            <div class="col-2 col-md-2 text-center text-muted">
                                                <span><?= $row['qty'] ?></span>

                                            </div>
                                            <div class="col-3 text-lg-end text-start text-md-end col-md-3">
                                                <span class="fw-bold"><?= formatMoney($row['price'] * $row['qty']) ?>đ</span>

                                            </div>
                                        </div>

                                    </li>
                                <?php } ?>



                                <!-- list group item -->
                                <li class="list-group-item px-4 py-3">
                                    <div class="d-flex align-items-center justify-content-between   mb-2">
                                        <div>Tổng tiền hàng
                                        </div>
                                        <div class="fw-bold"><?= formatMoney($total) ?>đ</div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between  ">
                                        <div>
                                            Phí dịch vụ <i class="feather-icon icon-info text-muted" data-bs-toggle="tooltip" aria-label="Default tooltip" data-bs-original-title="Default tooltip"></i>
                                        </div>
                                        <div class="fw-bold">20.000đ</div>

                                    </div>

                                </li>
                                <!-- list group item -->
                                <li class="list-group-item px-4 py-3">
                                    <div class="d-flex align-items-center justify-content-between fw-bold">
                                        <div>
                                            Tổng tiền
                                        </div>
                                        <div><?= formatMoney($total + 20000) ?>đ</div>

                                    </div>


                                </li>

                            </ul>

                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>
</section>


<style>
    .payment-check {
        height: 1.5em;
        width: 1.5em;
    }
</style>


<script>
    $("#province_id").on('change', function() {
        var province_id = $(this).val();
        var url = "<?= base_url('api/location/getDistrict?province_id=') ?>" + province_id;
        $.getJSON(url, function(data) {
            if (data && Object.keys(data).length > 0) {
                data = data.data;
                $("#district_id").html('<option selected="">- Chọn khu vực -</option>');
                data.forEach(el => {
                    $("#district_id").append(`<option value="` + el.code + `">` + el.name + `</option>`)
                });
            }
        });
    });
    $("#district_id").on('change', function() {
        var district_id = $(this).val();
        var url = "<?= base_url('api/location/getWard?district_id=') ?>" + district_id;
        $.getJSON(url, function(data) {
            if (data && Object.keys(data).length > 0) {
                data = data.data;
                $("#ward_id").html('<option selected="">- Chọn khu vực -</option>');
                data.forEach(el => {
                    $("#ward_id").append(`<option value="` + el.code + `">` + el.name + `</option>`)
                });
            }
        });
    });

    var isRequest = false;

    function submitOrder() {
        var phone = $("#phone").val();
        var sexual = $('input[name="input-sexual"]:checked').val();
        var username = $("#username").val();
        var email = $("#email_id").val();
        var province = $("#province_id").val();
        var district = $("#district_id").val();
        var ward = $("#ward_id").val();
        var address = $("#address").val();
        var comments = $("#comments").val();
        var pay_type = $('input[name="radioPay"]:checked').val();

        if (!isRequest) {
            isRequest = true;
            var urlBank = "<?= base_url() . "api/ShopCart/checkOut" ?>";
            $.ajax({
                type: 'POST',
                url: urlBank,
                data: {
                    phone: phone,
                    sexual: sexual,
                    username: username,
                    email: email,
                    province: province,
                    district: district,
                    ward: ward,
                    address: address,
                    comments: comments,
                    pay_type: pay_type
                },
                dataType: 'json',
            }).done(function(json1) {
                console.log(json1);
                if (json1.error) {
                    showErrorMessage(json1.message);
                    return false;
                } else {
                    showOkMessage(json1.message);
                    setTimeout(function() {
                        location.href = json1.data;
                    }, 2000);
                    return true;
                }
            }).always(function(msg) {
                console.log('always')
                $('#sending').hide();
                isRequest = false;
            })
        }

    }
</script>