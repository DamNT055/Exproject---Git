<section class="content-header">

   <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class=""><a href="<?php echo base_url('recruitment'); ?>">Danh sách tuyển dụng</a></li>
      <li class="active">Thống kê theo số lượng ứng tuyển</li>
   </ol>
   <div class="pull-right">
        <div class="input-group">
                  <button type="button" class="form-control" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Tháng này
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
              </div>
</section>
<section class="content">
         <div class="box">
            <div class="box-body">
               <table id="example8" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Công việc</th>
                        <th>Ngày đăng tuyển</th>
                        <th>Ngày kết thúc</th>
                        <th>Số lượng ứng tuyển</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </div>
   </div>
</section>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pro_name_title">Chi tiết</h4>
            </div>
            <div class="modal-body">
            <table id="detail_tb" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Ứng viên</th>
                        <th>Ngày ứng tuyển</th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
			</div>
            <div class="modal-footer text-right">
                <button type="button" id="click-to-close-position" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<script>
var table8, detail_tb;
var day_start, day_end;
$(function() {
    day_start = moment().startOf('month').format('D/M/YYYY');
        day_end = moment().endOf('month').format('D/M/YYYY');
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Tháng này'  : [moment().startOf('month'), moment().endOf('month')],
          'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().startOf('month'),
        endDate  : moment().endOf('month')
      },
      function (start, end) {
        day_start = start.format('D/M/YYYY');
        day_end = end.format('D/M/YYYY');
        $('#daterange-btn span').html(day_start + ' - ' + day_end);
        table8.ajax.url("<?php echo base_url('recruitment/report_list'); ?>?from=" + day_start + '&to=' + day_end).load();
      }
    )

    table8 = $('#example8').DataTable({
        pageLength  : 50,
        lengthChange: false,
        autoWidth: 0,
        ajax: "<?php echo base_url('recruitment/report_list'); ?>?from=" + day_start + '&to=' + day_end,
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "start_date"},
            {data: "end_date"},
            {data: "count"}
        ]
    });
    table8.search('<?php echo $branch; ?>').draw();

    detail_tb = $('#detail_tb').DataTable({
        paging: false,
        autoWidth: 0,
        searching: false,
        info: false,
        select: 0,
        ajax: "<?php echo base_url('recruitment/report_detail'); ?>",
        columns: [
            {data: "id"},
            {data: "candidate_name", render: function(candidate_name, type, data){
                return '<a href="<?php echo base_url('recruitment/apply/edit/'); ?>'+data.id+'" target="_blank">' + candidate_name + '</a>';
            }},
            {data: "created_at"},
        ]
    });
    $('#example8 tbody').on('click', 'tr', function () {
        var data = table8.row( this ).data();
        $("#pro_name_title").html(data.name);
        var URl = "<?php echo base_url('recruitment/report_detail'); ?>?from=" + day_start + '&to=' + day_end + "&job_id=" + data.id;
        detail_tb.ajax.url(URl).load();
        table8.search('<?php echo $branch; ?>').draw();
        $("#modal-default").modal("show");
    } );
})
</script>
<style>
</style>