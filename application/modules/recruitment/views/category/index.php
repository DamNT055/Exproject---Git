<section class="content-header">

   <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
      <li class=""><a href="<?php echo base_url('categories'); ?>">Danh mục</a></li>
      <li class="active">Danh sách</li>
   </ol>
   <ul class="right-button">
			<li><button id="add_button" data-toggle="modal" data-target="#dataModal" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Thêm danh mục</button></li>
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
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody></tbody>
               </table>
            </div>
   </div>
</section>

<div id="dataModal" class="modal fade">
      <div class="modal-dialog">
           <form method="post" id="category_form">
                <div class="modal-content">
                     <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Thêm danh mục</h4>
                     </div>
                     <div class="modal-body">
                          <div class="form-group">
                            <label>Tên</label>
                            <input type="text" name="name" id="name" class="form-control" />
                          </div>
                          <div class="form-group" id="edit-slug-box">
                                <label>Slug:</label>

                                <div class="input-group">
                                    <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Tên đường dẫn">
                                        <span class="input-group-btn edit-slug-buttons">
                                            <button type="button" class="btn btn-info btn-flat" id="change_slug">Sửa!</button>
                                            <button type="button" class="save btn btn-success" id="btn-ok" style="display: none;">OK</button>
                                            <button type="button" class="cancel btn btn-danger" style="display: none;">Hủy bỏ</button>

                                        </span>
                                </div>
                                <div data-url="<?php echo base_url('recruitment/category/create_slug'); ?>" id="slug_id" data-id=""></div>
                            </div>
                          <div class="form-group">
                            <label>Mô tả</label>
                            <textarea rows="4" name="description" id="description" class="form-control" /></textarea>
                          </div>
                          <div class="form-group">
                          <label>Trạng thái</label>
                          <select name="status" id="status" class="form-control">
                            <option value="1" selected>Kích hoạt</option>
                            <option value="0">Đóng</option>

                        </select>
                          </div>
                     </div>
                     <div class="modal-footer">
                          <input type="hidden" name="category_id" id="category_id" />
                          <input type="submit" name="action" id="action" class="btn btn-success" value="Thêm" />
                          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                     </div>
                </div>
           </form>
      </div>
 </div>
<script type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>
<script type="text/javascript">
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
            //    {
            //         "render": function (data, type, row, meta) {
            //         return '<input type="checkbox" class="data-check" value="' + row.id + '">';
            //         },
            //    },

                {data:"id"},
                {data: "name"},
                {data: "description"},
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
                else {

                    swal(
                      'Opp!',
                      'Chưa chọn gì sao xóa :v',
                      'info'
                    )

                }
            });


    function remove(id) {
        swal({
                title: 'Bạn có chắc không?',
                text: "Bạn có chắc muốn xóa dòng này!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
            }).then(function () {
                var url = "<?php echo base_url('recruitment/category/delete/'); ?>" + id;
                $.getJSON(url, function (data) {
                    $("#sending").hide();
                    table1.ajax.reload();
                })

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
           $('#category_form')[0].reset();
           $('.modal-title').text("Thêm danh mục");
           $('#action').val("Thêm");
           $('#category_id').val("");
           $('#slug_id').attr('data-id',"");

      })

      $(document).on('submit', '#category_form', function(event){
           event.preventDefault();
                $.ajax({
                     url:"<?php echo base_url('recruitment/category/dataAction'); ?>",
                     method:'POST',
                     data:new FormData(this),
                     contentType:false,
                     processData:false,
                     success:function(data)
                     {
                        if (data.error) {
                        if(jQuery.type( data.message ) == "string"){
                            showErrorMessage(json.message);
                        }
                            $.each(data.message, function(key, value) {
                                var element = $('#' + key);

                                element.closest('div.form-group')
                                .removeClass('has-error')
                                .addClass(value.length > 0  ? 'has-error' : 'has-success')
                                .find('.text-danger')
                                .remove();

                                element.closest('div.form-group').append(value);
                            });



                    } else {
                        $('.form-group').removeClass('has-error')
									.removeClass('has-success');
                        $('.text-danger').remove();
                        swal(
                                'Good Job!',
                                data.message,
                                'success'
                                )
                            $('#category_form')[0].reset();
                            $('#dataModal').modal('hide');
                            table1.ajax.reload();
                        }


                    }


                });

      });
      $(document).on('click','.update', function(){
           var category_id = $(this).attr("data-id");
           $.ajax({
                url:"<?php echo base_url('recruitment/category/fetchSingleData'); ?>",
                method:"POST",
                data:{category_id:category_id},
                dataType:"json",
                success:function(data)
                {
                     $('#dataModal').modal('show');
                     $('#name').val(data.name);
                     $('#slug').val(data.slug);
                     $('#description').val(data.description);
                     $('#status').val(data.status);
                     $('.modal-title').text("Sửa danh mục");
                     $('#category_id').val(category_id);
                     $('#slug_id').attr('data-id',category_id);
                     $('#action').val("Cập nhật");
                }
           })
      });
 });
 </script>

 <style>
 .bg-red-400 {
      color:#fff;
 }
 </style>