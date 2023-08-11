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
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?=base_url('collections')?>">Shop</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
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
            <div class="col-12">
                <!-- card -->
                <div class="card py-1 border-0 mb-8">
                    <div>
                        <h1 class="fw-bold">Giỏ hàng</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-8 col-md-7">

                <div class="py-3">
                    <ul class="list-group list-group-flush">

                        <?php $idx=0; foreach ($cart as $row) { ++$idx;?>
                            <!-- list group -->
                            <li class="list-group-item py-3 py-lg-0 px-0 <?php if($idx==1) echo" border-top "; if ($idx==count($cart)) echo" border-bottom "?>">
                                <!-- row -->
                                <div class="row align-items-center">
                                    <div class="col-3 col-md-2">
                                        <!-- img --> <img src="<?= base_url('assets/images/product/'.$row['cover']) ?>" alt="Ecommerce" class="img-fluid">
                                    </div>
                                    <div class="col-4 col-md-5">
                                        <!-- title -->
                                        <a href="<?=base_url('product/'.$row['id'])?>" class="text-inherit">
                                            <h6 class="mb-0"><?=$row['name']?> </h6>
                                        </a>
                                        <!-- text -->
                                        <div class="mt-2 small lh-1"> <a data-value="<?=$row['id']?>" href="#" class="text-decoration-none text-inherit btn-remove-cart"> <span class="me-1 align-text-bottom">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-success">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg></span><span class="text-muted">Remove</span></a></div>
                                    </div>
                                    <!-- input group -->
                                    <div class="col-3 col-md-3 col-lg-2">
                                        <!-- input -->
                                        <div class="input-group input-spinner  ">
                                            <input type="button" value="-" class="button-minus  btn  btn-sm " data-field="quantity">
                                            <input data-id="<?=$row['id']?>" type="number" step="1" max="10" value="<?=$row['qty']?>" name="quantity" class="quantity-field form-control-sm form-input input-quantity-layout">
                                            <input type="button" value="+" class="button-plus btn btn-sm " data-field="quantity">
                                        </div>

                                    </div>
                                    <!-- price -->
                                    <div class="col-2 text-lg-end text-start text-md-end col-md-2">
                                        <span class="fw-bold text-dark"><?=number_format($row['price']*$row['qty'], 0, ',', '.')?> đ</span>
                                    </div>
                                </div>

                            </li>
                        <?php } ?>

                    </ul>
                    <!-- btn -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?=base_url('collections')?>" class="btn btn-primary">Continue
                            Shopping</a>
                        <button onclick="updateAll()" class="btn btn-dark">Cập nhật</button>
                    </div>

                </div>
            </div>

            <!-- sidebar -->
            <div class="col-12 col-lg-4 col-md-5">
                <!-- card -->
                <div class="mb-5 card mt-6">
                    <div class="card-body p-6">
                        <!-- heading -->
                        <h2 class="h5 mb-4">Summary</h2>
                        <div class="card mb-2">
                            <!-- list group -->
                            <ul class="list-group list-group-flush">
                                <!-- list group item -->
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div>Tổng tiền hàng</div>

                                    </div>
                                    <span><?=formatMoney($total)?>đ</span>
                                </li>

                                <!-- list group item -->
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div>Phí dịch vụ</div>

                                    </div>
                                    <span><?=formatMoney(20000)?>đ</span>
                                </li>
                                <!-- list group item -->
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <div class="fw-bold">Tổng tiền</div>

                                    </div>
                                    <span class="fw-bold"><?=formatMoney($total+20000)?>đ</span>
                                </li>
                            </ul>

                        </div>
                        <div class="d-grid mb-1 mt-4">
                            <!-- btn -->
                            <a href="<?=base_url('shop/checkout');?>" class="btn btn-primary btn-lg d-flex justify-content-between align-items-center" type="submit">
                                Đặt hàng <span class="fw-bold"><?=formatMoney($total+20000)?>đ</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>