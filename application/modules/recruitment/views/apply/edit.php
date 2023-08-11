<?php  $now = strtotime(date("d-m-Y", time())." 12:00 AM"); ?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="<?php echo base_url('recruitment/apply'); ?>">Ứng tuyển</a></li>
        <li class="active">Chi tiết Ứng viên</li>
    </ol>
    <ul class="right-button">
        <?php if(!empty($detail->cv)) : ?>
            <a target="_blank" href="https://tuyendung.mia.vn<?php echo $detail->cv; ?>" class="btn pull-right btn-primary cv">Xem CV của ứng viên</a>
        <?php endif; ?>
    </ul>
    <div class="clearfix"></div>
</section>
<section class="content">
<div class="row">
    <div class="col-md-4">
        <div class="box box-solid">
            <div class="box-body box-profile">
              <?php if($detail->gender == 1): ?>
               <img class="profile-user-img img-responsive img-circle gender_img" src="<?php echo base_url('/assets/img/avatar_1.png'); ?>" alt="User Avatar">
               <?php else : ?>
               <img class="profile-user-img img-responsive img-circle gender_img" src="<?php echo base_url('/assets/img/avatar_0.png'); ?>" alt="User Avatar">
               <?php endif; ?>


              <h3 class="profile-username text-center"><?php echo $detail->name; ?></h3>

              <ul class="list-group">
                    
                <li class="list-group-item">
                        <b>Số điện thoại: </b> <a href="tel:<?php echo $detail->phone; ?>" class="pull-right"><?php echo $detail->phone; ?></a>
                </li>
		
				<li class="list-group-item">
                         <b>Vị trí ứng tuyển: </b> <a class="pull-right" target="_blank" href="<?php echo base_url('recruitment/edit/'); ?><?php echo $detail->job_id; ?>" title="<?php echo $detail->job; ?>"><?php echo $detail->job; ?></a>
                    </li>
                    <li class="list-group-item"><b>Thời gian ứng tuyển:</b> <a class="pull-right"><?php echo date("d/m/Y", $detail->created_at); ?></a></li>
                    <li class="list-group-item" style="overflow:hidden"><b>Trạng thái: </b>
                         <span class="pull-right">
                         <select class="form-control" name="status" id="status">
                       
                         <?php foreach($status as $row){
                             if($userLogin->full_permission){
                                echo "<option value='$row->id' ".(($row->id == $detail->status_id)?"selected":"")." >$row->name</option>";
                             }elseif($row->order >= $current_status->order){
                                echo "<option value='$row->id' ".(($row->id == $detail->status_id)?"selected":"")." ".(($row->order < $current_status->order)?"disabled":"").">$row->name</option>";
                             }else{}
							}?>
                         </select>
                     
                         </span>
                    </li>
              </ul>
             


              <?php //if($detail->status_id == 2) : ?>
                    <!-- <a onclick="createSchedule(<?php echo $detail->id; ?>)" class="schedule-btn btn btn-block btn-primary btn-flat">Đặt lịch phỏng vấn</a> -->
               <?php //endif; ?>
          </div>
            <!-- /.box-body -->
          </div>
    </div>
    <div class="col-md-8">
    <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
               <li class="active"><a href="#candidate" data-toggle="tab">Thông tin</a></li>
               <?php if(!empty($schedule)) : ?>
               <li class=""><a href="#schedule" data-toggle="tab">Lịch phỏng vấn</a></li>
               <?php endif; ?>
               </ul>
               <div class="tab-content">
                    <div class="tab-pane active detail" id="candidate">
                        <input type="hidden" name="apply_id" value="<?php echo $detail->id; ?>"/>
                        <table style="margin-bottom: 0px !important;" class="table table-striped">
								<tbody>
									<tr>
										<th style="width:140px">Họ tên:</th>
										<td><?php echo $detail->name; ?></td>
									</tr>
									<tr>
										<th>Ngày sinh:</th>
										<td><?php echo $detail->birthday; ?></td>
									</tr>
									<tr>
										<th>Giới tính:</th>
										<td><?php echo $detail->gender == "1" ? "Nam" : "Nữ"; ?></td>
									</tr>
									<tr>
										<th>Email:</th>
										<td><?php echo $detail->email; ?></td>
									</tr>
									<tr>
										<th>Facebook:</th>
										<td><?php echo $detail->facebook; ?></td>
									</tr>
									<tr>
										<th>Địa điểm ứng tuyển:</th>
										<td><?php echo $detail->location; ?></td>
									</tr>
									<tr>
										<th>Nguồn ứng viên:</th>
										<td><?php echo $detail->source; ?>  <a href="#" data-toggle="modal" data-target="#modal-source"><i class="fa fa-pencil"></i></a></td>
									</tr>
								</tbody>
							</table>
                    </div>
                    
                    <?php if(!empty($schedule)) : ?>
                         <div class="tab-pane" id="schedule">
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
                         </div>
                         <?php endif; ?>
               </div>
               <!-- /.tab-content -->
          </div>
          <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
               <li class="active"><a href="#history" data-toggle="tab">Lịch sử</a></li>
               </ul>
               <div class="tab-content">
                    <div class="tab-pane active" id="history">
                    <ul class="timeline timeline-inverse" id="timeline"></ul></div>
                    </div>
               </div>
               <!-- /.tab-content -->
          </div>
    </div>
