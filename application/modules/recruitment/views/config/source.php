<table id="tableSource" class="table table-bordered table-striped">

              <thead>
               <tr>
                    <th width=50>#</th>
                    <th>Tên nguồn</th>
                    <th width=100></th>
               </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
<script>
var table_source;
$(function() {
     table_source = $('#tableSource').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
            //dom: 'Bfrtip',
            ajax: {
                url : "<?php echo base_url('recruitment/source/get_items'); ?>",
                type : 'POST'
            },

            order: [[ 0, "desc" ]],
            info: false,
            autoWidth: false,
            pageLength  : 10,
            lengthChange: false,
    

            columns: [
                {
                     data:"id"
               },
                {
                     data: "name",
                    render:function(name,type,data){
                              return '<a style="cursor:pointer;" data-id="' + data.id + '" class="edit">' + data.name + '</a>'
                    }
               
               },
               {
                    data: "id",
                    render:function(id,type,data){
                              if(id == 1){
                                   return "";
                              }
                              return '<button onclick="remove_source(' + data.id + ')" type="button" data-id="' + data.id + '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
                              
                    }
               
               },
            ],
        });

    })
</script>

<script type="text/javascript" language="javascript" >
$(document).on('submit', '#source_form', function(event){
           event.preventDefault();
           var url = $(this).data('url');
                $.ajax({
                     url:url,
                     method:'POST',
                     data:new FormData(this),
                     contentType:false,
                     processData:false,
                     dataType: "JSON",
                     success:function(data)
                     {
                        if (data.error) {
                         if(jQuery.type( data.message ) == "string"){
                              showErrorMessage(data.message);
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
                            $('.form-group').removeClass('has-error').removeClass('has-success');
                            $('.text-danger').remove();
                            showOkMessage(data.message);
                            //$('#category_form')[0].reset();
                            $('#ajaxModal').modal('hide');
                            table_source.ajax.reload();
                        }
                    }
                });
      });

 $(document).ready(function(){
      $('#add_source').click(function(){
            var url = "<?php echo base_url('/recruitment/source/create/'); ?>";
            $('#modallHeading').html('Nguồn ứng viên');
            $.ajaxModal('#ajaxModal', url);
      })      
      $(document).on('click','#tableSource .edit', function(){
           var source_id = $(this).attr("data-id");
           var url = "<?php echo base_url('/recruitment/source/edit/'); ?>"+ source_id;
            $('#modallHeading').html('Nguồn ứng viên');
            $.ajaxModal('#ajaxModal', url);
      });
 });
 function remove_source(id) {
        if(!confirm("Bạn có chắc muốn xóa dòng này")) return false;
        var url = "<?php echo base_url('recruitment/source/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            $("#sending").hide(); table_source.ajax.reload();
        })
}
 </script>