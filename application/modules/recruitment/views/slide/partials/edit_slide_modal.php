<form action="<?php echo base_url('recruitment/slide/update'); ?>" id="editSlide" method="post">
    
     <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Sửa hình ảnh</h4>
          </div>
          <div class="modal-body">
               <div class="form-group">
                    <label>Tiêu đề:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề" value="<?php echo $detail->name; ?>">
               </div>
               <div class="form-group">
                    <label>Mô tả:</label>
                    <textarea class="form-control" row="4" id="description" name="description" placeholder="Mô tả"><?php echo $detail->description; ?></textarea>
               </div>
               <div class="form-group">
                    <label>Liên kết (tùy chọn):</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="http://mia.vn" value="<?php echo $detail->url; ?>">
               </div>
               <div class="form-group">
                    <label>Target:</label>
                    <?php echo form_dropdown('target', array('_self' => 'Mở trong tab hiện tại', '_blank' => 'Mở trong thẻ mới'), $detail->target, array('class' => 'form-control')); ?>
               </div>
               <div class="row">
                    <div class="form-group col col-md-6">
                         <label>Thứ tự:</label>
                         <input type="number" class="form-control" id="order" name="order" placeholder="Thứ tự" value="<?php echo $detail->order; ?>">
                    </div>
                    <div class="form-group col col-md-6">
                         <label>Trạng thái:</label>
                         <?php echo form_dropdown('status', array('1' => 'Kích hoạt', '0' => 'Đóng'), $detail->status, array('class' => 'form-control')); ?>
                    </div>
               </div>
               <div class="form-group post-image">
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

          <div class="modal-footer">
               <input type="hidden" name="slide_id" id="slide_id" value="<?php echo $detail->id; ?>"/>
            
               <input type="submit" name="action" id="action" class="btn btn-primary" value="Cập nhật" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
     </div>

</form>

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
$("#image-upload").change(function() {readURL(this);});
$('#editSlide').ajaxForm({
     success: function (json) {
          console.log(json);
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
               showOkMessage('Cập nhật slide thành công');
               $('#ajaxModal').modal('hide');
               //setTimeout(function(){ location.reload(); }, 100);
          }
     },error: function (json) {
          console.log(json);
     }
});

</script>  
