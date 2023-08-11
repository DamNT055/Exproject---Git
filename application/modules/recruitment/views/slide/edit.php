<link href="<?php echo base_url("assets/css/multiple-select.css"); ?>" rel="stylesheet"/>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Sửa slide</li>
    </ol>

</section>
<form action="<?php echo base_url('recruitment/slide/update'); ?>" id="updateSlide" method="post">
<input type="hidden" name="slider_id" value="<?php echo $detail->slider_id; ?>">
<input type="hidden" name="id" value="<?php echo $detail->id; ?>">
<section class="content">
    <div class='row'>
        <div class="col-md-9">
               
               <div class="box box-solid slides-list" <?php if(empty($slides)) : ?>style="display:none"<?php endif;?> >
                         <div class="box-header with-border">
                              <h3 class="box-title"><i class="fa fa-photo" aria-hidden="true"></i> Danh sách slide</h3>
                         </div>
                         <div class="box-body">
                              <?php if(!empty($slides)) : ?>
                                   <?php foreach($slides  as $slide) : ?>
                                   <div class="slide-item imageThumb" id="<?php echo $slide->id; ?>">
                                        <i class="fa fa-times-circle click-to-del" attr-idimg="<?php echo $slide->image; ?>" attr-id="<?php echo $slide->id; ?>"></i>
                                        <a href="<?php echo base_url('recruitment/slide/edit/'); ?><?php echo $slide->id; ?>">
                                        <img src="<?php echo base_url("assets/uploads/slides/"); ?><?php echo $slide->image; ?>">
                                        </a>
                                   </div>
                                        
                                   <?php endforeach; ?>
                              <?php endif; ?>
                         </div>
                    </div>
              
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_info" data-toggle="tab"><span>Sửa slide</span></a></li>
                
                    </ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_info">

                    <div class="form-group">
                        <label>Tiêu đề:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề" value="<?php echo $detail->name; ?>">
                    </div>
                    <div class="form-group" style="display:none;">
                        <label>Mô tả:</label>
                        <textarea class="form-control" row="4" id="description" name="description" placeholder="Mô tả"><?php echo $detail->description; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Liên kết:</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="http://mia.vn" value="<?php echo $detail->url; ?>">
                    </div>

               
                    <div class="form-group">
                    
                         <div class="box-body post-image" style="padding: 0px">
                              <div id="image-preview">
                                   <label for="image-upload" id="image-label">
                                        <p>Đổi</p>
                                        <?php if($detail->image) : ?>
								    <img src="<?php echo base_url("assets/uploads/slides/"); ?><?php echo $detail->image; ?>" id="img-review" class="thumbnail">
                                        <?php else : ?>
                                             <img src="<?php echo base_url("assets"); ?>/img/default.jpg" id="img-review" class="thumbnail">
                                        <?php endif; ?>
                                   </label>
                                   <input type="file" name="image" id="image-upload">
                              </div>
                         </div>

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
                                <?php echo form_dropdown('status', array('1' => 'Kích hoạt', '0' => 'Đóng'), $detail->status, array('class' => 'form-control')); ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Target</td>
                                <td>
                                   <?php echo form_dropdown('target', array('_self' => 'Mở trong tab hiện tại', '_blank' => 'Mở trong thẻ mới'), $detail->target, array('class' => 'form-control')); ?>
                                </td>
                            </tr>

                            <tr>
                                <td style="white-space: nowrap; vertical-align: middle;">Thứ tự</td>
                                <td>
                                <input type="number" class="form-control" id="order" name="order" placeholder="Thứ tự" value="<?php echo $detail->order; ?>">
                                </td>
                            </tr>
          
                        </tbody>
                    </table>
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
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/froala_editor.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/froala_style.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/code_view.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/draggable.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/colors.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/emoticons.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/image_manager.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/image.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/line_breaker.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/table.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/char_counter.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/video.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/fullscreen.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/file.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/quick_insert.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/help.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/third_party/spell_checker.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/css"); ?>/plugins/special_characters.css">
    <script type="text/javascript" src="<?php echo base_url("assets/js/multiple-select.js"); ?>"></script>
    <script src="<?php echo base_url('assets/js/autosize.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>

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

     $('#updateSlide').ajaxForm({
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
                                element.closest('div.form-group').removeClass('has-error').addClass(value.length > 0  ? 'has-error' : 'has-success').find('.text-danger').remove();
                                element.closest('div.form-group').append(value);
                            });
                    } else {
                        $('.form-group').removeClass('has-error').removeClass('has-success');
                        $('.text-danger').remove();
                        $('.slides-list').show();
                        $("#" +<?php echo $detail->id; ?>).remove();                
                        slide = '<div class="slide-item imageThumb" id="'+json.message.id+'">';
                        slide += '<i class="fa fa-times-circle click-to-del" attr-idimg="'+json.message.image+'" attr-id="'+json.message.id+'"></i>';
                        slide += '<a href="<?php echo base_url('recruitment/slide/edit/'); ?>'+json.message.id+'">';
                        slide += '<img src="<?php echo base_url("assets/uploads/slides/"); ?>'+json.message.image+'">';
                        slide +='</a>';
                        slide +='</div>';
                        $('.slides-list .box-body').append(slide).hide().fadeIn(999);
                        showOkMessage('Cập nhật slide thành công');
                    }
                },
                error: function (json) {
                    console.log(json);
                    $("#progress-xxs").hide();
                    $("#progressbar").css('width', "0%");
                }
            });
          $('.slides-list').on('click','.click-to-del',function(){
               if (!confirm('Hành động này sẽ xoá vĩnh viễn hình ảnh. Bạn có Chắc chắn xoá?')) return false;
               var idDEL = $(this).attr("attr-id");
               var idIMG = $(this).attr("attr-idimg");
               $.ajax({
                    url: "<?php echo base_url('recruitment/slide/delete/'); ?>"+ idDEL,
                    method: "POST",
                    data: {file: idIMG}
               }).done(function(msg) {                  
                    if(msg.error){
                         showErrorMessage(msg.message);
                    }else{
                         $("#" + idDEL).fadeOut("slow", function(){$("#" + idDEL).remove();});
                    }
               }).always(function(e){console.log(e);});
          
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
.post-image #image-preview {
    width:100%;
    min-height:500px;
    border-radius:0;
    border:none;

}
#img-review {
    border-radius:0;
}
.slide-item {
     max-width:250px;
}
</style>

