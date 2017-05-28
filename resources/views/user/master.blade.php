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

<!-- Footer -->
@include('user.blocks.footer')
<!-- javascript -->
</div>

</body>
</html>