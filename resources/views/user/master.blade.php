<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SimpleOne - A Responsive Html5 Ecommerce Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description_sp')">
    <meta name="author" content="">

{!!\App\Mylib\Bundle::styles('main') !!}

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- fav -->
    <link rel="shortcut icon" href="{!! URL('/images/favicon/favicon.html') !!}">
    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
    {!!\App\Mylib\Bundle::scripts('main') !!}

</head>
<body>
<!-- Header Start -->
<header>
    @include('user.blocks.header')
    <div class="container">
        @include('user.blocks.nav')
    </div>
</header>
<!-- Header End -->

<div id="maincontainer">
@if(isset($is_true))
    <!-- Slider Start-->
    @include('user.blocks.slider')
    <!-- Slider End-->

        <!-- Section Start-->
    @include('user.blocks.ortherdetail')
    <!-- Section End-->
    @endif

    @yield('content')

    <!--AngularJS-->
    {{HTML::script("https://code.angularjs.org/1.2.13/angular.js")}}
    {{HTML::script("//ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular-route.js")}}
    {{HTML::script("//ajax.googleapis.com/ajax/libs/angularjs/1.0.3/angular-sanitize.js")}}
    {{HTML::script("//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.8/angular-ui-router.min.js")}}

    <!--Socket.io-->
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <div class="col-md-12">
        {{--<ul id="messages"></ul>--}}
        {{--<span id="notifyUser"></span>--}}
        {{--<form id="form" action="" onsubmit="return submitfunction();">--}}
        {{--<input type="hidden" id="user" value=""/><input id="m" autocomplete="off" onkeyup="notifyTyping();"--}}
        {{--placeholder="Type yor message here.."/>--}}
        {{--<input type="button" id="button" value="Send"/>--}}
        {{--</form>--}}
        <div class="col-lg-8">
            <div id="messages"></div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-8">
            <form action="sendmessage" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user" value="gdss">
                <textarea class="form-control msg"></textarea>
                <br/>
                <input type="button" value="Send" class="btn btn-success send-msg">
            </form>
        </div>
        <script>
            var hostName = window.location.protocol + "//" + window.location.host + ":8080";
            var socket = io.connect(hostName);
            socket.on('message', function (data) {
                data = jQuery.parseJSON(data);
                console.log(data.user);
                $("#messages").append("<strong>" + data.user + ":</strong><p>" + data.message + "</p>");
            });

            $(".send-msg").click(function (e) {
                e.preventDefault();
                var token = $("input[name='_token']").val();
                var user = $("input[name='user']").val();
                var msg = $(".msg").val();
                if (msg != '') {
                    $.ajax({
                        type: "POST",
                        url: '{!! URL::to("sendmessage") !!}',
                        dataType: "json",
                        data: {'_token': token, 'message': msg, 'user': user},
                        success: function (data) {
                            console.log(data);
                            $(".msg").val('');
                        }
                    });
                } else {
                    alert("Please Add Message.");
                }
            })
        </script>
    </div>
    <!-- Footer -->
@include('user.blocks.footer')
<!-- javascript -->
</div>

</body>
</html>