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
              <li class="breadcrumb-item"><a href="https://freshcart.codescandy.com/pages/shop-grid.html#!">Home</a>
              </li>
              <li class="breadcrumb-item"><a href="https://freshcart.codescandy.com/pages/shop-grid.html#!">Shop</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page"><?= $detail->name ?></li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- section -->
  <div class=" mt-8 mb-lg-14 mb-8">
    <!-- container -->
    <div class="container">
      <!-- row -->
      <div class="row gx-10">
        <!-- col -->
        <aside class="col-lg-3 col-md-4 mb-6 mb-md-0">
          <div class="offcanvas offcanvas-start offcanvas-collapse w-md-50 " tabindex="-1" id="offcanvasCategory" aria-labelledby="offcanvasCategoryLabel">

            <div class="offcanvas-header d-lg-none">
              <h5 class="offcanvas-title" id="offcanvasCategoryLabel">Filter</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body ps-lg-2 pt-lg-0">
              <div class="mb-8">
                <!-- title -->
                <h5 class="mb-3">Nhóm sản phẩm</h5>
                <!-- nav -->
                <ul class="nav nav-category" id="categoryCollapseMenu">
                  <?php foreach ($category as $row) { ?>
                    <li class="nav-item border-bottom w-100"><a href="<?= base_url('collections/' . $row->id); ?>" class="nav-link"><?= $row->name ?> <i class="feather-icon icon-chevron-right"></i></a>
                      <!-- accordion collapse -->
                      <div id="categoryFlush<?= $row->id ?>" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu" style="">
                      </div>
                    </li>
                  <?php } ?>
                </ul>
                <!-- endd -->
              </div>

              <div class="mb-8">
                <!-- price -->
                <h5 class="mb-3">Mức giá</h5>
                <div>
                  <!-- range -->
                  <div id="priceRange" class="mb-3"></div>
                  <small class="text-muted">Giá:</small> <span id="priceRange-value" class="small"></span>
                </div>
              </div>
              <!-- rating -->
              <div class="mb-8">

                <h5 class="mb-3">Rating</h5>
                <div>
                  <!-- form check -->
                  <div class="form-check mb-2">
                    <!-- input -->
                    <input class="form-check-input" type="checkbox" value="" id="ratingFive">
                    <label class="form-check-label" for="ratingFive">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star-fill text-warning "></i>
                    </label>
                  </div>
                  <!-- form check -->
                  <div class="form-check mb-2">
                    <!-- input -->
                    <input class="form-check-input" type="checkbox" value="" id="ratingFour" checked="">
                    <label class="form-check-label" for="ratingFour">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star text-warning"></i>
                    </label>
                  </div>
                  <!-- form check -->
                  <div class="form-check mb-2">
                    <!-- input -->
                    <input class="form-check-input" type="checkbox" value="" id="ratingThree">
                    <label class="form-check-label" for="ratingThree">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star-fill text-warning "></i>
                      <i class="bi bi-star text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                    </label>
                  </div>
                  <!-- form check -->
                  <div class="form-check mb-2">
                    <!-- input -->
                    <input class="form-check-input" type="checkbox" value="" id="ratingTwo">
                    <label class="form-check-label" for="ratingTwo">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                    </label>
                  </div>
                  <!-- form check -->
                  <div class="form-check mb-2">
                    <!-- input -->
                    <input class="form-check-input" type="checkbox" value="" id="ratingOne">
                    <label class="form-check-label" for="ratingOne">
                      <i class="bi bi-star-fill text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                      <i class="bi bi-star text-warning"></i>
                    </label>
                  </div>
                </div>


              </div>
              <div class="mb-8 position-relative">
                <!-- Banner Design -->
                <!-- Banner Content -->
                <div class="position-absolute p-5 py-8">
                  <h3 class="mb-0">Trái Cây Sấy Giòn</h3>
                  <p>Giảm Giá 25%</p>
                  <a href="<?= base_url('collections/1') ?>" class="btn btn-dark">Mua Ngay<i class="feather-icon icon-arrow-right ms-1"></i></a>
                </div>
                <!-- Banner Content -->
                <!-- Banner Image -->
                <!-- img --><img src="<?= base_url('assets/images/banner/assortment-citrus-fruits.png') ?>" alt="" class="img-fluid rounded ">
                <!-- Banner Image -->
              </div>
            </div>
          </div>
        </aside>
        <section class="col-lg-9 col-md-12">
          <!-- card -->
          <div class="card mb-4 bg-light border-0">
            <!-- card body -->
            <div class=" card-body p-9">
              <h2 class="mb-0 fs-1"><?= $detail->name ?></h2>
            </div>
          </div>
          <!-- list icon -->
          <div class="d-lg-flex justify-content-between align-items-center">
            <div class="mb-3 mb-lg-0">
              <p class="mb-0"> <span class="text-dark"><?= count($product) ?> </span> Products found </p>
            </div>

            <!-- icon -->
            <div class="d-md-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center justify-content-between">
                <div>

                  <a href="https://freshcart.codescandy.com/pages/shop-list.html" class="text-muted me-3"><i class="bi bi-list-ul"></i></a>
                  <a href="https://freshcart.codescandy.com/pages/shop-grid.html" class=" me-3 active"><i class="bi bi-grid"></i></a>
                  <a href="https://freshcart.codescandy.com/pages/shop-grid-3-column.html" class="me-3 text-muted"><i class="bi bi-grid-3x3-gap"></i></a>
                </div>
                <div class="ms-2 d-lg-none">
                  <a class="btn btn-outline-gray-400 text-muted" data-bs-toggle="offcanvas" href="https://freshcart.codescandy.com/pages/shop-grid.html#offcanvasCategory" role="button" aria-controls="offcanvasCategory"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter me-2">
                      <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg> Filters</a>
                </div>
              </div>

              <div class="d-flex mt-2 mt-lg-0">
                <div class="me-2 flex-grow-1">
                  <!-- select option -->
                  <select class="form-select">
                    <option selected="">Show: 50</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                  </select>
                </div>
                <div>
                  <!-- select option -->
                  <select class="form-select">
                    <option selected="">Sort by: Featured</option>
                    <option value="Low to High">Price: Low to High</option>
                    <option value="High to Low"> Price: High to Low</option>
                    <option value="Release Date"> Release Date</option>
                    <option value="Avg. Rating"> Avg. Rating</option>

                  </select>
                </div>

              </div>

            </div>
          </div>
          <!-- row -->
          <div class="row g-4 row-cols-xl-4 row-cols-lg-3 row-cols-2 row-cols-md-2 mt-2">

            <?php foreach ($product as $row) { ?>
              <!-- col -->
              <div class="col">
                <!-- card -->
                <div class="card card-product">
                  <div class="card-body">
                    <!-- badge -->
                    <div class="text-center position-relative"> <a href="<?= base_url('product/' . $row->id) ?>"><img src="<?= base_url('assets/images/product/' . $row->cover) ?>" alt="Cover Image" class="mb-3 img-fluid"></a>
                      <!-- action btn -->
                      <div class="card-product-action">
                        <button style="border-width:1px;" class="border-0 btn-action" data-id="<?=$row->id?>" data-bs-target="#quickViewModal"><i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-html="true" aria-label="Quick View" data-bs-original-title="Quick View"></i></button>
                      </div>
                    </div>
                    <!-- heading -->
                    <div class="text-small mb-1"><a href="<?=base_url('collections/'.$row->category_id ) ?>" class="text-decoration-none text-muted"><small><?= $row->category_name ?></small></a></div>
                    <h2 class="fs-6"><a href="<?=base_url('product/'.$row->id)?>" class="text-inherit text-decoration-none"><?= $row->name ?></a>
                    </h2>
                    <div class="text-warning">
                      <!-- rating -->
                      <small> <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i></small> <span class="text-muted small">5 (345)</span>
                    </div>
                    <!-- price -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                      <div><span class="text-dark"><?= number_format($row->price, 0, ',', '.') ?>đ</span>
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
          <div class="row mt-8">
            <div class="col">
              <!-- nav -->
              <nav>
                <ul class="pagination">
                  <li class="page-item disabled">
                    <a class="page-link  mx-1 " href="#" aria-label="Previous">
                      <i class="feather-icon icon-chevron-left"></i>
                    </a>
                  </li>
                  <li class="page-item "><a class="page-link  mx-1 active" href="#">1</a></li>
                  <li class="page-item"><a class="page-link mx-1 text-body" href="#">2</a></li>

                  <li class="page-item"><a class="page-link mx-1 text-body" href="#">...</a></li>
                  <li class="page-item"><a class="page-link mx-1 text-body" href="#">12</a></li>
                  <li class="page-item">
                    <a class="page-link mx-1 text-body" href="#" aria-label="Next">
                      <i class="feather-icon icon-chevron-right"></i>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- Custom JS -->
  <script>
    var category_arr = [];
    <?php foreach ($category as $row) { ?>
      category_arr[<?= $row->id ?>] = <?= json_encode($row) ?>;
    <?php } ?>

    function fillItem(id) {

    }
  </script>