<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class=""><a href="<?php echo base_url('recruitment/apply'); ?>">Ứng tuyển</a></li>
        <li class="active">Danh sách</li>
    </ol>
    <ul class="right-button">
			<li><a data-toggle="modal" data-target="#modal-import" id="import_button" type="button" class="btn btn-block btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Import</a></li>
		</ul>
</section>
<section class="content" style="padding-bottom: 0px;margin-bottom: 0px;">
    <div class="box box-solid" style="padding-bottom: 0px;margin-bottom: 0px;">
        <div class="box-body">
            <div class="filter-item">
                <div class="input-group">
                    <button type="button" class="form-control" id="daterange-btn">
                    <span id="daterange-btn-detail" >
                    <?php
                        if(!$date_from || strlen($date_from) < 6 || !$date_to || strlen($date_to) < 6 || $date_to == '01/01/2017'){
                            echo 'Thời gian: Tất cả';
                        }else{
                            echo "$date_from - $date_to";
                        }
                        ?>
                    </span>
                    <i class="fa fa-caret-down"></i>
                    </button>
                </div>
            </div>
            <div class="filter-item">
                <div class="btn-group filter-dropdown">
                    <button type="button" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span data-title="status">Trạng thái</span> <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li class="box-select-filter" id="list-filter-status"  style="width: 250px; overflow-y: auto;padding: 5px 0px;">
                            <p><input id="filter_status1" class="filter-change check-all" data-name="filter_status" type="checkbox" name="filter_status[]" value="all" <?php echo (in_array('all', $filter_status) ? 'checked' : ''); ?>> <label for="filter_status1" style='font-weight: bold;' data-value="all">Tất cả</label></p>
                        <?php foreach ($status as $item) {?>
                            <p><input id="filter_status<?php echo $item->id; ?>" class="filter-change" type="checkbox" name="filter_status[]" value="<?php echo $item->id; ?>" <?php echo (in_array($item->id, $filter_status) || in_array('all', $filter_status) ? 'checked' : ''); ?>> <label for="filter_status<?php echo $item->id; ?>" id="label_status<?php echo $item->id; ?>" data-value="<?php echo $item->id; ?>"><?php echo $item->name; ?></label></p>
                        <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="filter-item">
                <div class="btn-group filter-dropdown">
                    <button type="button" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span data-title="source">Nguồn ứng tuyển</span> <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li class="box-select-filter" id="list-filter-source"  style="width: 250px; overflow-y: auto;padding: 5px 0px;">
                            <p><input id="filter_source1" class="filter-change check-all" data-name="filter_source" type="checkbox" name="filter_source[]" value="all" <?php echo (in_array('all', $filter_source) ? 'checked' : ''); ?>> <label for="filter_source1" style='font-weight: bold;' data-value="all">Tất cả</label></p>
                        <?php foreach ($source as $item) {?>
                            <p><input id="filter_source<?php echo $item->id; ?>" class="filter-change" type="checkbox" name="filter_source[]" value="<?php echo $item->id; ?>" <?php echo (in_array($item->id, $filter_source) || in_array('all', $filter_source) ? 'checked' : ''); ?>> <label for="filter_source<?php echo $item->id; ?>" id="label_source<?php echo $item->id; ?>" data-value="<?php echo $item->id; ?>"><?php echo $item->name; ?></label></p>
                        <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="filter-item">
                <div class="btn-group filter-dropdown">
                    <button type="button" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span data-title="gender">Giới tính</span> <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li class="box-select-filter" id="list-filter-gender"  style="width: 140px; overflow-y: auto;padding: 5px 0px;">
                            <p><input id="filter_gender1" class="filter-change check-all" data-name="filter_gender" type="checkbox" name="filter_gender[]" value="all" <?php echo (in_array('all', $filter_gender) ? 'checked' : ''); ?>> <label for="filter_gender1" style='font-weight: bold;' data-value="all">Tất cả</label></p>
                        <?php foreach ($gender as $item) {?>
                            <p><input id="filter_gender<?php echo $item->gender_id; ?>" class="filter-change" type="checkbox" name="filter_gender[]" value="<?php echo $item->gender_id; ?>" <?php echo (in_array($item->gender_id, $filter_gender) || in_array('all', $filter_gender) ? 'checked' : ''); ?>> <label for="filter_gender<?php echo $item->gender_id; ?>" id="label_gender<?php echo $item->gender_id; ?>" data-value="<?php echo $item->gender_id; ?>"><?php echo $item->gender_name; ?></label></p>
                        <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="filter-item">
                <div class="btn-group filter-dropdown">
                    <button type="button" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span data-title="job">Công việc</span> <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li class="box-select-filter" id="list-filter-job"  style="width: 300px; overflow-y: auto;padding: 5px 0px;">
                            <p><input id="filter_jobs1" class="filter-change check-all" data-name="filter_job" type="checkbox" name="filter_job[]" value="all" <?php echo (in_array('all', $filter_job) ? 'checked' : ''); ?>> <label for="filter_job1" style='font-weight: bold;' data-value="all">Tất cả</label></p>
                        <?php foreach ($jobs as $item) {?>
                            <p><input id="filter_job<?php echo $item->id; ?>" class="filter-change" type="checkbox" name="filter_job[]" value="<?php echo $item->id; ?>" <?php echo (in_array($item->id, $filter_job) || in_array('all', $filter_job) ? 'checked' : ''); ?>> <label for="filter_job<?php echo $item->id; ?>" id="label_job<?php echo $item->id; ?>" data-value="<?php echo $item->id; ?>"><?php echo $item->name; ?></label></p>
                        <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="filter-item" style="width: 220px;"><input type="text" class="form-control" id="search_text" value="<?php echo $search_text; ?>" autocomplete="off" placeholder="Tìm kiếm..."/></div>
            <div class="filter-item">
                <button type="button" onclick="reload_data()" class="btn btn-primary search-box btn-filter">Tìm kiếm <i id="loading-filter" class="fa fa-spinner fa-pulse fa-fw"></i></button>
            </div>
            <div class="clear clearfix"></div>
            <table id="tbApply" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Công việc</th>
                        <th>Ngày nộp đơn</th>
                        <th>Trạng thái</th>
                        <th width="300">Ghi chú</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import File</h4>
            </div>
            <form action="<?php echo base_url("recruitment/apply/import"); ?>" id="formUpload" method="post" enctype="multipart/form-data">
            <div class="modal-body" id="body-detail">
                    <div class="form-group">
                        <label for="file">Chọn File:</label>
                        <input type="file" id="file" name="file" />
                    </div>
                    
                <div class="progress progress-xs" id="progress-xs" style="display: none;">
                    <div class="progress-bar progress-bar-primary progress-bar-striped" id="progressBar" role="progressbar" aria-valuenow="00" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0% Complete (warning)</span>
                    </div>
                </div>
			</div>
            <div class="modal-footer">
                <i style="display: none;" id="loading" class="fa fa-spinner fa-pulse fa-fw"></i>
                <a href="<?php echo base_url("assets/uploads/apply/apply_test_import.xlsx"); ?>" class="btn btn-warning"><i class="fa fa-download"></i> Tải mẫu import</a>
                <button type="submit" class="btn btn-primary submit-call"><i class="fa fa-upload"></i> Import File</button>
                <button type="button" id="click-to-close" class="btn btn-default pull-left" data-dismiss="modal">Đóng</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
var tbApply = false;
var arrayData = [];
var date_from = '<?php echo $date_from; ?>';
var date_to = '<?php echo $date_to; ?>';

var filter_status = ['<?php echo implode("','", $filter_status); ?>'];
if(filter_status.indexOf('all') > -1) filter_status = ['all'];

var filter_source = ['<?php echo implode("','", $filter_source); ?>'];
if(filter_source.indexOf('all') > -1) filter_source = ['all'];

var filter_gender = ['<?php echo implode("','", $filter_gender); ?>'];
if(filter_gender.indexOf('all') > -1) filter_gender = ['all'];

var filter_job = ['<?php echo implode("','", $filter_job); ?>'];
if(filter_job.indexOf('all') > -1) filter_job = ['all'];

function reload_data(){
    config_data();
    $("#loading-filter").show();
    if(tbApply){
        tbApply.ajax.reload();
        return false;
    }
    tbApply= $('#tbApply').DataTable({
        select: false,
        ajax: {
            url: "<?php echo base_url('recruitment/apply/all'); ?>",
            dataType:"JSON",
            type: "POST",
            data: function (data) {
                data.date_from = date_from.split("/").reverse().join("-");
                data.date_to = date_to.split("/").reverse().join("-");
                data.s = $('#search_text').val();
                data.filter_source = filter_source.join(',');
                data.filter_status = filter_status.join(',');
                data.filter_gender = filter_gender.join(',');
                data.filter_job = filter_job.join(',');
                return data;
            },
         },
        info: true,
        ordering: false,
        autoWidth: true,
        scrollX: true,
        pageLength: 50,
        lengthChange: false,
        searching: false,
        scrollY: 'calc(100vh - 290px)',
        "processing": true,
        "serverSide": true,
        fixedColumns: {leftColumns: 2},
        columns: [
            {data: "id"}, 
            {data: "name",render: function (name, type, data) {
                return '<a target="_blank" href="<?php echo base_url('/recruitment/apply/edit/'); ?>'+data.id+'">'+name+'</a>';
            }},
            {data: "gender",render: function (gender, type, data) {
                return (gender == 1) ? 'Nam' : 'Nữ';
            }},
            {data: "birthday"},
            {data: "job"},
            {data: "created_at"},
            {data: "status_id",render: function (status_id, type, data) {
                arrayData[data.id] = data;
                return '<span class="label label-' + data.status_class + '">' + data.status_name + '</span>';
            }},
            {data: "last_log",render: function (last_log, type, data) {
                if(last_log != null && last_log.search('Ghi chú:') !== -1){
                    return last_log.substring(last_log.search('Ghi chú:') + 9);;
                }
                return '';
            }}
        ],
        "fnPreDrawCallback": function( oSettings ) {
            $("#loading-filter").hide();
        }
    });
}
function config_data(open_blank = false){
    filter_status = $("input[name='filter_status[]']:checked").map(function(){return $(this).val();}).get();
    if(filter_status.indexOf('all') > -1) filter_status = ['all'];
    
    filter_gender = $("input[name='filter_gender[]']:checked").map(function(){return $(this).val();}).get();
    if(filter_gender.indexOf('all') > -1) filter_gender = ['all'];
    
    filter_source = $("input[name='filter_source[]']:checked").map(function(){return $(this).val();}).get();
    if(filter_source.indexOf('all') > -1) filter_source = ['all'];
    
    filter_job = $("input[name='filter_job[]']:checked").map(function(){return $(this).val();}).get();
    if(filter_job.indexOf('all') > -1) filter_job = ['all'];

    var url =  '&search_text='+$('#search_text').val()+"&filter_status="+filter_status.join(',')+"&filter_gender="+filter_gender.join(',')+"&filter_source="+filter_source.join(',')+"&filter_job="+filter_job.join(',');
    if(open_blank){
        window.open("<?php echo base_url('recruitment/apply/export'); ?>"+"?date_from=" + date_from.split("/").reverse().join("-") + '&date_to=' + date_to.split("/").reverse().join("-")+ url, '_blank');
    }else{
        history.pushState(false, false, "<?php echo base_url('recruitment/apply'); ?>"+"?date_from=" + date_from + '&date_to=' + date_to + url);
    }
}
$("#search_text").keyup(function(e){
   e.preventDefault();
   if(e.keyCode == 13){
    reload_data();
    return false;
   }
});

$('#daterange-btn').daterangepicker(    {
      ranges   : {
      'Tất cả'       : [moment('2017-01-01'), moment()],
      'Hôm nay'       : [moment(), moment()],
      'Hôm qua'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      '7 ngày trước' : [moment().subtract(6, 'days'), moment()],
      'Tháng này'  : [moment().startOf('month'), moment().endOf('month')],
      'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: new Date(date_from),
      endDate  : new Date(date_to),
   },
   function (start, end) {
    date_from = start.format('DD/MM/YYYY');
    date_to = end.format('DD/MM/YYYY');
    $('#daterange-btn span').html(date_from + ' - ' + date_to);
    reload_data();
});
$(document).ready(function(){
    $(".check-all").click(function(){
        var input_name = $(this).data('name');
        console.log("input[name='"+input_name+"[]']");
        var is_checked = $(this).is(":checked");
        $("input[name='"+input_name+"[]']").each(function(){
            var has_class = $(this).hasClass('check-all');
            if(!has_class){
                $(this).prop('checked', is_checked);
            }
        });
    });
    $('input[type="checkbox"]').click(function(){
        var has_class = $(this).hasClass('check-all');
        if(!has_class){
            var input_name = $(this).attr('name');
            var is_checked = $("input[name='"+input_name+"'].check-all").is(":checked");
            if(is_checked){
                $("input[name='"+input_name+"'].check-all").prop('checked', false);
            }
        }
    });
    reload_data();
});
$('#formUpload').ajaxForm({
    beforeSubmit: function () {
        $("#progress-xs").show();
        $("#progressbar").css('width', "0%");
    },
    uploadProgress: function (event, position, total, percentComplete) {
        $('#progressBar').css('width', percentComplete + '%');
    },
    success: function (json) {
        document.getElementById("formUpload").reset();
        if (json.error) {
            showErrorMessage(json.message);
        } else {
            showOkMessage(json.message);
            table1.ajax.reload();
            $('#modal-default').modal('hide');
        }
    },
    error: function (json) {
        console.log(json);
        document.getElementById("formUpload").reset();
        $("#progress-xs").hide();
        $("#progressbar").css('width', "0%");
    }
});
</script>

<style>
th, td{white-space:nowrap;}
.filter-item{
   float: left;white-space:nowrap;
   margin-right: 5px;
   margin-bottom: 5px;
}
.datepicker{
    border-radius: 0px;
    text-align: center;
}
.box-select-filter{
   max-height: calc(100vh - 300px);
   white-space: initial;
}
.box-select-filter p{
   padding: 2px 15px;
   margin: 0px;
   position: relative;
}
.box-select-filter p label{
   position: relative;
   z-index: 1;
   font-weight: normal;
}
.box-select-filter p label:before{
   content: "";
   display: inline-block;
   margin-right: 5px;
   background: #fff;
   width: 13px; height: 13px;
   border-radius: 2px;
   margin-top: 4px;
   float: left;
   border: 1px solid #333;
}
.box-select-filter p input{
   position: absolute;
   display: block;
   top: 0px;
   left: 0px;
   width: 100%;
   height: 100%;
   z-index: 9;
   opacity: 0;
   cursor: pointer;
}
.box-select-filter p input:checked+label:before{
   background: #0075ff;
   border-color: #0075ff;
}
.box-select-filter p input:checked+label:after{
   content: " ";
   display: block;
   width: 4px; height: 9px;
   border: solid white;
   border-width: 0 2px 2px 0;
   -webkit-transform: rotate(45deg);
   -ms-transform: rotate(45deg);
   transform: rotate(45deg);
   position: absolute;
   left: 5px;
   top: 5px;
}
#loading-filter{display: none;}
</style>