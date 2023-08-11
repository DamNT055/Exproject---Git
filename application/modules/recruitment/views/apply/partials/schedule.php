
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" media="all" href="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'); ?>" />
<style>

</style>

<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><i class="icon-plus"></i> Lịch phỏng vấn</h4>
            </div>

<div class="modal-body">
    <form id="createSchedule" class="ajax-form" method="post">
        
        <div class="form-body">
            <div class="row">
                <div class="col-md-6  col-xs-12">
                    <div class="form-group">
                        <label class="d-block">Ứng viên</label>
                        <p><?php echo $candidate->name ?></p>
                        <input type="hidden" name="candidate" value="<?php echo $candidate->id; ?>">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        <label class="d-block">Người phỏng vấn</label>
                        <select class="select2 m-b-10 form-control select2-multiple " multiple="multiple"
                                data-placeholder="Choose Employee" data-placeholder="Employee" name="employee[]">
                                <?php foreach ($employees as $row) {?>
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->full_name; ?></option>
                                <?php }?>            
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 ">
                    <div class="form-group">
                        <label>Ngày hẹn</label>
                        <input type="text" name="schedule_date" id="schedule_date" placeholder="ngày/tháng/năm" value="" class="form-control">
                    </div>
                </div>

                <div class="col-xs-5 col-md-6">
                    <div class="form-group chooseCandidate bootstrap-timepicker timepicker">
                        <label>Giờ</label>
                        <input type="text" name="schedule_time" id="schedule_time" placeholder="Schedule Time" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success save-schedule">Submit</button>
</div>

<script src="https://momentjs.com/downloads/moment-with-locales.min.js" type="text/javascript"></script>

<script src="<?php echo base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js'); ?>" type="text/javascript"></script>

<script>
    // Select 2 init.
    $(".select2").select2({
        formatNoMatches: function () {
            return "messages.noRecordFound";
        }
    });
    // Datepicker set
    $('#schedule_date').bootstrapMaterialDatePicker
    ({
        time: false,
        clearButton: true,
        format: 'DD/MM/YYYY',
        lang : 'vi'
    });

    // Timepicker Set
    $('#schedule_time').bootstrapMaterialDatePicker
    ({
        date: false,
        shortTime: true,   // look it
        format: 'HH:mm',
        switchOnClick: true,
        lang : 'vi'
    });

    // Save Interview Schedule
    $('.save-schedule').click(function () {

        $.ajax({
                type : 'POST',
                url : "<?php echo base_url('recruitment/apply/storeSchedule'); ?>",
                data : $('#createSchedule').serialize(),
                dataType : 'json',
            }).done(function(json) {
                if (json.error) {
                        if(jQuery.type( json.message ) == "string"){
                            showErrorMessage(json.message);
                        }
                            $.each(json.message, function(key, value) {
                                var element = $('#' + key);

                                element.closest('div.form-group')
                                .removeClass('has-error')
                                .addClass(value.length > 0  ? 'has-error' : 'has-success')
                                .find('.text-danger')
                                .remove();

                                element.after(value);
                            });



                    } else {
                        $('.form-group').removeClass('has-error')
									.removeClass('has-success');
                        $('.text-danger').remove();
                       
                        showOkMessage(json.message);
                        $('#scheduleDetailModal').modal('hide');
                        setTimeout(function(){ 
                        
                            location.reload();
                        }, 200);
                    }
            }) .always(function(json) {
                console.log(json);
            });

    })
</script>