</div>
</section>

<div class="modal fade" id="modal-source" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
    <form action="#" id="edit-apply" method="post">
    <div class="modal-dialog" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="status-title">Cập nhật nguồn ứng viên</h4>
            </div>
            <div class="modal-body">
                <div class="form-group source">
						<label>Nguồn:</label>
						<select type="text" class="form-control" id="source_id" name="source_id" style="width: 100%;">            
                            	<?php foreach($sources as $row){
									echo "<option value='$row->id' ".(($row->id == $detail->source_id)?"selected":"").">$row->name</option>";
									
																
							}?>
                        </select>
					</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </form>
</div>

<div class="modal fade" id="modal-history">
    <form action="#" id="form_history" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="status-title">Cập nhật Ghi chú</h4>

                </div>
                <div class="modal-body">
                    <div class="form-group status" style="display:none">
						<label>Trạng thái:</label>
						<select type="text" class="form-control" id="status_id" name="status_id" style="width: 100%;">            
                            	<?php foreach($status as $row){
                                    if($userLogin->full_permission){
                                        echo "<option value='$row->id' ".(($row->id == $detail->status_id)?"selected":"").">$row->name</option>";
                                    }elseif($row->order >= $current_status->order){
                                        echo "<option value='$row->id' ".(($row->id == $detail->status_id)?"selected":"")." ".(($row->order < $current_status->order)?"disabled":"").">$row->name</option>";
                                    }else{}
							}?>
                        </select>
					</div>
					<div class="form-group">
						<label>Ghi chú:</label>
						<textarea type="text" rows="4" class="form-control" id="status_note" name="note"></textarea>
					</div>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
				<button type="submit" class="btn btn-primary pull-right">Cập nhật</button>
				<span style="display: none;float: right;line-height: 34px;" id="loading-status" ><i class="fa fa-spinner fa-pulse fa-fw"></i></span>
            </div>
            <div class="clearfix"></div>
            </div>
        </div>
        <!-- /.modal-content -->
		</form>
</div>

 

<div class="modal fade bs-modal-md in" id="scheduleDetailModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


<script>
     var isrequest = false;
     var selected_status;
