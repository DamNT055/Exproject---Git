<form action="<?php echo base_url('recruitment/popup/update'); ?>" id="editPopup" method="post">
    
     <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Sửa popup</h4>
          </div>
          <div class="modal-body">
               <div class="form-group">
                    <label>Tiêu đề:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề" value="<?php echo $detail->name; ?>">
               </div>
           
               <div class="form-group">
                    <label>Liên kết (tùy chọn):</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="http://mia.vn" value="<?php echo $detail->url; ?>">
               </div>
          
               <div class="form-group">
                    <label>Trạng thái:</label>
                    <?php echo form_dropdown('status', array('1' => 'Kích hoạt', '0' => 'Đóng'), $detail->status, array('class' => 'form-control')); ?>
               </div>

               <div class="form-group post-image">
                    <div id="image-preview">
                         <label for="image-upload" id="image-label">
                              <p>Đổi</p>
                              <?php if($detail->image) : ?>
                                   <img src="<?php echo base_url("assets/uploads/"); ?><?php echo $detail->image; ?>" id="img-review" class="thumbnail">
                              <?php else : ?>
                                   <img src="<?php echo base_url("assets"); ?>/img/default.jpg" id="img-review" class="thumbnail">
                              <?php endif; ?>
                         </label>
                         <input type="file" name="image" id="image-upload">
                    </div>
               </div>

          </div>

          <div class="modal-footer">
               <input type="hidden" name="popup_id" id="popup_id" value="<?php echo $detail->id; ?>"/>
            
               <input type="submit" name="action" id="action" class="btn btn-success" value="Cập nhật" />
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
     $("#image-upload").change(function() {
     readURL(this);
     });
     $('#editPopup').ajaxForm({
                beforeSubmit: function () {
                  
                },
       
                success: function (json) {
                    console.log(json);
                  
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
                        $('.form-group').removeClass('has-error')
									.removeClass('has-success');
                        $('.text-danger').remove();
                        $('.slides-list').show();
                
     
                        showOkMessage('Cập nhật popup thành công');
                        $('#ajaxModal').modal('hide');
                        table_popup.ajax.reload();

                    }
                },
                error: function (json) {
                    console.log(json);
                 
                }
            });

</script>  
