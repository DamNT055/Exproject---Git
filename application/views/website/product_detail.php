  <div class="mt-4">
    <div class="container">
      <!-- row -->
      <div class="row ">
        <!-- col -->
        <div class="col-12">
          <!-- breadcrumb -->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a>
              </li>
              <li class="breadcrumb-item"><a href="<?= base_url('collections/' . $detail->category_id) ?>"><?= $detail->category_name ?></a></li>

              <li class="breadcrumb-item active" aria-current="page"><?= $detail->name ?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <section class="mt-8">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          <!-- img slide -->
          <div class="product" id="product">
            <?php foreach ($images as $row) { ?>
              <div>
                <div class="zoom" onmousemove="zoom(event)" style="background-image: url(<?=base_url('assets/images/product/detail/'.$row)?>)">
                  <!-- img -->
                  <img src="<?=base_url('assets/images/product/detail/'.$row)?>" alt="">
                </div>
              </div>
            <?php } ?>
          </div>
          <!-- product tools -->
          <div class="product-tools">
            <div class="thumbnails row g-3" id="productThumbnails">
              <?php foreach ($images as $row) { ?>
                <div class="col-3">
                  <div class="thumbnails-img">
                    <!-- img -->
                    <img src="<?= base_url('assets/images/product/detail/' . $row) ?>" alt="">
                  </div>
                </div>
              <?php } ?>

            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ps-lg-10 mt-6 mt-md-0">
            <!-- content -->
            <a href="<?= base_url('collections/' . $detail->category_id) ?>" class="mb-4 d-block"><?= $detail->category_name ?></a>
            <!-- heading -->
            <h1 class="mb-1"><?= $detail->name ?> </h1>
            <div class="mb-4">
              <!-- rating -->
              <!-- rating --> <small class="text-warning"> <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i></small><a href="#" class="ms-2">(<?= rand(5, 200) ?> reviews)</a>
            </div>
            <div class="fs-4">
              <!-- price --><span class="fw-bold text-dark"><?= formatMoney($detail->price) ?>đ</span>
            </div>
            <!-- hr -->
            <hr class="my-6">
            <div class="mb-5 d-none"><button type="button" class="btn btn-outline-secondary">250g</button>
              <!-- btn --> <button type="button" class="btn btn-outline-secondary">500g</button>
              <!-- btn --> <button type="button" class="btn btn-outline-secondary">1kg</button></div>
            <div>


              <!-- input -->
              <div class="input-group input-spinner  ">
                <input type="button" value="-" class="button-minus  btn  btn-sm " data-field="quantity">
                <input id="input-quantity-detail" data-id="<?= $detail->id ?>" type="number" step="1" max="<?= $detail->quantity ?>" value="1" name="quantity" class="quantity-field form-control-sm form-input ">
                <input type="button" value="+" class="button-plus btn btn-sm " data-field="quantity">
              </div>

            </div>
            <div class="mt-3 row justify-content-start g-2 align-items-center">

              <div class="col-xxl-4 col-lg-4 col-md-5 col-5 d-grid">
                <!-- button -->
                <!-- btn --> <button onclick="addItemDetail()" type="button" class="btn btn-primary"><i class="feather-icon icon-shopping-bag me-2"></i>Thêm<br>sản phẩm</button>
              </div>
              <div class="col-md-4 col-4">
                <!-- btn -->
                <a class="btn btn-light " href="#" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Wishlist"><i class="feather-icon icon-heart"></i></a>
              </div>
            </div>
            <!-- hr -->
            <hr class="my-6">
            <div>
              <!-- table -->
              <table class="table table-borderless mb-0">

                <tbody>
                  <tr>
                    <td>Mã sản phẩm:</td>
                    <td><?= $detail->code ?></td>

                  </tr>
                  <tr>
                    <td>Tình trạng:</td>
                    <td>Còn hàng</td>

                  </tr>
                </tbody>
              </table>

            </div>
            <div class="mt-8">
              <!-- dropdown -->
              <div class="dropdown">
                <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Share
                </a>

                <ul class="dropdown-menu" style="">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-facebook me-2"></i>Facebook</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-twitter me-2"></i>Twitter</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-instagram me-2"></i>Instagram</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="mt-lg-14 mt-8 ">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills nav-lb-tab" id="myTab" role="tablist">
            <!-- nav item -->
            <li class="nav-item" role="presentation">
              <!-- btn --> <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="false" tabindex="-1">Mô Tả Sản hẩm</button>
            </li>
          </ul>
          <!-- tab content -->
          <div class="tab-content" id="myTabContent">
            <!-- tab pane -->
            <div class="tab-pane active" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">
              <div class="my-8">
                <div class="mb-5">
                  <!-- text -->
                  <h4 class="mb-3"><?= $detail->name ?></h4>
                  <p class="mb-0" style="white-space: pre-line"><?= $detail->detail ?></p>
                </div>
              </div>
            </div>
            <!-- tab pane -->

            <div class="tab-pane fade" id="sellerInfo-tab-pane" role="tabpanel" aria-labelledby="sellerInfo-tab" tabindex="0">...</div>
          </div>
        </div>
      </div>
    </div>



  </section>

  <!-- section -->
  <section class="my-lg-14 my-14">
    <div class="container">
      <!-- row -->
      <div class="row">
        <div class="col-12">
          <!-- heading -->
          <h3>Sản Phẩm Khác</h3>
        </div>
      </div>
      <!-- row -->
      <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-2 mt-2">
        <?php foreach ($product as $row) { ?>
          <!-- col -->
          <div class="col">
            <div class="card card-product">
              <div class="card-body">
                <!-- badge -->
                <div class="text-center position-relative"> <a href="<?= base_url('product/' . $row->id) ?>"><img src="<?= base_url('assets/images/product/' . $row->cover) ?>" alt="Grocery Ecommerce Template" class="mb-3 img-fluid"></a>
                  <!-- action btn -->
                  <div class="card-product-action">
                    <button style="border-width:1px;" class="border-0 btn-action" data-id="<?=$row->id?>" data-bs-target="#quickViewModal"><i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Quick View" data-bs-original-title="Quick View"></i></button>
                  </div>
                </div>
                <!-- heading -->
                <div class="text-small mb-1"><a href="<?= base_url('collections/' . $row->category_id) ?>" class="text-decoration-none text-muted"><small><?= $row->category_name ?></small></a></div>
                <h2 class="fs-6"><a href="<?= base_url('product/' . $row->id) ?>" class="text-inherit text-decoration-none"><?= $row->name ?> </a></h2>
                <div class="text-warning">

                  <small> <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i></small> <span class="text-muted small">4.5 (<?= rand(10, 200) ?>)</span>
                </div>
                <!-- price -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <div><span class="text-dark"><?= formatMoney($row->price) ?>đ</span>
                  </div>
                  <!-- btn -->
                  <div><button onclick="addItem(<?= $row->id ?>)" class="btn btn-primary btn-sm">
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

  <script>
    function addItemDetail() {
      var qty = $("#input-quantity-detail").val();
      addItem(<?= $detail->id ?>, parseInt(qty))
    }
  </script>