function saveLocalItem(formId) {
    var postform = $("#"+formId).serialize();
    var url = '/cabinet/shop/itemSave';
    $.post(url, postform,function (data) {
        alert(data);
    },'html');
}

function editItemImageDelete(id){
    var elem = $('#' + id);
    $(elem).remove();
}

function editItemImageRefresh(id){
    var img = $('#' + id + ' img');
    var url = $('#' + id + ' textarea').val();
    $(img).attr('src',url);
}

function editItemImageAdd(id){
    // get the last DIV which ID starts with ^= "klon"
    var div = $('#'+id+' .product:last');
    var lastId = parseInt($('#'+id+' .product:last input[type="hidden"]').val());
    var inputItemName = $('#'+id+' .product:last input[type="hidden"]').prop('name');
    var url = '/cabinet/shop/itemEditImagesAdd?inputItemName=' + inputItemName +'&lastId='+lastId;
    //($inputItemName,$existingCount
    $.get(url, function (data) {
        div.after(data);
    }, "html");
     /*
    <div class="product" id="editItem-image--1">
            <div style="text-align: right;">
                <a class="icon-remove" style="display:inline-block; cursor: pointer;" title="Удалить" href="#" onclick="editItemImageDelete('editItem-image--1'); return false;"></a>
                <a class="icon-refresh" style="display:inline-block; cursor: pointer;" title="Обновить" href="#" onclick="editItemImageRefresh('editItem-image--1'); return false;"></a>
            </div>
            <div class="editItem-product-image">
                    <img class="img-responsive" src="https://img.alicdn.com/bao/uploaded/i2/2186390118/TB19CKLXfL85uJjSZFyXXa93XXa_!!0-item_pic.jpg_240x240.jpg">
            </div>
            <input name="item[taobao][556540875114][item_imgs][item_img][-1][id]" value="-1" type="hidden">
            <div class="editItem-product-title">
                <input name="item[taobao][556540875114][item_imgs][item_img][-1][position]" value="-1" type="text">
            </div>
            <div class="editItem-product-title">
                <textarea name="item[taobao][556540875114][item_imgs][item_img][-1][url]">//img.alicdn.com/bao/uploaded/i2/2186390118/TB19CKLXfL85uJjSZFyXXa93XXa_!!0-item_pic.jpg</textarea>
            </div>
        </div>
    */
}