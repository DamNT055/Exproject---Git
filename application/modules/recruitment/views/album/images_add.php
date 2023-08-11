<div id="list-images">
    <div id="add-img-btn"><input type="file" id="files" multiple /></div>
    <div id="add-img">
    </div>
</div>
<div class="clearfix"></div>
<style>
#tab_status{
    width: 100%; overflow-x: auto;  height: 177px;
}
    #files{
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        line-height: 150px;
        opacity: 0;
        z-index: 2;
        cursor: pointer;
    }
    #add-img-btn{
        float: left;
        width: 150px; height: 150px;
        position: relative;
        border: 2px dashed #3c8dbc;
        text-align: center;
        color: #3c8dbc;
        margin: 5px;
    }
    #add-img-btn:after{
        content: "\f067";
        font-family: FontAwesome;
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        line-height: 150px;
        z-index: 1;
        font-size: 20px;
    font-weight: normal;
    }
    #add-img{
        float: left;
        width:auto;
    }
    .imageThumb{
        float: left;
        height: auto;
        width: auto;
        max-height: 150px;
        max-width: 150px;
        margin: 5px;
        border: 2px dashed #3c8dbc;
        box-sizing: border-box;
        position: relative;
    }
    .click-to-del{
        position: absolute;
        left: 5px; right: 5px;
        cursor: pointer;
    }
    .click-to-del:before{
        display: block;
        background: rgba(255,255,255,0.7);
        font-size: 30px;
        border-radius: 50%;
        width: 30px; height: 30px;
        text-align: center;
    }
</style>
<script>
$(document).ready(function() {

    if(window.File && window.FileList && window.FileReader) {
        $("#files").on("change",function(e) {
        var files = e.target.files,
        filesLength = files.length;
        for (var i = 0; i < filesLength ; i++) {
            var f = files[i];
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
                var newID = new Date().getTime();
                var file = e.target;

                var image = new Image();
                image.height = 146;
                image.src = file.result;
                image.onload =  (function(e) {

                    var width = $("#list-images").width() + this.width;

                    $("#list-images").css("width", width);
                    var max = $("#tab_status").width;
                    if(width >= max){
                        $("#tab_status").css('overflow-x', 'scroll');
                    }else{
                        $("#tab_status").css('overflow-x', 'auto');
                    }
                });
                image.onclick =  (function(e) {
                    var image2 = new Image();
                    image2.src = file.result;
                    var w = window.open("");
                    w.document.write(image2.outerHTML);
                });
                $("#add-img").prepend('<div class="imageThumb" id="'+newID+'"><input type="hidden" name="list_img[]" value="'+file.result+'" /><i class="fa fa-times-circle click-to-del" attr-id="'+newID+'"></i></div>');
                $("#" + newID).ready(function(){
                    document.getElementById(newID).appendChild(image);
                });
                
             });
        fileReader.readAsDataURL(f);
  }
});
    } else { alert("Chuyển sang Chrome để sử dụng chức năng này") }

    $("body").on('click','.click-to-del',function(){
        if (!confirm('Chắc chắn xoá?')) return false;
        var idDEL = $(this).attr("attr-id");
        $("#" + idDEL).fadeOut("slow", function(){
            $("#" + idDEL).remove();
        });
    });
});
</script>
