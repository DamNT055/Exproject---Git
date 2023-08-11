

<script type="text/javascript" src="<?php echo base_url("assets/js/sweetalert2/sweetalert2.min.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/js/sweetalert2/sweetalert2.min.css"); ?>">
<section class="content-header">

<ol class="breadcrumb">

        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class=""><a href="<?php echo base_url('recruitment'); ?>">Tuyển dụng</a></li>
        <li class="active">Cấu hình</li>


</ol>
<ul class="right-button">
    <li><button id="add_brand" class="btn btn-primary pull-left" data-toggle="modal" data-target="#modal-item" style="font-size:12px;display:none">
                <i class="fa fa-plus"></i> Thêm thương hiệu
            </button></li>
    <li><button id="add_button" data-toggle="modal" data-target="#dataModal" type="button" class="btn btn-block btn-primary" style="display:none"><i class="fa fa-plus" aria-hidden="true"></i> Thêm danh mục</button></li>
    <li><button id="add_email" data-toggle="modal" data-target="#dataModal" type="button" class="btn btn-block btn-primary" style="display:none"><i class="fa fa-plus" aria-hidden="true"></i> Thêm Email</button></li>
    <li><button id="add_source" data-toggle="modal" data-target="#dataModal" type="button" class="btn btn-block btn-primary" style="display:none"><i class="fa fa-plus" aria-hidden="true"></i> Thêm nguồn ứng viên</button></li>
</ul>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li id="brandclick" class="active"><a href="#brand" data-toggle="tab">Thương hiệu</a></li>
            <li id="categoryclick" class=""><a href="#tab_category" data-toggle="tab">Danh mục</a></li>
            <li id="sliderclick" class=""><a href="#tab_slider" data-toggle="tab">Slider</a></li>
            <li id="popupclick" class=""><a href="#tab_popup" data-toggle="tab">Popup</a></li>
            <li id="emailclick" class=""><a href="#tab_email" data-toggle="tab">Email nhận thông báo</a></li>
            <li id="sourceclick" class=""><a href="#tab_source" data-toggle="tab">Nguồn ứng viên</a></li>
            <li id="settingclick" class="" style="display:none"><a href="#tab_setting" data-toggle="tab">Cấu hình website</a></li>
        </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="brand">
            <table id="tableBrand" class="table table-bordered table-striped">

              <thead>
              <tr>
                <th>#</th>
                <th>Tên thương hiệu</th>
                <th>Số tin tuyển dụng</th>
                <th>Số lượng ứng tuyển</th>
                <th></th>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
        </div>
        <div class="tab-pane" id="tab_category">
            <?php include('category.php'); ?>
        </div>

        <div class="tab-pane" id="tab_slider">
            <?php include('slider.php'); ?>
        </div>

        <div class="tab-pane" id="tab_popup">
            <?php include('popup.php'); ?>
        </div>

        <div class="tab-pane" id="tab_email">
            <?php include('email.php'); ?>
        </div>
        <div class="tab-pane" id="tab_source">
            <?php include('source.php'); ?>
        </div>
        <div class="tab-pane" id="tab_setting" style="display:none">
            <div class="tabbable nav-tabs-vertical nav-tabs-left">

                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#apply" data-toggle="tab"><i class="icon-menu7 position-left"></i> Nộp hồ sơ</a></li>
                </ul>
                <div class="tab-content form-horizontal">
                    <div class="tab-pane active has-padding" id="apply">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="cv_required">Bắt buộc gửi CV</label>
                            <div class="col-md-9">
                              
                                <?php echo form_checkbox('cv_required', '1', $settings->cv_required, array('class' => 'minimal')); ?>
                            </div>

                        </div>
                    </div>
                    <div class="footer-action">
                        <div class="heading-btn pull-right">
                            <button class="btn btn-primary" type="submit" id="save">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</section>

<div class="modal fade bs-modal-md in" id="ajaxModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


<div class="modal fade" id="modal-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Thêm thương hiệu</h4>
                </div>
                <form method="post" id="brand_form">
                <div class="modal-body">
                        <div class="form-group">
                            <label>Tên thương hiệu</label>
                            <input type="text" name="name" id="brand_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" name="description" id="brand_description" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="callout callout-danger" id="alert-error" style="margin: 0px 10px 10px; display: none;">Lỗi dữ liệu</div>
                            <div class="callout callout-success" id="alert-ok" style="margin: 0px 10px 10px; display: none;">Đăng ký thành công</div>
                        </div>

    			</div>

                <div class="modal-footer" id="accept-button">
                            <input type="hidden" name="brand_id" id="brand_id" />
                          <input type="submit" name="action" id="action" class="btn btn-success" value="Thêm" />
                          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>

                </form>
            </div>
        </div>
      </div>
      <script defer type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>
