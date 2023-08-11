

<table id="categories" class="table table-bordered table-striped">
    <thead>
        <tr>
        <th>#</th>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Tin tuyển dụng</th>
        <th>Số lượng ứng tuyển</th>
        <th>Trạng thái</th>
        <th></th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<script type="text/javascript">
    var table1;
	var dataArray = [];
    $("#sending").hide();
    $(function() {
        table1 = $('#categories').DataTable({
            ordering: !1,
            processing: true,
            serverSide: true,
            ajax: {
                url : "<?php echo base_url('recruitment/category/getItems'); ?>",
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
                {data: "name"},
                {data: "description"},
                {data: "job_count"},
                {data: "apply_count"},
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
            {data: "action"
            }
            ],




        });

    })

    //check all
          $("#check-all").click(function () {
                $(".data-check").prop('checked', $(this).prop('checked'));
                var list_id = [];
                $(".data-check:checked").each(function () {
                    list_id.push(this.value);
                });
                $('.count_selected').text(list_id.length);

            });

            $('body').on('change', '.data-check', function () {
                $count = $('.count_selected').text();
                if ($count == null) {
                    $count = 0;
                } else {
                    $count = $('.count_selected').text();
                }
                if ($(this).prop('checked')) {
                    $count++;
                } else {
                    $count--;
                }
                $('.count_selected').text($count);
            });

            $(document).on('click','.delete-bulk',function (e) {
                e.preventDefault();
                var list_id = [];
                $(".data-check:checked").each(function () {
                    list_id.push(this.value);
                });
                // var mydata = {
                //     ids : list_id,
                // }
                if (list_id.length > 0) {
                    swal({
                        title: 'Are you sure?',
                        text: 'Bạn có chắc muốn tiễn vong ' + list_id.length + ' lựa chọn này?',
                        type: 'warning',

                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Xóa nó đi!',
                        cancelButtonText: 'Thôi, méo xóa nữa!'
                    }).then(function () {
                            $.ajax({
                                type: "POST",
                                data: {
                                    ids : list_id
                                },
                                url: "<?php echo base_url('recruitment/category/deleteBulk'); ?>",

                            success: function (data) {
                                if (!data.error) {
                                    $('.count_selected').text('0');
                                    $("#check-all").attr('checked', false);
                                    table1.ajax.reload();  //just reload table
                                    showOkMessage(data.message);
                                }
                                else {
                                    alert(data.message);
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert('Error deleting data');
                            }
                        });
                    });

                }
            });


    function remove(id) {
        if(!confirm("Bạn có chắc muốn xóa dòng này")) return false;
        $.getJSON("<?php echo base_url('recruitment/category/delete/'); ?>" + id, function (data) {
            $("#sending").hide();
            table1.ajax.reload();
        })
    }


    function Active(id){
        if (!confirm('Bạn có chắc chắn muốn kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/category/active"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-check" aria-hidden="true"></i>');
            table1.ajax.reload();
        });
    }
    function deActive(id){
        if (!confirm('Bạn có chắc chắn Bỏ kích hoạt tin này?')) return false;
        $("#butt_deactive_"+id).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
        var url = "<?php echo base_url("recruitment/category/deactive"); ?>/"+id;
        $.getJSON( url, function( data ) {
            $("#butt_deactive_"+id).html('<i class="fa fa-ban" aria-hidden="true"></i>');
            table1.ajax.reload();
        });
    }
</script>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
      $('#add_button').click(function(){
            var url = "<?php echo base_url('/recruitment/category/create/'); ?>";
            $('#modallHeading').html('Danh mục');
            $.ajaxModal('#ajaxModal', url);
      })      
      $(document).on('click','#categories .update', function(){
           var category_id = $(this).attr("data-id");
           var url = "<?php echo base_url('/recruitment/category/edit/'); ?>"+ category_id;
            $('#modallHeading').html('Danh mục');
            $.ajaxModal('#ajaxModal', url);
      });
 });
 </script>