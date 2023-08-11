<script type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>
<form method="post" data-url="<?php echo base_url('recruitment/category/dataAction'); ?>" id="category_form" class="ajax-form">
     <div class="modal-content">
          <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Thêm danh mục</h4>
          </div>
          <div class="modal-body">
               <div class="form-group">
               <label>Tên</label>
               <input type="text" name="name" id="name" class="form-control" value="<?php echo $category->name; ?>"/>
               </div>
               <div class="form-group" id="edit-slug-box">
                    <label>Slug:</label>

                    <div class="input-group">
                         <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Tên đường dẫn" value="<?php echo $category->slug; ?>">
                         <span class="input-group-btn edit-slug-buttons">
                              <button type="button" class="btn btn-primary btn-flat" id="change_slug">Sửa</button>
                              <button type="button" class="save btn btn-success" id="btn-ok" style="display: none;">OK</button>
                              <button type="button" class="cancel btn btn-danger" style="display: none;">Hủy bỏ</button>

                         </span>
                    </div>
                    <div data-url="<?php echo base_url('recruitment/category/create_slug'); ?>" id="slug_id" data-id=""></div>
               </div>
               <div class="form-group">
               <label>Mô tả</label>
               <textarea rows="4" name="description" id="description" class="form-control" ><?php echo $category->description; ?></textarea>
               </div>
               <div class="form-group">
               <label>Trạng thái</label>
     
               <?php echo form_dropdown('status', array('1' => 'Kích hoạt', '0' => 'Đóng'), $category->status, array('class' => 'form-control')); ?>
               </div>
               <div class="form-group">
                    <label>Thứ tự</label>
                    <input type="number" name="order" id="order" class="form-control" value="<?php echo $category->order; ?>"/>
               </div>
          </div>
          <div class="modal-footer">
               <input type="hidden" name="category_id" id="category_id" value="<?php echo $category->id; ?>" />
               <input type="submit" name="action" id="action" class="btn btn-success" value="Cập nhật" />
               <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
     </div>
</form>
 
 