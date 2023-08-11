<section class="content-header">

   <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class=""><a href="<?php echo base_url('recruitment/news'); ?>">Tin tức</a></li>
      <li class="active">Danh sách</li>
   </ol>
   <ul class="right-button">
			<li><a href="<?php echo base_url('recruitment/news/add'); ?>" id="add_button" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Thêm tin tức</a></li>
		</ul>
</section>
<section class="content">
         <div class="box box-solid">
            <div class="box-body">
               <table id="categories" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                       <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Người tạo</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th width="100px"></th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </div>
   </div>
</section>


<script type="text/javascript">
$('body').tooltip({selector: '[data-toggle="tooltip"]'});

    var table1;
	var dataArray = [];
    $("#sending").hide();
    $(function() {
        table1 = $('#categories').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
            //dom: 'Bfrtip',
        //     buttons: [

        //     {

        //         text: '<span class="glyphicon glyphicon-trash"></span> Xóa nhiều lựa chọn (<span class="count_selected">0</span>)',
        //         className: 'btn btn-danger bg-red-400 delete-bulk'

        //     },


        //   ],


            ajax: {
                url : "<?php echo base_url('recruitment/news/getItems'); ?>",
                type : 'POST'
            },

            order: [[ 0, "desc" ]],
            info: false,
            autoWidth: false,
            pageLength  : 30,
            lengthChange: false,
            columnDefs:[
                {
                     "targets":[2],
                     "orderable":false,
                },
                {
                     "targets":[4],
                     "orderable":false,
                },

           ],

            columns: [
            //    {
            //         "render": function (data, type, row, meta) {
            //         return '<input type="checkbox" class="data-check" value="' + row.id + '">';
            //         },
            //    },

                {data:"id"},
                {data: "name",
                    render: function(name, type, data) {
                        output = '<a target="_blank" href="<?php echo base_url('recruitment/news/edit/'); ?>'+data.id+'" >'+name+'</a>';
                        output += '<a data-toggle="tooltip" data-placement="bottom" title="" href="https://tuyendung.mia.vn/'+data.slug+'" target="_blank" style="margin-left: 4px;vertical-align: middle;" data-original-title="Xem trên website"><i class="fa fa-external-link"></i></a>';
                        return output;
                    }
                },
                {data:"created_by"},
                {data:"created_at"},
                {data: "status",
                render: function(status, type, data) {
                status = parseInt(status);

                if(status == 1 ){
                    return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-success" onclick="deActive('+data.id+')"><b>Kích hoạt</b></button>';
                }else {
                    return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-danger" onclick="Active('+data.id+')"><b>Đã đóng</b></button>';
                }

            }
            },
            {data: "action"}
            ],




        });

    })

  

    function remove(id) {
        if (!confirm('Bạn có chắc chắn muốn xoá dòng này này?')) return false;
        $("#butt_remove_" + id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url('recruitment/news/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            $("#butt_remove_" + id).html('<i class="fa fa-times"></i>');
            table1.ajax.reload();
        });
    }


    function Active(id){
        if (!confirm('Bạn có chắc chắn muốn kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/news/active"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-check" aria-hidden="true"></i>');
            table1.ajax.reload();
        });
    }
    function deActive(id){
        if (!confirm('Bạn có chắc chắn Bỏ kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/news/deactive"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-ban" aria-hidden="true"></i>');
            table1.ajax.reload();
        });
    }
</script>


 <style>
 .bg-red-400 {
      color:#fff;
 }
 </style>