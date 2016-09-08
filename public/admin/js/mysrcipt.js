$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});
/* thông báo 3s*/
$("div.alert, span.help-block").delay(3000).slideUp();

function xacnhanxoa(msg) {
    if (window.confirm(msg)) {
        return true;
    }
    return false;
}

function check_uncheck_all(name)
{
    var e;
    var main_el = document.getElementsByName('master_box')[0];
    var frm     = document.getElementsByName(name);
    var checked = main_el.checked;

    for (var i = 0; i < frm.length; i++)
    {
        e = frm[i];
        if (e.type == 'checkbox') e.checked = checked;
    }
}

function xoahinhanh(idHinh, smg) {
    var cnf = confirm(smg);
    if (cnf) {
        var url = baseURL + '/admin/product/delimg/';
        var _token = $("form[name='frmEditProduct']").find("input[name='_token']").val();
        //var idHinh = $(this).parent().find("img").attr("idhinh");
        var img = $(this).parent().find("img").attr("src");
        //var rid = $(this).parent().find("img").attr("idhinh");
        $.ajax({
            url: url + idHinh,
            type: 'GET',
            cache: false,
            data: {"_token": _token, "idHinh": idHinh, "urlHinh": img},
            success: function (data) {
                if (data == 'Oke') {
                    //$("div#hinh-"+rid).remove();
                    $("td#hinh-" + idHinh).remove();
                }
                else {
                    "Lỗi !! Vui lòng liên hệ với Admin"
                }
            }
        });
    } else {
        return null;
    }
}

//  click nao dau -> cong vc gi -> them vao dau
$(document).ready(function () {
    $("button#addImages").click(function () {
        $("div#insertImg").append('<div class="form-group abc"><input type="file" name="fProductDetail[]" multiple><a href="#" class="remove-file" border="2"><i class="pull-right glyphicon glyphicon-remove"></i></a></div>');
    });

    $('.add-remove').on('click', '.remove-file', function(e) {
        e.preventDefault();

        $(this).parent().remove();
    });

    $("button#sizecolor").click(function () {
        $("div#insSizeColor").append('<div class="form-inline">' +
        '<div class="form-group col-md-4"><label class="111">Color </label><input type="text" name="color[]" required/></div>' +
        '<div class="form-group col-md-4"><label class="222">Size </label><input type="text" name="size[]" required/></div>' +
        '<div class="form-group col-md-4"><label class="333">So Luong </label><input type="number" min="1" name="soluong[]" required /></div>' +
        '<a href="#" class="remove-sizecolor" border="2"><i class="pull-right glyphicon glyphicon-remove"></i></a>' +
        '</div>');
    });

    $('.resize-color').on('click', '.remove-sizecolor', function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });
});


