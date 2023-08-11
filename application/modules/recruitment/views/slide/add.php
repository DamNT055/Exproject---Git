<link href="<?php echo base_url("assets/css/multiple-select.css"); ?>" rel="stylesheet"/>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Quản lý slide</li>
    </ol>
    <ul class="right-button">
        <li><button id="add_slide" class="btn btn-primary pull-left" style="font-size:12px;">
                    <i class="fa fa-plus"></i> Thêm Hình ảnh
            </button>
        </li>
       
    </ul>
</section>


<section class="content">
    <div class='row'>
        <div class="col-md-12">
               
               <div class="box box-solid slides-list" <?php if(empty($slides)) : ?>style="display:none"<?php endif;?> >
                         <div class="box-header with-border">
                              <h3 class="box-title"><i class="fa fa-photo" aria-hidden="true"></i> Danh sách slide</h3>
                         </div>
                         <div class="box-body">
                              <?php if(!empty($slides)) : ?>
                                   <?php foreach($slides  as $slide) : ?>
                                   <div class="slide-item imageThumb" id="slide-<?php echo $slide->id; ?>" data-id="<?php echo $slide->id; ?>">
                                        <i class="fa fa-times-circle click-to-del" attr-idimg="<?php echo $slide->image; ?>" attr-id="<?php echo $slide->id; ?>"></i>
                                        <img src="<?php echo base_url("assets/uploads/slides/"); ?><?php echo $slide->image; ?>">
                                   </div>
                                        
                                   <?php endforeach; ?>
                              <?php endif; ?>
                         </div>
                    </div>
        </div>
    </div>
</section>
<div class="modal fade bs-modal-md in" id="ajaxModal" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
    <div class="modal-dialog" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span></div>
            <div class="modal-body">Đang tải...</div>
        </div>
    </div>
</div>

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

          $('.slides-list').on('click','.click-to-del',function(e){
             e.preventDefault();

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
                         $("#slide-" + idDEL).fadeOut("slow", function(){$("#slide-" + idDEL).remove();});
                    }
                    return false;
               }).always(function(e){console.log(e);});
          
          });

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

  </script>
<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
      $('#add_slide').click(function(){
            var url = "<?php echo base_url("recruitment/slide/create?slider_id=$slider_id"); ?>";
            $.ajaxModal('#ajaxModal', url);

      })
      $('.slide-item img').click(function(e){
        e.preventDefault();
        var slide_id = $(this).parent().attr("data-id");
           if(slide_id){
            var url = "<?php echo base_url("recruitment/slide/edit/"); ?>" + slide_id;
            $.ajaxModal('#ajaxModal', url);
           }
      });
 });

</script>
<style>
.click-to-del:before {
    display: block;
    background: rgba(255,255,255,0.7);
    font-size: 30px;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    text-align: center;
}
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
    min-height:250px;
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

