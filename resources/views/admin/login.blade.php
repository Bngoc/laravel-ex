<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Vu Quoc Tuan">
    <title>{!! @title !!}</title>

{{--    {!!\App\Mylib\Bundle::styles('admin_main') !!}--}}

<!-- Bootstrap Core CSS -->
    <link href="{{ url('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ url('admin/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('admin/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ url('admin/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('css/rawcss.css') }}" rel="stylesheet" type="text/css">

    <style type="text/css">
        .error {
            color: #F44336;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-lock"></i> Please Sign In</h3>
                    <img style="display:none" src="{{url('/upload/103.gif')}}" class="pull-right" id="loader">
                </div>
                @include('admin.blocks.errors')
                <div id="cfk" style="display:none">
                    <span id="msg"></span>
                </div>
                <div class="panel-body">
                    <form role="form" id="login_form" action="{{url('admin/login')}}" method="POST">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Ussername" name="user" type="text" autofocus
                                       value="">
                                <span style="color:red; display:none" class="error-none error-usesname"></span>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password"
                                       value="">
                                <span style="color:red; display:none" class="error-none error-pass"></span>
                            </div>
                            <div class="form-group">
                                <div class="form-inline">
                                    <div class="col-md-6 pull-left inline pd-none">
                                        <label class="btn btn-link pd-l15">
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <a class="btn btn-link" href="{{ url('password/email') }}">Forgot
                                            YourPassword?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-md-12 pd-none">
                                    <button type="button" id="sign_id" class="btn btn-lg btn-block btn-primary">Login
                                    </button>
                                    <!-- Dùng ajax không sử dụng type="submint" -->
                                    <!-- <button type="submit" id="sign_id" class="btn btn-block btn-primary">Login</button> -->

                                <!-- <a class="btn btn-link pull-left" href="{{ url('/auth/register') }}">Register</a> -->
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ url('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ url('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ url('admin/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ url('admin/dist/js/sb-admin-2.js') }}"></script>

<!-- Validator -form -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>

<script type="text/javascript">
    function loader(v) {
        if (v == 'on') {
            $('#login_form').css({
                opacity: 0.2
            });
            $('#loader').show();
        } else {
            $('#login_form').css({
                opacity: 1
            });
            $('#loader').hide();
        }
    }
    function redirect(_url) {
        window.location = _url;
    }

    $(function () {

        $("#login_form").validate({

            rules: {
                user: "required",
                password: "required",
                // email: {
                //     required: true,
                //     email: true
                // },
                password: {
                    required: true,
                    minlength: 5
                }
                // agree: "required"
            },

            // Specify the validation error messages
            messages: {
                user: "Username là trường bắt buộc",
                // lastname: "Please enter your last name",
                password: {
                    required: "password là trường bắt buộc",
                    minlength: "Password nhiều hơn 5 kí tự"
                }
                // email: "Please enter a valid email address",
                // agree: "Please accept our policy"
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        //var _name = $("input[name='user']").val();
        //var _pass = $("input[name='user']").val();
        // $('button[type="button"]').prop('disabled', true);
        // $('input[type="text"]').keyup(function() {
        //    if($(this).val() != '') {
        //       $('button[type="button"]').prop('disabled', false);
        //    }
        // })

        //alert( _name + _pass);

        $("#sign_id").on('click', function (e) {
            e.preventDefault();

            //serializeArray [{'name':user, 'value':''}, {'name':password, 'value':''}, ]
            var login_form = $("#login_form").serializeArray();
            var url = $("#login_form").attr('action');

            loader('on');
            $.post(url, login_form, function (data) {
//                console.log(data);
                loader('off');
                $('.error-none').hide();
                if (data['_key'] == '_fail') {

                    if (data._info.user != undefined) {
                        $('.error-usesname').show().text(data._info.user[0]);
                    }
                    if (data._info.password != undefined) {
                        $('.error-pass').show().text(data._info.password[0]);
                    }
                } else {
                    if (data['_key'] == 'fail') {
                        $('#msg').text(data['info']);
                        $('#cfk').addClass('alert alert-danger').fadeIn(2000, function () {
                            $(this).hide();
                        });
                    } else {
                        $('#msg').text(data['info']);
                        $('#cfk').addClass('alert alert-success').fadeIn(1000, function () {
                            $(this).hide();
                        });
                        redirect(data['_url']);

                    }
                }
            });

            // $.ajax({
            //     url: url,
            //     type: 'post',
            //     data: login_form,
            //     dataType: 'json',
            //     success: function (data) {
            //         console.log(data);
            //         loader('off');
            //         if (data['_key'] == 'fail') {
            //             $('#cfk').addClass('alert alert-danger').fadeIn(2000, function () {
            //                 $(this).hide();
            //             });
            //             $('#msg').text('Errors, Login');
            //         } else {
            //             $('#cfk').addClass('alert alert-success').fadeIn(2000, function () {
            //                 $(this).hide();
            //             });
            //             $('#msg').text('Successfully logged in .... redirecting');
            //             redirect(data['_url']);
            //         }
            //     },
            // });
        });
    });

</script>
</body>

</html>
