<table id="popup" class="table table-bordered table-striped">
    <thead>
        <tr>
        <th>#</th>
        <th>Tiêu đề</th>
        <th>Trạng thái</th>
        <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>



<script type="text/javascript">
    var table_popup;
	var dataArray = [];
    $("#sending").hide();
    $(function() {
     table_popup = $('#popup').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
  
            ajax: {
                url : "<?php echo base_url('recruitment/popup/get_items'); ?>",
                type : 'POST'
            },

            order: [[ 0, "desc" ]],
            info: false,
            autoWidth: false,
            pageLength  : 30,
            lengthChange: false,
            columnDefs:[
                {
                     "targets":[3],
                     "orderable":false,
                },
            

           ],

            columns: [


            {data:"id"},
            {data: "name"},
            {data: "status",
                render: function(status, type, data) {
                status = parseInt(status);

                if(status == 1 ){
                    return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-success" onclick="deActive_popup('+data.id+')"><b>Kích hoạt</b></button>';
                }else {
                    return '<button style="border: none;" type="button" id="butt_deactive_'+data.id+'" class="label label-danger" onclick="Active_popup('+data.id+')"><b>Đã đóng</b></button>';
                }

            }},
            {data: "action"}
            ],




        });

    });



    function remove_popup(id) {
        if (!confirm('Bạn có chắc chắn muốn xoá dòng này này?')) return false;
        var url = "<?php echo base_url('recruitment/popup/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            table_popup.ajax.reload();
        });
  

    }

    function Active_popup(id){
        if (!confirm('Bạn có chắc chắn muốn kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/popup/active"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-check" aria-hidden="true"></i>');
            table_popup.ajax.reload();
        });
    }
    function deActive_popup(id){
        if (!confirm('Bạn có chắc chắn Bỏ kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/popup/deactive"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-ban" aria-hidden="true"></i>');
            table_popup.ajax.reload();
        });
    }


</script>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
      $('#add_popup').click(function(){
            var url = "<?php echo base_url("recruitment/popup/create"); ?>";
            $.ajaxModal('#ajaxModal', url);

      })

      
      $(document).on('click','#popup .update', function(e){
          e.preventDefault();
           var popup_id = $(this).attr("data-id");
           var url = "<?php echo base_url("recruitment/popup/edit/"); ?>"+ popup_id;
            $.ajaxModal('#ajaxModal', url);
      });
 });

</script>