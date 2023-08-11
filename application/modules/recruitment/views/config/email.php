<table id="tableEmail" class="table table-bordered table-striped">

              <thead>
               <tr>
                    <th>#</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th></th>
               </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
<script>
var table_email;
$(function() {
        table_email = $('#tableEmail').DataTable({
            ordering: !1,
            // Processing indicator
            processing: true,
            // DataTables server-side processing mode
            serverSide: true,
            //dom: 'Bfrtip',
            ajax: {
                url : "<?php echo base_url('recruitment/email/get_items'); ?>",
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
                {data: "email"},
                {
                     data: "id",
                    render:function(id,type,data){
                              return '<button onclick="remove_email(' + data.id + ')" type="button" data-id="' + data.id + '" class="btn btn-danger btn-flat delete"><i class="fa fa-times" aria-hidden="true"></i></button>'
                    }
               
               },
            ],
        });

    })
</script>

<script type="text/javascript" language="javascript" >
$(document).on('submit', '#email_form', function(event){
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
                            table_email.ajax.reload();
                        }
                    }
                });
      });

 $(document).ready(function(){
      $('#add_email').click(function(){
            var url = "<?php echo base_url('/recruitment/email/create/'); ?>";
            $('#modallHeading').html('Email');
            $.ajaxModal('#ajaxModal', url);
      })      
      $(document).on('click','#tableEmail .edit', function(){
           var email_id = $(this).attr("data-id");
           var url = "<?php echo base_url('/recruitment/email/edit/'); ?>"+ email_id;
            $('#modallHeading').html('Email');
            $.ajaxModal('#ajaxModal', url);
      });
 });
 function remove_email(id) {
        if(!confirm("Bạn có chắc muốn xóa dòng này")) return false;
        var url = "<?php echo base_url('recruitment/email/delete/'); ?>" + id;
        $.getJSON(url, function (data) {
            $("#sending").hide(); table_email.ajax.reload();
        })
}
 </script>