<script defer>
$('body').tooltip({selector: '[data-toggle="tooltip"]'});
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
$(function(){
        $('#add_brand').show();
        $('#add_button').hide();
        $('#add_email').hide();
    });

    $('#brandclick').click(function(){
        $('.right-button li button').hide();
        $('#add_brand').show();
    });

    $('#categoryclick').click(function(){
        $('.right-button li button').hide();
        $('#add_button').show();
    });

    $('#sliderclick').click(function(){
        $('.right-button li button').hide();
    });

    $('#emailclick').click(function(){
        $('.right-button li button').hide();
        $('#add_email').show();
    });

    $('#sourceclick').click(function(){
        $('.right-button li button').hide();
        $('#add_source').show();
    });


$(function() {
        table_brand = $('#tableBrand').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
            //dom: 'Bfrtip',
            ajax: {
                url : "<?php echo base_url('recruitment/brand/get_items'); ?>",
                type : 'POST'
            },

            order: [[ 0, "desc" ]],
            info: false,
            autoWidth: false,
            pageLength  : 10,
            lengthChange: false,
            columnDefs:[
                {
                     "targets":[2],
                     "orderable":false,
                },

           ],

            columns: [
                {data:"id"},
                {data: "name"},
                {data: "job_count"},
                {data: "apply_count"},
                {data: "action"}
            ],
        });

    })

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function toFloat(a){
        a = a || 0;
        return parseFloat(a);
    }

    $('#add_brand').click(function(){
           $('#brand_form')[0].reset();
           $('.modal-title').text("Thêm thương hiệu");
           $('#action').val("Thêm");
           $('#brand_id').val("");

      })

    $(document).on('submit', '#brand_form', function(event){
           event.preventDefault();
                $.ajax({
                     url:"<?php echo base_url('recruitment/brand/data_action'); ?>",
                     method:'POST',
                     data:new FormData(this),
                     contentType:false,
                     processData:false,
                     success:function(data)
                     {
                        if (data.error) {
                        if(jQuery.type( data.message ) == "string"){
                            showErrorMessage(json.message);
                        }
                            $.each(data.message, function(key, value) {
                                var element = $('#brand_' + key);

                                element.closest('div.form-group')
                                .removeClass('has-error')
                                .addClass(value.length > 0  ? 'has-error' : 'has-success')
                                .find('.text-danger')
                                .remove();

                                element.after(value);
                            });



                    } else {
                        $('.form-group').removeClass('has-error')
									.removeClass('has-success');
                        $('.text-danger').remove();
                        swal(
                                'Good Job!',
                                data.message,
                                'success'
                                )
                            $('#brand_form')[0].reset();
                            $('#modal-item').modal('hide');
                            table_brand.ajax.reload();
                        }


                    }


                });

      });

    $(document).on('click','#tableBrand .update', function(){
           var brand_id = $(this).attr("data-id");
           $.ajax({
                url:"<?php echo base_url('recruitment/brand/fetch_single_data'); ?>",
                method:"POST",
                data:{brand_id:brand_id},
                dataType:"json",
                success:function(data)
                {
                     $('#modal-item').modal('show');
                     $('#brand_name').val(data.name);

                     $('#brand_description').val(data.description);
                     $('.modal-title').text("Sửa Thương hiệu");
                     $('#brand_id').val(brand_id);
                     $('#action').val("Cập nhật");
                }
           })
      });

    function remove_brand(id) {
        if (!confirm('Bạn có chắc chắn muốn xoá dòng này này?')) return false;
        var url = "<?php echo base_url('recruitment/brand/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            table_brand.ajax.reload();
        });
    }

    (function($) {
            'use strict';
            $.ajaxModal = function(selector, url, onLoad) {

            $(selector).removeData('bs.modal').modal({
                show: true
            });
            $(selector+' .modal-dialog').removeData('bs.modal').load(url);

            // Trigger to do stuff with form loaded in modal
            $(document).trigger("ajaxPageLoad");

            // Call onload method if it was passed in function call
            if (typeof onLoad != "undefined") {
                onLoad();
            }

            // Reset modal when it hides
            $(selector).on('hidden.bs.modal', function () {
                $(this).find('.modal-body').html('Loading...');
                $(this).find('.modal-footer').html('<button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>');
                $(this).data('bs.modal', null);
            });
            };
        })(jQuery);


        // Prevent submit of ajax form
$(document).on("ready", function() {
    $(".ajax-form").on("submit", function(e){
        e.preventDefault();
    })
});
$(document).on("ajaxPageLoad", function() {
    $(".ajax-form").on("submit", function(e){
        e.preventDefault();
    })
});

