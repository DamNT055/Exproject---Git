<link href="<?php echo base_url("assets/css/multiple-select.css"); ?>" rel="stylesheet"/>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class=""><a href="<?php echo base_url('recruitment'); ?>">Danh sách tin tuyển dụng</a></li>
        <li class="active">Sửa tin tuyển dụng</li>
    </ol>
    <ul class="right-button">
        <li><a href="https://tuyendung.mia.vn/tuyen-dung/<?php echo $recruitment->slug; ?>" type="button" target="_blank" class="btn btn-block btn-primary" href=""><i class="fa fa-eye" aria-hidden="true"></i> Xem trên website</a></li>
    </ul>

</section>
<form action="<?php echo base_url('recruitment/update'); ?>" id="addPost" method="post">
<input type="hidden" name="id" value="<?php echo $recruitment->id; ?>">
<section class="content">
    <div class='row'>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-wrench" aria-hidden="true"></i> Thông tin cơ bản</h3>
                    <div class="pull-right box-tools">
                       
                    </div>
                </div>
                <div class="box-body">
                    

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4">Tiêu đề:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề" value="<?php echo $recruitment->name; ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix" id="edit-slug-box">
                                <label class="control-label col-sm-4">Tên đường dẫn:</label>
                                <div class="col-sm-8">
                                <div class="input-group">
                                    <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Tên đường dẫn" value="<?php echo $recruitment->slug; ?>">
                                        <span class="input-group-btn edit-slug-buttons">
                                            <button type="button" class="btn btn-primary btn-flat" id="change_slug">Sửa</button>
                                            <button type="button" class="save btn btn-success" id="btn-ok" style="display: none;">OK</button>
                                            <button type="button" class="cancel btn btn-danger" style="display: none;">Hủy bỏ</button>

                                        </span>
                                </div>
                                <div data-url="<?php echo base_url('recruitment/create_slug'); ?>" id="slug_id" data-id="<?php echo $recruitment->id; ?>"></div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4">Số lượng:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Số lượng" value="<?php echo $recruitment->quantity; ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4">Thời gian làm việc:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="work_time" name="work_time" placeholder="Thời gian làm việc" value="<?php echo $recruitment->work_time; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4">Hình thức làm việc:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" id="type" name="type" placeholder="Full Time, Part Time" value="<?php echo $recruitment->type; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4">Ngày bắt đầu</label>
                                <div class="col-sm-8">
                                    <input  type="text" class="form-control datepicker"  id="start_date" name="start_date" placeholder="<?php echo date("d/m/Y"); ?>" value="<?php echo date("d/m/Y", $recruitment->start_date); ?>" />
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="control-label col-sm-4">Ngày kết thúc</label>
                                <div class="col-sm-8">
                                    <input  type="text" class="form-control datepicker"  id="end_date" name="end_date" placeholder="<?php echo date("d/m/Y"); ?>" value="<?php echo date("d/m/Y", $recruitment->end_date); ?>" />
                                </div>
                            </div>

<div class="form-group clearfix">
    <label class="control-label col-sm-4">Thu nhập:</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="salary" name="salary" placeholder="Thu nhập" value="<?php echo $recruitment->salary; ?>">
    </div>
