<section class="content-header">

   <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class=""><a href="<?php echo base_url('recruitment'); ?>">Tuyển dụng</a></li>
      <li class="active">Danh sách</li>
   </ol>
   <ul class="right-button">
			<li><a type="button" class="btn btn-block btn-primary" href="<?php echo base_url('recruitment/add'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> Thêm tin tuyển dụng</a></li>
		</ul>
</section>
<section class="content">
         <div class="box box-solid">
            <div class="box-body">
               <table id="recruitment" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>Thông tin</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </div>
   </div>
</section>

<script defer type="text/javascript" src="<?php echo base_url("assets/js/sweetalert2/sweetalert2.min.js"); ?>"></script>
<link defer rel="stylesheet" href="<?php echo base_url("assets/js/sweetalert2/sweetalert2.min.css"); ?>">
<script defer type="text/javascript">
function status_row(data){
    status = parseInt(data.status);    
    if(status == 1 ){
        return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-success" onclick="deActive('+data.id+')"><b>Kích hoạt</b></button>';
    }else {
        return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-danger" onclick="Active('+data.id+')"><b>Đã đóng</b></button>';
    }
}
function string_time_format(time){
    var d = new Date(time * 1000);
    var ngay = d.getDate();
    ngay = (ngay < 10) ? "0"+ngay:ngay;
    var thang = d.getMonth() + 1;
    thang = (thang < 10) ? "0"+thang:thang;
    return ngay + "/" + thang+ "/" + d.getFullYear();
}
$('body').tooltip({selector: '[data-toggle="tooltip"]'});
var table1;
var dataArray = [];
$("#sending").hide();
$(function() {
    table1 = $('#recruitment').DataTable({
        ajax: "<?php echo base_url('recruitment/all/'); ?>",
        ordering: false,
        info: false,
        autoWidth: false,
        pageLength  : 30,
        lengthChange: false,
        orderring: false,
        columns: [
            {data:'id',render: function(id, type, data) {
                var output = "";
                if(data.featured == 1 ){
                    output = '<span style="border: none;" type="button" class="label label-danger"><b>Hot</b></span> ';
                }else {
                    output += '';
                }
                output += '<a target="_blank" href="<?php echo base_url('recruitment/edit/'); ?>'+data.id+'" >'+data.name+'</a>';
                output += '<a data-toggle="tooltip" data-placement="bottom" title="" href="https://tuyendung.mia.vn/tuyen-dung/'+data.slug+'" target="_blank" style="margin-left: 4px;vertical-align: middle;" data-original-title="Xem trên website"><i class="fa fa-external-link"></i></a>';
                var status = status_row(data);
                var time_string = string_time_format(data.end_date);
                var total = parseInt(data.count);
                total= '<a data-toggle="tooltip" data-placement="bottom" title="" href="<?php echo base_url('recruitment/apply/?filter_job='); ?>'+data.id+'" target="_blank" style="margin-left: 4px;vertical-align: middle;" data-original-title="Xem danh sách ứng tuyển">'+total + '</a>';
                return `<p>${output}</p>
                <p>Địa điểm: <strong data-toggle="tooltip" data-placement="bottom" data-original-title="${data.address}">${data.location}</strong></p>
                <p>Danh mục: <b>${data.category_name}</b></p>
                <p>Ngày hết hạn: <b>${time_string}</b></p>
                <p>Trạng thái: ${status}</p>
                <p>Ứng tuyển: ${total}</p>`;
            }},

        ]
    });

})
$("#id_search").on('submit',(function(e) {
    e.preventDefault();
    var URLrequest = "<?php echo base_url('customer/search/'); ?>" + $("#id").val();
    $("#search").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Tìm kiếm');
    $("#search").prop('disable', true);
    table1.ajax.url(URLrequest).load();
    return false;
}));


function Active(id){
	if (!confirm('Bạn có chắc chắn muốn kích hoạt tin này?')) return false;
	$("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
	var url = "<?php echo base_url("recruitment/active"); ?>/"+id;
	$.getJSON( url, function( data ) {
		$("#butt_deactive_"+id).html('<i class="fa fa-check" aria-hidden="true"></i>');
	 	table1.ajax.reload();
	});
}
function deActive(id){
	if (!confirm('Bạn có chắc chắn Bỏ kích hoạt tin này?')) return false;
	$("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
	var url = "<?php echo base_url("recruitment/deactive"); ?>/"+id;
	$.getJSON( url, function( data ) {
		$("#butt_deactive_"+id).html('<i class="fa fa-ban" aria-hidden="true"></i>');
	 	table1.ajax.reload();
	});
}

function remove(id) {
        if (!confirm('Bạn có chắc chắn muốn xoá dòng này này?')) return false;
        $("#butt_remove_" + id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url('recruitment/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            $("#butt_remove_" + id).html('<i class="fa fa-times"></i>');
            table1.ajax.reload();
        });
    }
</script>