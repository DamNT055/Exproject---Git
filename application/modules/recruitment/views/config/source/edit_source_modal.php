<form method="post" data-url="<?php echo base_url('recruitment/source/data_action'); ?>" id="source_form" class="ajax-form">
     <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Sửa nguồn ứng viên</h4>
          </div>
          <div class="modal-body">
               <div class="form-group">
               <label>Tên</label>
               <input type="text" name="name" id="name" class="form-control" value="<?php echo $source->name; ?>"/>
               </div>
      
          </div>
          <div class="modal-footer">
               <input type="hidden" name="source_id" id="source_id" value="<?php echo $source->id; ?>"/>
               <input type="submit" name="action" id="action" class="btn btn-success" value="Cập nhật" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
     </div>
</form>