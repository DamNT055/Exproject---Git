<form method="post" data-url="<?php echo base_url('recruitment/email/data_action'); ?>" id="email_form" class="ajax-form">
     <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Edit Email</h4>
          </div>
          <div class="modal-body">
               <div class="form-group">
               <label>Tên</label>
               <input type="text" name="name" id="name" class="form-control" value="<?php echo $email->name; ?>"/>
               </div>
               <div class="form-group">
               <label>Email</label>
               <input type="email" name="email" id="email" class="form-control" value="<?php echo $email->email; ?>" />
               </div>
               
          </div>
          <div class="modal-footer">
               <input type="hidden" name="email_id" id="email_id" value="<?php echo $email->id; ?>"/>
               <input type="submit" name="action" id="action" class="btn btn-success" value="Cập nhật" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
     </div>
</form>