$(document).ready(function(){
     get_timeline();
});
     // Schedule create modal view
     function createSchedule (id) {
     var url = "<?php echo base_url('recruitment/apply/createSchedule/'); ?>" + id;
     $('#modelHeading').html('Schedule');
     $.ajaxModal('#scheduleDetailModal', url);
     }

      function showinfo_status(id){
          
            $('input[name="apply_id"]').val(id);
            $('#status_id_'+<?php echo $detail->status_id; ?>).prop('checked', true);
            $("#modal-status-title").html("<?php echo $detail->name; ?>" + " - " + "<?php echo $detail->phone; ?>");

            for(i=1;i<=<?php echo count($status); ?>;i++){
                if(<?php echo $detail->status_id; ?> >= i){
                    $('#status_id_'+i).prop('disabled', true);
                }else{
                    $('#status_id_'+i).prop('disabled', false);
                }
            }
        }

        $('select#status').on('focus', function () {
        // Store the current value on focus and on change
            previous_status = this.value;
        }).change(function() {
            // Do something with the previous value after the change
            var selected = this.value;
            $('#status_id').val(selected);
            $('.form-group.status').show();
            $('#status-title').text('Cập nhật trạng thái');
            $('#modal-history').modal('show');

        });

 
        $('#modal-history').on('hidden.bs.modal', function () {
            $('#status-title').text('Cập nhật Ghi chú');
            $('.form-group.status').hide();
            $('#status').val(previous_status);
        });

    (function($) {
            'use strict';
            $.ajaxModal = function(selector, url, onLoad) {

            $(selector).removeData('bs.modal').modal({
                show: true
            });
            $(selector+' .modal-content').removeData('bs.modal').load(url);

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

function get_timeline(){
	$("#timeline").html('');
    $("#timeline").prepend('<li><i class="fa fa-clock-o bg-gray"></i></li>');
    $("#timeline").prepend('<li><i class="fa fa-check bg-gray"></i>\
    <div class="timeline-item"><span class="time"><i class="fa fa-clock-o"></i> <?php echo date("G:i:s, d/m/Y", $detail->created_at); ?></span>\
    <h4 class="timeline-header" style="font-size: 14px;"><strong><?php echo $detail->name; ?></strong></h4>\
    <div class="timeline-body">Đã gửi hồ sơ ứng tuyển lúc <?php echo date("G:i d/m/Y", $detail->created_at); ?></div>\
    </div>\
    </li>');
	$.getJSON("<?php echo base_url('recruitment/apply/history/' . $detail->id); ?>",function(json) {
		if(json.data.length < 1) return false;
		var class_state = "";
		var total_count_data = json.data.length;
		console.log(json.data);
		for(i=0;i<total_count_data;i++){
			data = json.data[i];
			if(i < total_count_data - 1) dataNext = json.data[i+1];
			else dataNext = false;
			var current_time = getTime(data.time);
			var timespan = getTimeFormat(data.time);
			var str = '';
			var color = 'yellow';
			class_state = data.state;
			if(data.state == "success") color = 'green';
			if(data.state == "danger") color = 'red';
			var icon = 'check';
			if(data.state == "success") icon = 'bookmark';
			if(data.state == "danger") icon = 'times';
			str += '<li>'
				+		'<i class="fa fa-'+icon+' bg-'+color+'"></i><div class="timeline-item"><span class="time"><i class="fa fa-clock-o"></i> '+timespan+ ", " + getTime(data.time) + '</span>'
				+		'<h4 class="timeline-header" style="font-size: 14px;"><a target="_blank" style="font-size: 14px;" href="<?php echo base_url("emp/detail/index/"); ?>'+data.employee_id+'">'+data.full_name+'</a></h4>'
				+		'<div class="timeline-body">'+data.content+'</div>'
				+		'</div>'
				+ '</li>';
			$("#timeline").prepend(str);
			if(!dataNext || getTime(dataNext.time) != getTime(data.time)){
				$("#timeline").prepend('<li class="time-label"><span class="bg-green">'+current_time+'</span></li>');
			}
		}
		
		<?php if ($detail->status_id > 1): ?>
			$("#timeline").prepend('<li style="height: 25px;"><i class="fa fa-plus bg-blue" data-toggle="modal" data-target="#modal-history" style="cursor: pointer;"></i></li>');
		<?php endif;?>
		
     });

}
function getTime(unix_timestamp){
	var date = new Date(unix_timestamp*1000);
	var ngay = date.getDate();
	if(ngay < 10) ngay = "0" + ngay;
	var thang = date.getMonth() + 1;
	if(thang < 10) thang = "0" + thang;
	return  ngay + "/" + thang + "/" + date.getFullYear();
}
function getTimeFormat(data) {
    var date = new Date(data * 1000);
	var phut = date.getMinutes();
	phut = phut < 10 ? ("0" + phut) : phut;
	var gio = date.getHours();
	gio = gio < 10 ? ("0" + gio) : gio;
	var giay = date.getSeconds();
	giay = giay < 10 ? ("0" + giay) : giay;
	return gio + ":" + phut + ":" + giay;
}

$("#form_history").on('submit',(function(e) {
	e.preventDefault();
   
	if($("#status_note").val().length < 2 && $('.form-group.status').css('display') == 'none'){
		showErrorMessage("Chưa có nội dung ghi chú");
		$("#status_note").addClass("error");
		$("#loading-status").hide();
		return false;
	}else{
		$("#status_note").removeClass("error");
	}
	isrequest = true;
	$("#loading-status").show();
	$.ajax({
		type : 'POST',
		url : "<?php echo base_url("recruitment/apply/change_log/" . $detail->id); ?>",
		data : $( this ).serialize(),
		dataType : 'json',
	}).done(function(json) {
		if(!json.error){
			showOkMessage(json.message);
			setTimeout(function(){ location.reload();}, 200);
		}else{
			showErrorMessage(json.message);
		}
	}) .always(function(json){
		console.log(json);
		isrequest = false;
		$("#loading-status").hide();
	});

}));
var isrequest = false;
$("#edit-apply").on('submit',(function(e) {
	e.preventDefault();

	if(!isrequest){
		isrequest = true;		
		$.ajax({
			type : 'POST',
			url : "<?php echo base_url("recruitment/apply/update/".$detail->id); ?>",
			data : $( this ).serialize(),
			dataType : 'json',
		}).done(function(json) {
	
            if(!json.error){                
				showOkMessage("Sửa Thành công");
                setTimeout(function(){ location.reload();}, 200);
            }else{
				showErrorMessage(json.message);
			}
		}) .always(function(json){
			console.log(json);
            isrequest = false;			
	
		});
	}
	return false;
}));
</script>