$(document).on('submit', '#slider_form', function(event){
           event.preventDefault();
                $.ajax({
                     url:"<?php echo base_url('recruitment/slider/dataAction'); ?>",
                     method:'POST',
                     data:new FormData(this),
                     contentType:false,
                     processData:false,
                     success:function(data)
                     {
                        if (data.error) {
                            if(jQuery.type( data.message ) == "string"){
                                showErrorMessage(data.message);
                            }
                            $.each(data.message, function(key, value) {
                                var element = $('#' + key);

                                element.closest('div.form-group')
                                .removeClass('has-error')
                                .addClass(value.length > 0  ? 'has-error' : 'has-success')
                                .find('.text-danger')
                                .remove();

                                element.closest('div.form-group').append(value);
                            });
                        } else {
                            $('.form-group').removeClass('has-error').removeClass('has-success');
                            $('.text-danger').remove();
                            $('#slider_form')[0].reset();
                            showOkMessage(data.message);
                            $('#ajaxModal').modal('hide');
                            table_slider.ajax.reload();
                        }
                     }
                });
      });
 
 $(document).on('submit', '#category_form', function(event){
           event.preventDefault();
           var url = $(this).data('url');
                $.ajax({
                     url:url,
                     method:'POST',
                     data:new FormData(this),
                     contentType:false,
                     processData:false,
                     dataType: "JSON",
                     success:function(data)
                     {
                        if (data.error) {
                         if(jQuery.type( data.message ) == "string"){
                              showErrorMessage(data.message);
                         }
                            $.each(data.message, function(key, value) {
                                var element = $('#' + key);

                                element.closest('div.form-group')
                                .removeClass('has-error')
                                .addClass(value.length > 0  ? 'has-error' : 'has-success')
                                .find('.text-danger')
                                .remove();

                                element.closest('div.form-group').append(value);
                            });



                        } else {
                            $('.form-group').removeClass('has-error').removeClass('has-success');
                            $('.text-danger').remove();
                            showOkMessage(data.message);
                            //$('#category_form')[0].reset();
                            $('#ajaxModal').modal('hide');
                            table1.ajax.reload();
                        }
                    }
                });
      });
      </script>
