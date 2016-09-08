$(document).ready(function () {
    // add san pham tu product defaul size color soluong=1 vao shopping cart
    $("button.add-to-cart").on('click', function (e) {
        e.preventDefault();
        var url = $(this).parent().attr('action');
        var _token = $('meta[name="csrf-token"]').attr('content');
        var product_id = $(this).parent().find("input[name='product_id']").val();

        $.ajax({
            url: url,
            type: 'POST',
            cache: false,
            data: {"_token": _token, "product_id": product_id},
            success: function (data) {
                if (data == 'Oke') {
                    alert('Bạn đã thêm sản phẩm thành công');
                } else {
                    alert("Lỗi !! Vui lòng liên hệ với Admin");
                }
            }
        });
    });

    // check number parameter class number
    $(".number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // right - down icon category in pages product
    $('#menu-content li i').on('click', function(){
        $(this).toggleClass('glyphicon-chevron-right glyphicon-chevron-down');
    });

});

function xacnhanxoa(msg) {
    if (window.confirm(msg)) {
        return true;
    }
    return false;
}

//reload page parameter _url
function redirect(_url) {
    window.location = _url;
}

// add san pham pages detail vao shopping cart
function add_to_cart(nid)
{
    var soluong = $('#soluong').val();
    //var size = $('#size').val();
    var size_id = $('#size option:selected').val();
    var namesize = $('#size option:selected').text();
    if (size_id == null) {
        alert('Admin chua validator chon size');
        return false;
    }
    var color_id = $('#color option:selected').val();
    var namecolor = $('#color option:selected').text();

    if (color_id == null) {
        alert('Admin chua validator chon mau');
        return false;
    }
    if(soluong=='undefined') soluong = 1;
    soluong = parseInt(soluong);
    var checkmax = parseInt($('#soluong').attr('max'));
    if (soluong > checkmax) {
        alert("Màu " + namecolor + " size " + namesize + " chỉ còn tối đa còn " + checkmax + " sản phẩm");
        soluong = checkmax;
    }
    //var crsfToken = document.getElementsByName("_token")[0].value;
    var crsfToken = $('meta[name="csrf-token"]').attr('content');

    var dataString = "product_id=" + nid + "&soluong=" + soluong + "&size_id=" + size_id + "&color_id=" + color_id + "&_token=" + crsfToken;
    $.ajax({
        type: "POST",
        url: baseURL + "/cart",
        data: dataString,
        beforeSend: function () {
            $('.process_buy').addClass('loading');
        },
        success: function (response) {
            $('.process_buy').removeClass('loading');
            if (response == 'Oke') {
                alert('Bạn đã thêm sản phẩm thành công');
            } else if (response == 'none'){
                alert('Bạn đã chọn tối đa sản phẩm có màu ' + namecolor + ' size ' + namesize);
            } else {
                alert("Lỗi !! Vui lòng liên hệ với Admin");
            }
        }
    });
}

function ajaxeditcart (dataString) {
    if (!dataString) return false;

    $.ajax({
        type: "POST",
        url: baseURL+"/editcart",
        data: dataString,
        cache: false,
        beforeSend: function () {
            $('.process_buy').addClass('loading');
        },
        success: function(response)
        {
            $('.process_buy').removeClass('loading');
            //if (response['_key'] == 'fsp') {
                redirect(response['_url']);
            //}
        }
    });

}

function editcart(_qty, object, ischeck = false) {
    var crsfToken = $("meta[name='csrf-token']").attr("content");

    if (ischeck) {
        var _cart = $(object).find('option:selected').attr('name').split("|");
        var _dataString = "color_id=" + _cart[0] + "&size_id=" + _cart[1] + "&product_id=" + _cart[2] + "&option=" + _cart[3] +"&qty=" + _qty + "&_token=" + crsfToken;
        ajaxeditcart(_dataString);
        return false;
    }

    $(object).siblings('select').toggleClass('get-qty');
    //$(object).siblings('select').css({'width': '5.5em', 'position': 'absolute', 'z-index': '2'}).toggle();

    $(object).siblings('select').on({
        'change': function (e) {
            e.stopPropagation();
            var qty = this.value || _qty;
            $(this).siblings('#sl').text(qty);
            //$(this).hide();

            var cart = $(this).find('option').attr('name').split("|");
            var dataString = "color_id=" + cart[0] + "&size_id=" + cart[1] + "&product_id=" + cart[2] + "&option=" + cart[3] +"&qty=" + qty + "&_token=" + crsfToken;
            ajaxeditcart(dataString);
        },
        'click' : function (e) {
            e.stopPropagation();
            $(this).hide();
            return false;
        }
    });


    $('select').find('option').on({
        'mouseover': function () {
            $('.hover').removeClass('hover');
            $(this).addClass('hover');
        },
        'mouseleave': function () {
            $(this).removeClass('hover');
        }
    });

}

function getsoluong(id) {

    var color_id = $('#color option:selected').val();
    var size_id = $('#size option:selected').val();
    var crsfToken = $('meta[name="csrf-token"]').attr('content');
    var dataString = "size_id=" + size_id+ "&color_id=" + color_id + "&_token=" + crsfToken;
    var output ='';
    $.ajax({
        type: "POST",
        url: baseURL+"/color-size-soluong",
        data: dataString,
        cache: false,
        success: function(response)
        {
            if (response['soluong']) {
                $('li a.cart').attr('href','javascript:add_to_cart('+id+')');
                output = '<input type="number" class="input-text qty text number" pattern="\d*" maxlength="3" title="Qty" size="4" value="1" name="quantity" id="soluong" min="1" step="1" max="'+ response['soluong'] + '" />';
            }
            else {
                output = '<span class="hethang">Hết hàng</span>';
                $('li a.cart').removeAttr('href');
            }
            document.getElementById("setsoluong").innerHTML = output;
        }
    });
}

// get so luong cua product phu thuoc vao color + size
$(document).ready(function () {
    //var size_id = $('#size').val();
    //var color_id = $('#color').val();
    //var crsfToken = $('meta[name="csrf-token"]').attr('content');
    ////var crsfToken = $('#search > input[name="_token"]').val();
    //var dataString = "size_id=" + size_id+ "&color_id=" + color_id + "&_token=" + crsfToken;
    //var output ='<input type="number" class="input-text qty text number" pattern="\d*" maxlength="3" title="Qty" size="4" value="1" name="quantity" id="soluong" min="1" step="1"';
    //$.ajax({
    //    type: "POST",
    //    url: baseURL+"/color-size-soluong",
    //    data: dataString,
    //    cache: false,
    //    success: function(response)
    //    {
    //        if (response['soluong']) {
    //            output += 'max="'+ response['soluong'] + '" />';
    //        }
    //        else {
    //            output += 'max="9999" />';
    //        }
    //        document.getElementById("setsoluong").innerHTML = output;
    //    }
    //});



});