</div>
                        </div>
                    </div>

                    
                    
                    <!-- <div class="form-group">
                        <label>Vị trí:</label>
                        <textarea class="form-control" row="4" id="position" name="position" placeholder="Vị trí"><?php echo $recruitment->position; ?></textarea>
                    </div> -->
         

                </div>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_description" data-toggle="tab"><span>Mô tả</span></a></li>
                <li><a href="#tab_requirement" data-toggle="tab"><span>Yêu cầu</span></a></li>
                <li><a href="#tab_benefit" data-toggle="tab"><span>Quyền lợi</span></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_description">
                        <div class="form-group">
                            <label>Mô tả:</label>
                            <textarea class="form-control" row="4" id="description" name="description" placeholder="Mô tả"><?php echo $recruitment->description; ?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_requirement">
                        <div class="form-group">
                            <label>Yêu cầu:</label>
                            <textarea class="form-control" id="requirement" name="requirement" placeholder="Yêu cầu"><?php echo $recruitment->requirement; ?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_benefit">
                        <div class="form-group">
                            <label>Quyền lợi:</label>
                            <textarea class="form-control" id="benefit" name="benefit" placeholder="Quyền lợi"><?php echo $recruitment->benefit; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-cog"></i>
                        Cấu hình</h3>
                </div>
                <div class="box-body" style="padding: 0px">
                    <table class="table no-border no-padding">
                        <tbody>
                            <tr>
                                <td style="white-space: nowrap; width: 100px; vertical-align: middle;">Danh mục</td>
                                <td>
                                <select class="form-control select2" id="category_id" name="category_id" style="width:100%">
                                        <?php foreach ($categories as $row) {?>
                                        <?php if ($row->id == $recruitment->category_id): ?>
                                        <option value="<?php echo $row->id; ?>" selected><?php echo $row->name; ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                        <?php endif;?>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Địa điểm PV</td>
                                <td>
                               
                                    <select class="form-control select2" id="branch_id" name="branch_id" style="width:100%">
                                        <?php foreach ($branch as $row) {?>
                                        <?php if ($row->id == $recruitment->branch_id): ?>
                                            <option value="<?php echo $row->id; ?>" selected><?php echo $row->name; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                        <?php endif;?>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Địa điểm làm việc</td>
                                <td>
                               
                                    <select class="form-control select2" id="branch_work" name="branch_work[]" style="width:100%" multiple="multiple">
                                        <?php foreach ($branch as $row) {?>
                                        <?php if (in_array($row->id, $selected_branch)): ?>
                                            <option value="<?php echo $row->id; ?>" selected><?php echo $row->name; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                        <?php endif;?>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Thương hiệu</td>
                                <td>
                                    <select class="form-control select2" id="brand_id" name="brand_id[]" style="width:100%" multiple="multiple">
                                        <?php foreach ($brand as $row) {?>
                                        <?php if (in_array($row->id, $selected_brand)): ?>
                                            <option value="<?php echo $row->id; ?>" selected><?php echo $row->name; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                        <?php endif;?>
                                        <?php }?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Trạng thái</td>
                                <td>
                                <?php echo form_dropdown('status', array('1' => 'Kích hoạt', '0' => 'Đóng'), $recruitment->status, array('class' => 'form-control')); ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Loại tin</td>
                                <td>
                                <?php echo form_dropdown('is_student', array('0' => 'Mặc định', '1' => 'Dành cho sinh viên'), $recruitment->is_student, array('class' => 'form-control')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Bắt buộc gửi Email</td>
                                <td>
                                <?php echo form_checkbox('mail_required', '1', $recruitment->mail_required, array('class' => 'minimal')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Bắt buộc gửi CV</td>
                                <td>
                                <?php echo form_checkbox('cv_required', '1', $recruitment->cv_required, array('class' => 'minimal')); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Nổi bật</td>
                                <td>
                                <?php echo form_checkbox('featured', '1', $recruitment->featured, array('class' => 'minimal')); ?>
                                </td>
                            </tr>

                            

                    

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-tag"></i>
                        Cấu hình SEO</h3>
                </div>
                <div class="box-body">

                    
                    <div class="form-group">
                        <label>Tiêu đề Seo:</label>
                        <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Tiêu đề Seo" value="<?php echo $recruitment->seo_title; ?>">
                    </div>
                    <div class="form-group">
                        <label>Từ khóa:</label>
                        <input type="text" class="form-control" id="seo_keyword" name="seo_keyword" placeholder="Từ khóa" value="<?php echo $recruitment->seo_keyword; ?>">
                    </div>
                    <div class="form-group">
                        <label>Mô tả SEO:</label>
                        <textarea class="form-control" row="4" id="seo_description" name="seo_description" placeholder="Mô tả SEO"><?php echo $recruitment->seo_description; ?></textarea>
                    </div>
                </div>
            </div> -->
        <div class="box box-solid"><button type="submit" id="submit" class="btn btn-primary btn-block" style="font-size:1.2em;">GỬI NGAY</button></div>

        <div class="progress progress-sm active" id="progress-xxs" style="display: none;">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                  <span class="sr-only">0%</span>
                </div>
              </div>
    </div>
</section>
</form>
<link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/froala_editor.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/froala_style.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/code_view.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/draggable.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/colors.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/emoticons.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/image_manager.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/image.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/line_breaker.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/table.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/char_counter.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/video.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/fullscreen.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/file.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/quick_insert.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/help.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/third_party/spell_checker.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/froalas/css/plugins/special_characters.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/froala_editor.min.js'); ?>" ></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/align.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/char_counter.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/code_beautifier.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/code_view.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/colors.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/draggable.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/emoticons.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/entities.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/file.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/font_size.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/font_family.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/fullscreen.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/image.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/froalas/js/plugins/image_manager.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/line_breaker.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/inline_style.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/link.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/lists.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/paragraph_format.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/paragraph_style.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/quick_insert.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/quote.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/table.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/save.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/url.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/video.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/help.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/print.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/third_party/spell_checker.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/special_characters.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/word_paste.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/autosize.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>
  <script>
  $('.datepicker').datepicker({autoclose: true, format: "dd/mm/yyyy"});
  //iCheck for checkbox and radio inputs
  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
  var already_mem = [];
var add_func = 'all';
  var list_tag = [];
    var list_send_user = [];
    var action = "user";
    var isrequest = false;

    function checkedAlls(source) {
        checkboxes = document.getElementsByClassName('selectID');
        for (var i = 0, n = checkboxes.length; i < n; i++)
            checkboxes[i].checked = source.checked;
    }
    $('#tag_new').keydown(function (e) {
        if (e.keyCode == 13) {
            $("#btn-add-tag").click();
            e.preventDefault();
            return false;
        }
    });
        $('.select2').select2();
        $(function() {
            autosize($('.autosize'));
    $('#position,#description,#benefit,#requirement').on('froalaEditor.initialized', function (e, editor) {

            $('#addPost').ajaxForm({
                beforeSubmit: function () {
                    $("#progress-xxs").show();
                    $("#progressbar").css('width', "0%");
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $('#progressBar').css('width', percentComplete + '%');
                },
                success: function (json) {
                    console.log(json);
                    $("#progress-xxs").hide();
                    $("#progressbar").css('width', "0%");
                    if (json.error) {
                        if(jQuery.type( json.message ) == "string"){
                            showErrorMessage(json.message);
                        }
                            $.each(json.message, function(key, value) {
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
                        showOkMessage(json.message);
                        setTimeout(function(){ window.location.reload(); }, 200);
                    }
                },
                error: function (json) {
                    console.log(json);
                    $("#progress-xxs").hide();
                    $("#progressbar").css('width', "0%");
                }
            });

        }).froalaEditor({
            toolbarButtons: ['undo', 'redo' , '|','removeFormat', 'bold', 'italic', 'underline','align', 'formatOL', 'formatUL', 'outdent', 'indent', 'clearFormatting', '|', 'insertLink','insertImage', 'insertTable', '|', 'html'],
      heightMin: 300,
      imageUploadURL: '<?php echo base_url('file/upload_image'); ?>',
      imageManagerLoadURL:'<?php echo base_url('file/list_image'); ?>'
    })
  });


      $(".btn-delete").click(function(){
        var id = $(this).attr("data-id");
        $("#tr-row-"+id).fadeOut(500,function(){
          $(this).remove();
        });
      });


      var change_now = false;
      $( "#new_tags" ).keyup(function() {
          $("#id_tags").val(0).trigger('change');
      });
      $( "#id_tags" ).change(function() {
          if( $("#id_tags").val() != "0"){
              $( "#new_tags" ).val("");
          }
      });
      var list_tag_value = [];
      function add_tag(){
        new_tag_id = new Date().getTime();
        new_tag_id = "new" + new_tag_id;
        new_tag_name = $( "#tag_new" ).val();
        if(list_tag.indexOf(new_tag_id) >= 0){
            showErrorMessage("Bạn đã thẻ này trước đó");
            return false;
        }
        list_tag.push(new_tag_id);
        list_tag_value.push(new_tag_name);
        $("#list-tags").append('<span style="margin: 1px;" class="btn btn-primary btn-xs" id="span-tags-'+new_tag_id+'">'+new_tag_name+' <i class="fa fa-times" onclick="remove_tags(\''+new_tag_id+'\')"></i></span>');
        $("#list_tag").val(list_tag_value.join(","));
        $( "#tag_new" ).val("");
      }
      function remove_tags(id){
            id = id.toString();
            var index = list_tag.indexOf(id);
            if(index >= 0){
                list_tag.splice(index, 1);
                list_tag_value.splice(index, 1);
                $('#span-tags-'+id).fadeOut(400, function(){
                    $('#span-tags-'+id).remove();
                });
            }
            $("#list-tags").val(list_tag_value.join(","));
      }


      $("#select-add-type").change(function(){

        if($("#select-add-type").val() == "user"){
          $("#show-add-user").show();
          $("#show-add-group").hide();
          action = "user";
        }else if($("#select-add-type").val() == "group"){
          $("#show-add-user").hide();
          $("#show-add-group").show();
          action = "group";
        }else{
            action = "all";
            $("#show-add-user").hide();
          $("#show-add-group").hide();
        }
      });
  </script>
<style>
.btn-delete{
  padding: 0px 5px !important;
  font-size: 11px !important;
  font-weight: normal !important;
  margin-left: 7px;
}
#list-users span{
    margin-right: 3px;
}
.select2-container .select2-search--inline .select2-search__field {
    margin-top:0;
}
</style>
