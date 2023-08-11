

<table id="slider" class="table table-bordered table-striped">
    <thead>
        <tr>
        <th>#</th>
        <th>Tiêu đề</th>
        <th>Số lượng slide</th>
        <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<script type="text/javascript">
    var table_slider;
	var dataArray = [];
    $("#sending").hide();
    $(function() {
     table_slider = $('#slider').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
            ajax: {
                url : "<?php echo base_url('recruitment/slider/get_items'); ?>",
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
                {data: "slide_count"},
                {data: "action"}
            ],
        });

    });
    function createModal ($id) {
        var url = "<?php echo base_url('recruitment/slider/create_slider/'); ?>"+ $id;
        $('#modallHeading').html('Slider');
        $.ajaxModal('#ajaxModal', url);
    }
    function remove_slider(id) {
        if(!confirm("Bạn có chắc muốn xóa dòng này")) return false;
        var url = "<?php echo base_url('recruitment/slider/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            $("#sending").hide(); table_slider.ajax.reload();
        })
    }
</script>
