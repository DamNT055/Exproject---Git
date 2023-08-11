<form method="post" id="apply_form">      
<div class="modal-body">
<div class="box box-widget widget-user-2">
<!-- Add the bg color to the header using any of the bg-* classes -->
<div class="widget-user-header bg-yellow">
<div class="widget-user-image">
<?php if($candidate->gender == 1): ?>
    <img class="img-circle gender_img" src="<?php echo base_url('/assets/img/avatar_1.png'); ?>" alt="User Avatar">
<?php else : ?>
    <img class="img-circle gender_img" src="<?php echo base_url('/assets/img/avatar_0.png'); ?>" alt="User Avatar">
<?php endif; ?>
</div>
<!-- /.widget-user-image -->
<h3 class="widget-user-username" id="name"><?php echo $candidate->name; ?></h3>
<h5 class="widget-user-desc" id="email"><?php echo $candidate->email; ?></h5>
</div>
<div class="box-footer no-padding">
    <ul class="nav nav-stacked">
        <li><a style="overflow:hidden" href="#" data-id="0" class="status-title">Trạng thái 
        <span class="pull-right" id="status">
        <div class="btn-group">
                        <button type="button" class="btn btn-<?php echo $candidate->status_class; ?>"><?php echo $candidate->status_name; ?></button>
                            <button data-toggle="modal" data-target="#modal-status" onclick="showinfo_status(<?php echo $candidate->id; ?>)" type="button" class="btn btn-<?php echo $candidate->status_class; ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                        </div>
        </span></a></li>
        <li><a href="#">Giới tính <span class="pull-right" id="gender"><?php echo $candidate->gender == '1' ? "Nam" : "Nữ"; ?></span></a></li>
        <li><a href="tel:<?php echo $candidate->phone; ?>">Số điện thoại (Nhấn vào để gọi) <span class="pull-right" id="phone"><?php echo $candidate->phone; ?></span></a></li>
        <li><a href="#">Vị trí ứng tuyển <span class="pull-right" id="job"><?php echo $candidate->job; ?></span></a></li>
        <li><a href="#">Địa điểm <span class="pull-right" id="location"><?php echo $candidate->location; ?></span></a></li>
        <li><a>Thời gian <span class="pull-right" id="apply_at"><?php echo $candidate->created_at; ?></span></a></li>
    </ul>

    <a target="_blank" href="https://tuyendung.mia.vn<?php echo $candidate->cv; ?>" class="btn btn-block btn-danger cv">Xem CV</a>
    <div class="schedule-box">
        <?php if($candidate->status_id == 2) : ?>
            <a onclick="createSchedule(<?php echo $candidate->id; ?>)" class="schedule-btn btn btn-block btn-primary btn-flat">Đặt lịch phỏng vấn</a>
        <?php endif; ?>
        <?php if(!empty($schedule)) : ?>
        <div class="schedule-detail">
           
            <ul class="nav nav-stacked">
            <li>
                <a style="overflow:hidden" href="#" data-id="0" class="status-title">
                <b>Thời gian </b>
                <span class="pull-right"><?php echo $schedule->schedule_date; ?></span>
                </a>
            </li>
            <li>
                <a style="overflow:hidden" href="#" data-id="0" class="status-title">
                <b>Người phỏng vấn</b> 
                <span class="pull-right"><b>Đánh giá</b></span>
                </a>
            </li>

                    <?php if($schedule->employee) : ?>
                    
                    <?php foreach($schedule->employee as $emp) : ?>
 
                    <li><a style="overflow:hidden" href="#" data-id="0" class="status-title"><?php echo $emp->full_name; ?> 
                    <span class="pull-right"><label class="badge badge-warning">Waiting</label></span></a></li>
        
                    <?php endforeach; ?>
                    
                    <?php endif; ?>
                    </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
</div>
<div class="modal-footer">
    <input type="hidden" name="apply_id" id="apply_id" />
    
    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
</div>

</form>

<script>
    var apply_at = $('#apply_at').text();
    var date = new Date( apply_at  * 1000);
    var date_format =  date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();
    $('#apply_at').text(date_format);
</script>