<style>.bg-red-400 {color:#fff;}.post-image #image-preview {width:100%;min-height:250px;border-radius:0;border:none;}#img-review {border-radius:0;}
@media (min-width: 769px) {
  .nav-tabs-vertical {
    display: table;
    width: 100%;
  }
  .nav-tabs-vertical > .nav-tabs {
    display: table-cell;
    border-bottom: 0;
    width: 300px;
  }
  .nav-tabs-vertical > .nav-tabs > li {
      float:none;
    display: block;
    margin-bottom: 0;
  }
  .nav-tabs-vertical > .nav-tabs-solid > li:last-child > a:after {
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
  }
  .nav-tabs-vertical > .nav-tabs[class*=bg-] > li:first-child > a {
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
  }
  .nav-tabs-vertical > .nav-tabs[class*=bg-] > li:last-child > a {
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
  }
  .nav-tabs-vertical > .tab-content {
    display: table-cell;
  }
  .nav-tabs-vertical > .tab-content > .has-padding {
    padding: 0;
    padding-top: 10.5px;
  }
  .nav-tabs-vertical.tab-content-bordered > .tab-content {
    border-top-width: 1px;
  }
  .nav-tabs-left > .nav-tabs {
    border-right: 1px solid #ddd;
  }
  .nav-tabs-left > .nav-tabs > li {
    margin-right: -1px;
  }
  .nav-tabs-left > .nav-tabs > li.active > a,
  .nav-tabs-left > .nav-tabs > li.active > a:hover,
  .nav-tabs-left > .nav-tabs > li.active > a:focus {
    border-bottom-color: #ddd;
    border-right-color: transparent;
  }
  .nav-tabs-left > .nav-tabs.nav-tabs-component > li > a {
    border-radius: 3px 0 0 3px;
  }
  .nav-tabs-left > .nav-tabs-highlight > li > a,
  .nav-tabs-left > .nav-tabs-highlight > li > a:hover,
  .nav-tabs-left > .nav-tabs-highlight > li > a:focus {
    border-top-width: 1px;
    border-left-width: 3px;
  }
  .nav-tabs-left > .nav-tabs-highlight > li.active > a,
  .nav-tabs-left > .nav-tabs-highlight > li.active > a:hover,
  .nav-tabs-left > .nav-tabs-highlight > li.active > a:focus {
    border-top-color: #ddd;
    border-left-color: #3c8dbc;
  }
  .nav-tabs-left > .nav-tabs-top,
  .nav-tabs-left > .nav-tabs-bottom {
    padding-right: 20px;
  }
  .nav-tabs-left > .top-divided,
  .nav-tabs-left > .bottom-divided {
    padding-right: 0;
    border-right-width: 0;
  }
  .nav-tabs-left > .nav-tabs-solid,
  .nav-tabs-left > .nav-tabs[class*=bg-] {
    border-right: 0;
    border-radius: 3px;
  }
  .nav-tabs-left > .nav-tabs-solid > li,
  .nav-tabs-left > .nav-tabs[class*=bg-] > li {
    margin-right: 0;
  }
  .nav-tabs-left > .tab-content {
    padding-left: 20px;
  }
  .nav-tabs-left.tab-content-bordered > .tab-content {
    border-left-width: 0;
  }
  .nav-tabs-right > .nav-tabs {
    border-left: 1px solid #ddd;
    margin-bottom: 0;
    margin-top: 20px;
  }
  .nav-tabs-right > .nav-tabs > li {
    margin-left: -1px;
  }
  .nav-tabs-right > .nav-tabs > li.active > a,
  .nav-tabs-right > .nav-tabs > li.active > a:hover,
  .nav-tabs-right > .nav-tabs > li.active > a:focus {
    border-bottom-color: #ddd;
    border-left-color: transparent;
  }
  .nav-tabs-right > .nav-tabs.nav-tabs-component > li > a {
    border-radius: 0 3px 3px 0;
  }
  .nav-tabs-right > .nav-tabs-highlight > li > a,
  .nav-tabs-right > .nav-tabs-highlight > li > a:hover,
  .nav-tabs-right > .nav-tabs-highlight > li > a:focus {
    border-top-width: 1px;
    border-right-width: 2px;
  }
  .nav-tabs-right > .nav-tabs-highlight > li.active > a,
  .nav-tabs-right > .nav-tabs-highlight > li.active > a:hover,
  .nav-tabs-right > .nav-tabs-highlight > li.active > a:focus {
    border-top-color: #ddd;
    border-right-color: #EC407A;
  }
  .nav-tabs-right > .nav-tabs-top,
  .nav-tabs-right > .nav-tabs-bottom {
    padding-left: 20px;
  }
  .nav-tabs-right > .top-divided,
  .nav-tabs-right > .bottom-divided {
    padding-left: 0;
    border-left-width: 0;
  }
  .nav-tabs-right > .nav-tabs-solid,
  .nav-tabs-right > .nav-tabs[class*=bg-] {
    border-left: 0;
    border-radius: 3px;
  }
  .nav-tabs-right > .nav-tabs-solid > li,
  .nav-tabs-right > .nav-tabs[class*=bg-] > li {
    margin-left: 0;
  }
  .nav-tabs-right > .tab-content {
    padding-right: 20px;
  }
  .nav-tabs-right.tab-content-bordered > .tab-content {
    border-right-width: 0;
  }
    .nav-tabs-left .nav-tabs > li > a {
        margin-right: 0;
        color: #888;
        border-radius: 0;
    }
    .form-horizontal .control-label:not(.text-right) {
        text-align: left;
        font-weight: 400;
    }
}
@media (max-width: 768px){
    .nav-tabs-left .nav-tabs {
        border-bottom: 0;
        position: relative;
        background-color: #fff;
        padding: 7px 0;
        border: 1px solid #ddd;
        border-radius: 3px;
        margin-bottom: 20px;
    }
    .nav-tabs-left .nav-tabs:before {
        content: 'Cấu hình';
        color: inherit;
        font-size: 12px;
        line-height: 1.6666667;
        margin-top: 8px;
        margin-left: 15px;
        margin-bottom: 15px;
        text-transform: uppercase;
        opacity: 0.5;
        filter: alpha(opacity=50);
    }
    .nav-tabs-left .nav-tabs>li {
        float:none;
        
    }
    .nav-tabs-left .nav-tabs>li> a {
        display: block;
        padding: 9px 15px;
        margin-right: 0;
    }
    .nav-tabs-left .nav-tabs > li.active > a, .nav-tabs-left .nav-tabs > li.active > a:hover, .nav-tabs-left .nav-tabs > li.active > a:focus {
        border: 0;
        background-color: #f5f5f5;
    }
    .nav-tabs-left .nav-tabs > li.active > a:after, .nav-tabs-left .nav-tabs > li.active > a:hover:after, .nav-tabs-left .nav-tabs > li.active > a:focus:after {
        content: '';
        position: absolute;
        top: 0;
        left: -1px;
        bottom: 0;
        width: 2px;
        background-color: #2196F3;
    }
}
#tab_setting .icheckbox_minimal-blue {
    margin-top:7px;
}
</style>
