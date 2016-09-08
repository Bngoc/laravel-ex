<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SimpleOne - A Responsive Html5 Ecommerce Template</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description_sp')">
    <meta name="author" content="">
    {{--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,400italic,600,600italic' rel='stylesheet'--}}
          {{--type='text/css'>--}}
    {{--<link href='http://fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>--}}
    
    <link href="{!! URL('/user/css/bootstrap.css') !!}" rel="stylesheet">
    <link href="{!! URL('/user/css/bootstrap-responsive.css') !!}" rel="stylesheet">
    <link href="{!! URL('/user/css/style.css') !!}" rel="stylesheet">
    <link href="{!! URL('/user/css/flexslider.css') !!}" type="text/css" rel="stylesheet"/>
    <link href="{!! URL('/user/css/jquery.fancybox.css') !!}" rel="stylesheet">
    <link href="{!! URL('/user/css/cloud-zoom.css') !!}" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- fav -->
    <link rel="shortcut icon" href="{!! URL('/user/assets/ico/favicon.html') !!}">
    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
    <script src="{!! URL('/user/js/jquery.js') !!}"></script>
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

    <!-- Footer -->
     @include('user.blocks.footer')
    <!-- javascript -->
</div>
        <!-- ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="{!! URL('/user/js/bootstrap.js') !!}"></script>
    <script src="{!! URL('/user/js/respond.min.js') !!}"></script>
    <script src="{!! URL('/user/js/application.js') !!}"></script>
    <script src="{!! URL('/user/js/bootstrap-tooltip.js') !!}"></script>
    <script defer src="{!! URL('/user/js/jquery.fancybox.js') !!}"></script>
    <script defer src="{!! URL('/user/js/jquery.flexslider.js') !!}"></script>
    <script type="text/javascript" src="{!! URL('/user/js/jquery.tweet.js') !!}"></script>
    <script src="{!! URL('/user/js/cloud-zoom.1.0.2.js') !!}"></script>
    <script type="text/javascript" src="{!! URL('/user/js/jquery.validate.js') !!}"></script>
    <script type="text/javascript" src="{!! URL('/user/js/jquery.carouFredSel-6.1.0-packed.js') !!}"></script>
    <script type="text/javascript" src="{!! URL('/user/js/jquery.mousewheel.min.js') !!}"></script>
    <!-- <script type="text/javascript" src="{!! URL('/user/js/jquery.touchSwipe.min.js') !!}"></script> -->
    <script type="text/javascript" src="{!! URL('/user/js/jquery.ba-throttle-debounce.min.js') !!}"></script>
    <script defer src="{!! URL('/user/js/custom.js') !!}"></script>
    <script defer src="{!! URL('/user/js/my_srcipt.js') !!}"></script>

</body>
</html>