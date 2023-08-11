<script type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>
<form method="post" id="slider_form" class="ajax-form">
                <div class="modal-content">
                     <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Sửa Slider</h4>
                     </div>
                     <div class="modal-body">
                          <div class="form-group">
                            <label>Tên</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $slider->name; ?>"/>
                          </div>
                          <div class="form-group" id="edit-slug-box">
                                <label>Slug:</label>

                                <div class="input-group">
                                    <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Tên đường dẫn" value="<?php echo $slider->slug; ?>">
                                        <span class="input-group-btn edit-slug-buttons">
                                            <button type="button" class="btn btn-info btn-flat" id="change_slug">Sửa!</button>
                                            <button type="button" class="save btn btn-success" id="btn-ok" style="display: none;">OK</button>
                                            <button type="button" class="cancel btn btn-danger" style="display: none;">Hủy bỏ</button>

                                        </span>
                                </div>
                                <div data-url="<?php echo base_url('recruitment/slider/create_slug'); ?>" id="slug_id" data-id=""></div>
                            </div>
                          <div class="form-group">
                            <label>Mô tả</label>
                            <textarea rows="4" name="description" id="description" class="form-control" ><?php echo $slider->description; ?></textarea>
                          </div>

                     </div>
                     <div class="modal-footer">
                          <input type="hidden" name="slider_id" id="slider_id" value="<?php echo $slider->id; ?>"/>
                          <input type="submit" name="action" id="action" class="btn btn-success" value="Cập nhật" />
                          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                     </div>
                </div>
           </form>

