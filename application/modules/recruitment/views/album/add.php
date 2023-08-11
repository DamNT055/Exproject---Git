<link href="<?php echo base_url("assets/css/multiple-select.css"); ?>" rel="stylesheet" />
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class=""><a href="<?php echo base_url('recruitment/album'); ?>">Danh sách album</a></li>
        <li class="active">Thêm album</li>
    </ol>

</section>
<form action="<?php echo base_url('recruitment/album/store'); ?>" id="addPost" method="post">
    <section class="content">
        <div class='row'>

            <div class="col-md-9">

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_info" data-toggle="tab"><span>Tổng quan</span></a></li>
                        <li><a href="#tab_seo" data-toggle="tab"><span>SEO</span></a></li>
                        <li><a href="#tab_images" data-toggle="tab"><span>Hình ảnh</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_info">

                            <div class="form-group">
                                <label>Tiêu đề:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề">
                            </div>
                            <div class="form-group" id="edit-slug-box">
                                <label>Slug:</label>

                                <div class="input-group">
                                    <input readonly type="text" class="form-control" id="slug" name="slug" placeholder="Tên đường dẫn">
                                    <span class="input-group-btn edit-slug-buttons">
                                        <button type="button" class="btn btn-primary btn-flat" id="change_slug">Sửa</button>
                                        <button type="button" class="save btn btn-success" id="btn-ok" style="display: none;">OK</button>
                                        <button type="button" class="cancel btn btn-danger" style="display: none;">Hủy bỏ</button>

                                    </span>
                                </div>
                                <div data-url="<?php echo base_url('recruitment/album/create_slug'); ?>" id="slug_id" data-id=""></div>
                            </div>

                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea class="form-control" rows="8" id="description" name="description" placeholder="Mô tả"></textarea>
                            </div>


                        </div>
                        <div class="tab-pane" id="tab_seo">
                            <div class="form-group">
                                <label>SEO title:</label>
                                <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Tiêu đề Seo">
                            </div>
                            <div class="form-group">
                                <label>Keywords:</label>
                                <input type="text" class="form-control" id="seo_keyword" name="seo_keyword" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>SEO description:</label>
                                <textarea class="form-control" rows="8" id="seo_description" name="seo_description" placeholder="Mô tả"></textarea>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_images">
                            <?php include "images_add.php"; ?>
                        </div>

                    </div>
                </div>
            </div>



            <div class='col-md-3'>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-cog"></i>
                            Cấu hình
                        </h3>
                    </div>
                    <div class="box-body" style="padding: 0px">
                        <table class="table no-border no-padding">
                            <tbody>

                                <tr>
                                    <td style="white-space: nowrap; vertical-align: middle;">Trạng thái</td>
                                    <td>
                                        <select class="form-control" id="status" name="status">
                                            <option value="1">Kích hoat</option>
                                            <option value="0">Đóng</option>
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-picture-o"></i>
                            Ảnh bài viết
                        </h3>
                    </div>
                    <div class="box-body post-image" style="padding: 0px">
                        <div id="image-preview">
                            <label for="image-upload" id="image-label">
                                <p>Đổi</p>
                                <img src="<?php echo base_url("assets"); ?>/img/default.jpg" id="img-review" class="thumbnail">
                            </label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>


                <div class="box box-solid"><button type="submit" id="submit" class="btn btn-primary btn-block" style="font-size:1.2em;">GỬI NGAY</button></div>

                <div class="progress progress-sm active" id="progress-xxs" style="display: none;">
                    <div class="progress-bar progress-bar-success progress-bar-striped" id="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0%</span>
                    </div>
                </div>
            </div>
    </section>
</form>
<script type="text/javascript" src="<?php echo base_url("assets/js/slug.js"); ?>"></script>

<script>
    $("#image-upload").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-review').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }

    });
    $('.datepicker').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy"
    });
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
    var already_mem = [];
    var add_func = 'all';
    var list_tag = [];
    var list_send_user = [];
    var action = "user";
    var isrequest = false;

    function checkedAlls(source) {
        checkboxes = document.getElementsByClassName('selectID');
        for (var i = 0, n = checkboxes.length; i < n; i++)
            checkboxes[i].checked = source.checked;
    }
    $('#tag_new').keydown(function(e) {
        if (e.keyCode == 13) {
            $("#btn-add-tag").click();
            e.preventDefault();
            return false;
        }
    });
    $('.select2').select2();
    $(function() {
        $('#addPost').ajaxForm({
            beforeSubmit: function() {
                $("button[type=submit]").attr("disabled", true);
                $("#progress-xxs").show();
                $("#progressbar").css('width', "0%");
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#progressBar').css('width', percentComplete + '%');
            },
            success: function(json) {
                console.log(json);
                $("#progress-xxs").hide();
                $("#progressbar").css('width', "0%");
                $("button[type=submit]").attr("disabled", false);
                if (json.error) {
                    if (jQuery.type(json.message) == "string") {
                        showErrorMessage(json.message);
                    }
                    $.each(json.message, function(key, value) {
                        var element = $('#' + key);

                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.text-danger')
                            .remove();

                        element.closest('div.form-group').append(value);
                    });



                } else {
                    $('.form-group').removeClass('has-error')
                        .removeClass('has-success');
                    $('.text-danger').remove();
                    $('#addPost')[0].reset();
                    showOkMessage('Thêm thành công');
                    setTimeout(function() {
                        window.location.href = '<?php echo base_url('recruitment/album/edit/'); ?>' + json.message;
                    }, 200);
                }
            },
            error: function(json) {
                console.log(json);
                $("#progress-xxs").hide();
                $("#progressbar").css('width', "0%");
                $("button[type=submit]").attr("disabled", false);
            }
        });
    })




    var change_now = false;
    $("#new_tags").keyup(function() {
        $("#id_tags").val(0).trigger('change');
    });
    $("#id_tags").change(function() {
        if ($("#id_tags").val() != "0") {
            $("#new_tags").val("");
        }
    });
    var list_tag_value = [];

    function add_tag() {
        new_tag_id = new Date().getTime();
        new_tag_id = "new" + new_tag_id;
        new_tag_name = $("#tag_new").val();
        if (list_tag.indexOf(new_tag_id) >= 0) {
            showErrorMessage("Bạn đã thẻ này trước đó");
            return false;
        }
        list_tag.push(new_tag_id);
        list_tag_value.push(new_tag_name);
        $("#list-tags").append('<span style="margin: 1px;" class="btn btn-primary btn-xs" id="span-tags-' + new_tag_id + '">' + new_tag_name + ' <i class="fa fa-times" onclick="remove_tags(\'' + new_tag_id + '\')"></i></span>');
        $("#list_tag").val(list_tag_value.join(","));
        $("#tag_new").val("");
    }

    function remove_tags(id) {
        id = id.toString();
        var index = list_tag.indexOf(id);
        if (index >= 0) {
            list_tag.splice(index, 1);
            list_tag_value.splice(index, 1);
            $('#span-tags-' + id).fadeOut(400, function() {
                $('#span-tags-' + id).remove();
            });
        }
        $("#list-tags").val(list_tag_value.join(","));
    }
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
</script>
<style>
    .btn-delete {
        padding: 0px 5px !important;
        font-size: 11px !important;
        font-weight: normal !important;
        margin-left: 7px;
    }

    #list-users span {
        margin-right: 3px;
    }

    .post-image #image-preview {
        width: 100%;
        min-height: 220px;
        border-radius: 0;
        border: none;

    }

    #img-review {
        border-radius: 0;
    }
</style>