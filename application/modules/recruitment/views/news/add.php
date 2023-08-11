<link href="<?php echo base_url("assets/css/multiple-select.css"); ?>" rel="stylesheet"/>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class=""><a href="<?php echo base_url('recruitment/news'); ?>">Danh sách tin tức</a></li>
        <li class="active">Thêm tin mới</li>
    </ol>

</section>
<form action="<?php echo base_url('recruitment/news/store'); ?>" id="addPost" method="post">
<section class="content">
    <div class='row'>

        <div class="col-md-9">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_info" data-toggle="tab"><span>Tổng quan</span></a></li>
                    <li><a href="#tab_seo" data-toggle="tab"><span>SEO</span></a></li>
                    </ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_info">

                    <div class="form-group">
                        <label>Tiêu đề:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề">
                    </div>
                    <div class="form-group" id="edit-slug-box">
                        <label>Slug:</label>

                        <div class="input-group">
                            <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Tên đường dẫn">
                                <span class="input-group-btn edit-slug-buttons">
                                    <button type="button" class="btn btn-primary btn-flat" id="change_slug">Sửa</button>
                                    <button type="button" class="save btn btn-success" id="btn-ok" style="display: none;">OK</button>
                                    <button type="button" class="cancel btn btn-danger" style="display: none;">Hủy bỏ</button>

                                </span>
                        </div>
                        <div data-url="<?php echo base_url('recruitment/news/create_slug'); ?>" id="slug_id" data-id=""></div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả:</label>
                        <textarea class="form-control" row="4" id="description" name="description" placeholder="Mô tả"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung:</label>
                        <textarea class="form-control" id="content" name="content" placeholder="Nội dung"></textarea>
                    </div>

                    </div>
                    <div class="tab-pane" id="tab_seo">
                        <div class="form-group">
                            <label>SEO title:</label>
                            <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Tiêu đề Seo">
                        </div>
                        <div class="form-group">
                            <label>Keywords:</label>
                            <input type="text" class="form-control" id="seo_keyword" name="seo_keyword" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>SEO description:</label>
                            <textarea class="form-control" row="4" id="seo_description" name="seo_description" placeholder="Mô tả"></textarea>
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
                                <td style="white-space: nowrap; vertical-align: middle;">Trạng thái</td>
                                <td>
                                    <select class="form-control" id="status" name="status">
                                    <option value="1">Kích hoat</option>
                                    <option value="0">Đóng</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Nổi bật</td>
                                    <td>
                                    <div class="form-group">
                                        <label>
                                            <input name="featured" value="1" type="checkbox" class="flat-red">
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>



            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-picture-o"></i>
                        Ảnh bài viết</h3>
                </div>
                <div class="box-body post-image" style="padding: 0px">
                    <div id="image-preview">
							<label for="image-upload" id="image-label">
								<p>Đổi</p>
								<img src="<?php echo base_url("assets"); ?>/img/default.jpg" id="img-review" class="thumbnail">
							</label>
							<input type="file" name="image" id="image-upload">
						</div>
                </div>
                <!-- /.box-body -->
            </div>



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
  <script type="text/javascript" src="<?php echo base_url('assets/froalas/js/plugins/image_manager.min.js'); ?>"></script>
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


  <script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img-review').attr('src', e.target.result);
        }
    reader.readAsDataURL(input.files[0]);
    }
}
$("#image-upload").change(function() {
    readURL(this);
});

  $('.datepicker').datepicker({autoclose: true, format: "dd/mm/yyyy"});
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
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
            $('#content').on('froalaEditor.initialized', function (e, editor) {
            
                $('#addPost').ajaxForm({
                beforeSubmit: function () {
                    $("#progress-xxs").show();
                    $("#progressbar").css('width', "0%");
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $('#progressBar').css('width', percentComplete + '%');
                },
                success: function (json) {
                    
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
                        console.log(json);
                        showOkMessage(json.message);
                        $('.form-group').removeClass('has-error').removeClass('has-success');
                        $('.text-danger').remove();
                        $('#addPost')[0].reset();
                        
                    }
                },
                error: function (json) {
                    $("#progress-xxs").hide();
                    $("#progressbar").css('width', "0%");
                }
            });



          }).froalaEditor({
      heightMin: 400,
      imageUploadURL: '<?php echo base_url('file/upload_image'); ?>'
    })
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
.post-image #image-preview {
    width:100%;
    min-height:220px;
    border-radius:0;
    border:none;

}
#img-review {
    border-radius:0;
}
</style>

