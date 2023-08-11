<section class="content-header">

   <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class=""><a href="<?php echo base_url('recruitment/album'); ?>">Album</a></li>
      <li class="active">Danh sách</li>
   </ol>
   <ul class="right-button">
			<li><a href="<?php echo base_url('recruitment/album/add'); ?>" id="add_button" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Thêm album</a></li>
		</ul>
</section>
<section class="content">
         <div class="box box-solid">
            <div class="box-body">
               <table id="album" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                       <th>#</th>
                        <th>Tên album</th>
                        <th>Tổng số hình</th>
                        <th>Ngày tạo</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </div>
   </div>
</section>


<script type="text/javascript">
    var table1;
	var dataArray = [];
    $("#sending").hide();
    $(function() {
        table1 = $('#album').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
            //dom: 'Bfrtip',

            ajax: {
                url : "<?php echo base_url('recruitment/album/get_items'); ?>",
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

                {data:"id"},
                {data: "name",
                    render: function(name, type, data) {
                        return '<a href="<?php echo base_url('recruitment/album/edit/'); ?>'+data.id+'" data-id="'+data.id+'" class="edit">'+name+'</a>';
                    }
                    
                },
                {data: "images",
                    render: function(images, type, data) {
                        var json = jQuery.parseJSON(images);
                        if(!json) return '';
                        return json.length;
                    }
                },
                {data: "created_at"},
                {data: "order"},
                {data: "status",
                render: function(status, type, data) {
                status = parseInt(status);
                if(status == 1 ){
                    return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-success" onclick="deActive('+data.id+')"><b>Kích hoạt</b></button>';
                }else {
                    return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-danger" onclick="Active('+data.id+')"><b>Đã đóng</b></button>';
                }

            }},
            {data: "action",
                render: function(id, type, data) {
                
                    return '<button data-toggle="tooltip" data-placement="bottom" data-original-title="Xóa album" id="butt_remove_' + data.id + '" onclick="remove(' + data.id + ')" type="button" data-id="' + data.id + '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';

                }
            }
            ],
        });

    })


    function remove(id) {
        if (!confirm('Bạn có chắc chắn muốn xoá dòng này này?')) return false;
        $("#butt_remove_" + id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url('recruitment/album/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            $("#butt_remove_" + id).html('<i class="fa fa-times"></i>');
            table1.ajax.reload();
        });

    }


    function Active(id){
        if (!confirm('Bạn có chắc chắn muốn kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/album/active"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-check" aria-hidden="true"></i>');
            table1.ajax.reload();
        });
    }
    function deActive(id){
        if (!confirm('Bạn có chắc chắn Bỏ kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/album/deactive"); ?>/"+id;
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