  <section class="mt-8">
    <div class="container">
      <div class="hero-slider ">
        <div style="background: url(<?= base_url('assets/images/slider/slider-3.jpg') ?>)no-repeat; background-size: cover; border-radius: .5rem; background-position: center;">
          <div class="ps-lg-12 py-lg-16 col-xxl-5 col-md-7 py-14 px-8 text-xs-center">
            <span class="badge text-bg-warning">Opening Sale Discount 50%</span>

            <h2 class="text-white display-5 fw-bold mt-4">Siêu Thị Đồ Ăn Vặt Sạch Cho Giới Trẻ </h2>
            <p class="lead text-light">Giới thiệu những sản phẩm đồ ăn sạch mang thương hiệu Sạch Sành Xanh.</p>
            <a href="<?=base_url('collections')?>" class="btn btn-dark mt-3">Mua Ngay <i class="feather-icon icon-arrow-right ms-1"></i></a>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Category Section Start-->
  <section class="mb-lg-10 mt-lg-14 my-8">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-6">

          <h3 class="mb-0">Nhóm Sản Phẩm</h3>

        </div>
      </div>
      <div class="category-slider ">

        <?php foreach ($category as $row) { ?>
          <div class="item"> <a href="<?= base_url('collections/' . $row->id) ?>" class="text-decoration-none text-inherit">
              <div class="card card-product mb-lg-4">
                <div class="card-body text-center py-8">
                  <img src="<?= base_url('assets/images/category/' . $row->image) ?>" alt="Grocery Ecommerce Template" class="mb-3 img-fluid">
                  <div class="text-truncate"><?= $row->name ?></div>
                </div>
              </div>
            </a></div>
        <?php } ?>

      </div>


    </div>
  </section>
  <!-- Category Section End-->
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 mb-3 mb-lg-0">
          <div>
            <div class="py-10 px-8 rounded" style="background:url(<?= base_url('assets/images/banner/grocery-banner.png') ?>)no-repeat; background-size: cover; background-position: center;">
              <div>
                <h3 class="fw-bold mb-1">Trái Cây Sấy</h3>
                <p class="mb-4">Giảm Giá Đến <span class="fw-bold">30%</span></p>
                <a href="<?= base_url('collections/1') ?>" class="btn btn-dark">Mua Ngay</a>
              </div>
            </div>

          </div>

        </div>
        <div class="col-12 col-md-6 ">

          <div>
            <div class="py-10 px-8 rounded" style="background:url(<?= base_url('assets/images/banner/grocery-banner-2.jpg') ?>)no-repeat; background-size: cover; background-position: center;">
              <div>
                <h3 class="fw-bold mb-1">Bánh, Kẹo, Mứt</h3>
                <p class="mb-4">Giảm Giá Đến <span class="fw-bold">25%</span></p>
                <a href="<?= base_url('collections/3') ?>" class="btn btn-dark">Mua Ngay</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Popular Products Start-->
  <section class="my-lg-14 my-8">
    <div class="container">
      <div class="row">
        <div class="col-12 mb-6">

          <h3 class="mb-0">Sản Phẩm Mới</h3>

        </div>
      </div>

      <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3">


        <?php foreach ($new_product as $row) { ?>
          <div class="col">
            <div class="card card-product">
              <div class="card-body">
                <div class="text-center position-relative"> <a href="<?= base_url('product/' . $row->id) ?>"><img src="<?= base_url('assets/images/product/' . $row->cover) ?>" alt="Grocery Ecommerce Template" class="mb-3 img-fluid"></a>
                  <div class="card-product-action">
                    <button style="border-width:1px;" class="border-0 btn-action" data-id="<?=$row->id?>" data-bs-target="#quickViewModal"><i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Quick View" data-bs-original-title="Quick View"></i></button>
                  </div>
                </div>
                <div class="text-small mb-1"><a href="<?= base_url('collections/' . $row->category_id) ?>" class="text-decoration-none text-muted"><small><?= $row->category_name ?></small></a></div>
                <h2 class="fs-6"><a href="<?= base_url('product/' . $row->id) ?>" class="text-inherit text-decoration-none"><?= $row->name ?></a></h2>
                <div class="text-warning">

                  <small> <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i></small> <span class="text-muted small">5 (<?= rand(1, 500) ?>)</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <div><span class="text-dark"><?= number_format($row->price, 0, ',', '.') ?>đ</span>
                  </div>
                  <div><button onclick="addItem(<?= $row->id ?>)" class="btn btn-primary btn-sm btn-add-item">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                      </svg> Thêm</button></div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>


      </div>
    </div>
  </section>
  <!-- Popular Products End-->
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-6">
          <h3 class="mb-0">Bán chạy nhất</h3>
        </div>
      </div>
      <div class="table-responsive-xl pb-6">
        <div class="row row-cols-lg-4 row-cols-1 row-cols-md-2 g-4 flex-nowrap">
          <div class="col">
            <div class=" pt-8 px-6 px-xl-8 rounded" style="background:url(<?= base_url('assets/images/banner/banner-deal.jpg') ?>)no-repeat; background-size: cover; height: 470px;">
              <div>
                <h3 class="fw-bold text-white">100% Thành Phần Thiên Nhiên.
                </h3>
                <p class="text-white">Đảm bảo an toàn cho sức khỏe.</p>
                <a href="<?=base_url('collections')?>" class="btn btn-primary">Mua Ngay<i class="feather-icon icon-arrow-right ms-1"></i></a>
              </div>
            </div>
          </div>

          <?php foreach ($best_product as $row) { ?>

            <div class="col">
              <div class="card card-product">
                <div class="card-body">
                  <div class="text-center  position-relative "> <a href="<?=base_url('product/'.$row->id)?>"><img src="<?= base_url('assets/images/product/' . $row->cover) ?>" alt="Grocery Ecommerce Template" class="mb-3 img-fluid"></a>
                    <div class="card-product-action">
                      <button style="border-width:1px;" class="border-0 btn-action" data-id="<?=$row->id?>" data-bs-target="#quickViewModal"><i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Quick View" data-bs-original-title="Quick View"></i></button>
                    </div>
                  </div>
                  <div class="text-small mb-1"><a href="<?=base_url('collections/'.$row->category_id)?>" class="text-decoration-none text-muted"><small><?= $row->category_name ?></small></a></div>
                  <h2 class="fs-6"><a href="<?=base_url('product/'.$row->id)?>" class="text-inherit text-decoration-none"><?= $row->name ?></a></h2>
                  <div class="d-flex justify-content-between align-items-center mt-3">
                    <div><span class="text-dark"><?= number_format($row->price, 0, ',', '.') ?>đ</span>
                    </div>
                    <div>
                      <small class="text-warning"> <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i></small>
                      <span><small>5</small></span>
                    </div>
                  </div>
                  <div class="d-grid mt-2"><button onclick="addItem(<?=$row->id?>)" class="btn btn-primary ">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                      </svg> Thêm giỏ hàng </button></div>
                  <div class="d-flex justify-content-start text-center mt-3">
                    <div class="deals-countdown w-100" data-countdown="2023/06/10 00:00:00"></div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

        </div>
      </div>
    </div>
  </section>


  <!-- cta section -->
  <section>
    <div class="container">
      <hr class="my-lg-14 my-8">
      <!-- row -->
      <div class="row align-items-center">
        <div class=" offset-lg-2 col-lg-4 col-md-6">
          <div class="text-center">
            <!-- img -->
            <img src="<?= base_url('assets/images/iphone-1.png') ?>" alt="" class=" img-fluid">
          </div>
        </div>
        <div class=" col-lg-6 col-md-6">
          <div class="mb-6">
            <div class="mb-7">
              <!-- heading -->
              <h2>Tải App ngay hôm nay!</h2>
              <p class="mb-0">Chúng tôi sẽ gửi cho bạn một liên kết, mở nó trên điện thoại của bạn để tải xuống ứng dụng.</p>
            </div>
            <div class="mb-5">
              <!-- form -->
              <form class="row g-3">

                <!-- col -->
                <div class="col-lg-6 col-7">
                  <!-- input -->
                  <input type="text" class="form-control" placeholder="Email">
                </div>
                <!-- col -->
                <div class="col-auto">
                  <button type="submit" class="btn btn-primary mb-3">Gửi liên kết</button>
                </div>
              </form>
            </div>
            <div>
              <!-- app -->
              <small>Download app from</small>
              <ul class="list-inline mb-0 mt-3">
                <!-- list item -->
                <li class="list-inline-item">
                  <!-- img -->
                  <a href="#!"> <img src="<?= base_url('assets/images/appstore-btn.svg') ?>" alt="" style="width: 140px;"></a>
                </li>
                <li class="list-inline-item">
                  <!-- img -->
                  <a href="#!"> <img src="<?= base_url('assets/images/googleplay-btn.svg') ?>" alt="" style="width: 140px;"></a>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
      <hr class="my-lg-14 my-8">
    </div>
  </section>

  <section class="my-lg-14 my-8">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="mb-8 mb-xl-0">
            <div class="mb-6"><img src="<?= base_url('assets/images/clock.svg') ?>" alt=""></div>
            <h3 class="h5 mb-3">
              Giao hàng sau 15 phút
            </h3>
            <p>Đơn đặt hàng của bạn được giao đến tận nhà sớm nhất từ địa chỉ gần bạn.</p>
          </div>
        </div>
        <div class="col-md-6  col-lg-3">
          <div class="mb-8 mb-xl-0">
            <div class="mb-6"><img src="<?= base_url('assets/images/gift.svg') ?>" alt=""></div>
            <h3 class="h5 mb-3">Giá, ưu đãi tốt nhất</h3>
            <p>Cam kết giá tốt nhất và nhiều ưu đãi nhất, đi kèm sản phẩm chất lượng.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="mb-8 mb-xl-0">
            <div class="mb-6"><img src="<?= base_url('assets/images/package.svg') ?>" alt=""></div>
            <h3 class="h5 mb-3">Sản phẩm đa dạng</h3>
            <p>Đa dạng sự lựa chọn với hơn 30 sản phẩm, cùng nhiều mặt hàng khác nhau.</p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="mb-8 mb-xl-0">
            <div class="mb-6"><img src="<?= base_url('assets/images/refresh-cw.svg') ?>" alt=""></div>
            <h3 class="h5 mb-3">Dễ dàng đổi trả</h3>
            <p>Thay đổi sản phẩm nhanh chóng với chính sách của chúng mình.</a>.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
