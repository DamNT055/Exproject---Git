<?php $detail->images = json_decode($detail->images); ?>
<div id="list-images">
    <div id="add-img-btn"><input type="file" id="files" multiple /></div>
    <?php if (isset($detail->images)) : ?>
        <div class="list-img" id="list-img">
            <div id="add-img">
                <?php for ($i = count($detail->images) - 1; $i >= 0; $i--) {
                    $newId = time() . $i; ?>
                    <div class="imageThumb" id="<?php echo $newId; ?>">
                        <i class="fa fa-times-circle click-to-del" attr-idimg="<?php echo $detail->images[$i]; ?>" attr-id="<?php echo $newId; ?>"></i>
                        <a href="<?php echo "https://tuyendung.mia.vn/uploads/album/" . $detail->images[$i] ?>" target="_blank">
                            <img src="<?php echo "https://tuyendung.mia.vn/uploads/album/" . $detail->images[$i] ?>" style="height: 150px;" />
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="clearfix"></div>
<style>
    #tab_status {
        width: 100%;
        overflow-x: auto;
        height: 177px;
    }

    #files {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        line-height: 150px;
        opacity: 0;
        z-index: 2;
        cursor: pointer;
    }

    #add-img-btn {
        float: left;
        width: 150px;
        height: 150px;
        position: relative;
        border: 2px dashed #3c8dbc;
        text-align: center;
        color: #3c8dbc;
        margin: 5px;
    }

    #add-img-btn:after {
        content: "\f067";
        font-family: FontAwesome;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        line-height: 150px;
        z-index: 1;
        font-size: 20px;
        font-weight: normal;
    }

    .list-img {
        float: left;
        overflow: auto;
        position: relative;
        max-width: calc(100vw - 740px);
        max-height: calc(100vh - 195px);
    }

    #add-img {
        float: left;
        width: auto;
        max-width: unset !important;
    }

    .imageThumb {
        float: left;
        height: auto;
        width: auto;
        height: 150px;
        max-width: 150px;
        margin: 5px;
        min-width: 70px;
        border: 2px dashed #3c8dbc;
        box-sizing: border-box;
        position: relative;
        background: white;
        overflow: hidden;
    }

    .click-to-del {
        position: absolute;
        top: 5px;
        left: 5px;
        cursor: pointer;
    }

    .click-to-del:before {
        display: block;
        background: rgba(255, 255, 255, 0.7);
        font-size: 30px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        text-align: center;
    }

    .sendingimg {
        width: 150px;
        height: 150px;
        line-height: 150px;
        text-align: center;
    }
</style>
<script>
    $(document).ready(function() {
        $(".imageThumb").each(function() {
            var width = $(this);
        });
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var newID = new Date().getTime();
                        $("#add-img").prepend('<div class="imageThumb" id="' + newID + '">' +
                            ' <input type="hidden" name="list_img[]" id="file_' + newID + '" />' +
                            '<i class="fa fa-times-circle click-to-del" style="display: none;" attr-id="' + newID + '"></i>' +
                            '<div id="sending_' + newID + '" class="sendingimg"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>' +
                            '</div>');
                        $.ajax({
                            url: "<?php echo base_url("recruitment/album/upload/" . $detail->id); ?>",
                            method: "POST",
                            data: {
                                file: e.target.result
                            }
                        }).done(function(msg) {

                            if (msg.error) {
                                showErrorMessage(msg.message);
                                $("#" + newID).remove();
                            } else {
                                $("#" + newID + " .click-to-del").show();
                                $("#" + newID + " .click-to-del").attr('attr-idimg', msg.message);
                                $("#sending_" + newID).remove();
                                $("#" + newID).append('<a href="https://tuyendung.mia.vn/uploads/album/' + msg.message + '" target="_blank"><img src="https://tuyendung.mia.vn/uploads/album/' + msg.message + '" style="height: 150px;" /></a>');
                            }
                        }).always(function(e) {
                            console.log(e);
                        });
                        $(".click-to-del").click(function() {
                            delete_image(this);
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        } else {
            alert("Chuyển sang Chrome để sử dụng chức năng này")
        }
    });
    $(".click-to-del").click(function() {
        delete_image(this);
    });

    function delete_image(element) {
        if (!confirm('Hành động này sẽ xoá vĩnh viễn hình ảnh. Bạn có Chắc chắn xoá?')) return false;
        var idDEL = $(element).attr("attr-id");
        var idIMG = $(element).attr("attr-idimg");
        $.ajax({
            url: "<?php echo base_url("recruitment/album/delete_img/" . $detail->id); ?>",
            method: "POST",
            data: {
                file: idIMG
            }
        }).done(function(msg) {

            if (msg.error) {
                showErrorMessage(msg.message);
            } else {
                $("#" + idDEL).fadeOut("slow", function() {
                    $("#" + idDEL).remove();
                });
            }
        }).always(function(e) {
            console.log(e);
        });
    }
</script>