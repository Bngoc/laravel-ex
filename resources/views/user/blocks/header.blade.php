<div class="headerstrip">
    <div class="container">
        <div class="row">
            <div class="span12">
                <a href="{!! URL('/') !!}" class="logo pull-left"><img src="{!! asset('/user/img/logo.png') !!}" alt="SimpleOne" title="SimpleOne"></a>
                <!-- Top Nav Start -->
                <div class="pull-left">
                    <div class="navbar" id="topnav">
                        <div class="navbar-inner">
                            <ul class="nav">
                                <li><a class="home active" href="{!! URL('/') !!}">Home</a>
                                </li>
                                <li><a class="myaccount" href="
                                @if(Auth::guard('web')->check())
                                    {!! auth()->user()->username !!}
                                @else
                                    #
                                @endif">
                                @if(Auth::guard('web')->check())
                                    {!! auth()->user()->username !!}
                                @else
                                    My Account
                                @endif</a>
                                </li>
                                <li>
                                    <a class="shoppingcart" href="{!! route('getCart') !!}" title="Hiện có @if(count(Cart::content())) {{count(Cart::content())}} @else 0 @endif sản phẩm">Shopping Cart @if(count(Cart::content())) ({{count(Cart::content())}}) @endif</a>
                                </li>
                                <li><a class="checkout" href="#">CheckOut</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Top Nav End -->
            </div>
        </div>
    </div>
</div>