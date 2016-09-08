@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')

<section id="featured" class="row mt40">
    <div class="container">
        <h1 class="heading1"><span class="maintext">Featured Products</span><span class="subtext"> See Our Most featured Products</span>
        </h1>
        <ul class="thumbnails"> <!-- New, sale, offer, fire -->
            @foreach($featur_product as $val)
            <li class="span3">
                <a class="prdocutname" href="{!! route('section', [$val->alias, $val->id]) !!}" title="{!! $val->name !!}">{!! $val->name !!}</a>
                <div class="thumbnail">
                    @if($val->icon)
                    <span class="{!! $val->icon !!} tooltip-test">{!! $val->icon !!}</span>
                    @endif
                    <div class="set-box">
                        <a href="{!! route('section', [$val->alias, $val->id]) !!}">
                        <img alt="{!! $val->name !!}" src="{!! asset('/upload/'. $val->src .'/'. $val->image) !!}"></a>
                    </div>
                    <div class="pricetag">
                        <span class="spiral"></span>
                        <form method="POST" action="{{action('ShoppingCartController@postCart')}}">
                            <input type="hidden" name="product_id" value="{{$val->id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="button" class="add-to-cart">
                                Add to cart
                                <i class="fa fa-shopping-cart fa-stack-2x" aria-hidden="true"></i>
                            </button>
                        </form>
                        <div class="price">
                            @if($val->discount)
                            <?php $price_new = $val->price - floor(($val->discount)*($val->price)/100); ?>
                            <div class="pricenew">{!! number_format($price_new, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                            <div class="priceold">{!! number_format($val->price, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                            @else
                            <div class="pricenew">{!! number_format($val->price, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>

<!-- Latest Product-->
<section id="latest" class="row">
    <div class="container">
        <h1 class="heading1"><span class="maintext">Latest Products</span><span class="subtext"> See Our  Latest Products</span>
        </h1>
        <ul class="thumbnails">
            @foreach($last_product as $val)
            <li class="span3">
                <a class="prdocutname" href="{!! route('section', [$val->alias, $val->id]) !!}" title="{!! $val->name !!}">{!! $val->name !!}</a>
                
                <div class="thumbnail">
                    @if($val->icon)
                    <span class="{!! $val->icon !!} tooltip-test">{!! $val->icon !!}</span>
                @endif
                    <div class="set-box">
                        <a href="{!! route('section', [$val->alias, $val->id]) !!}">
                        <img alt="{!! $val->name !!}" src="{!! asset('/upload/'. $val->src .'/'. $val->image) !!}"></a>
                    </div>
                    <div class="pricetag">
                        <span class="spiral"></span>
                        <form method="POST" action="{{action('ShoppingCartController@postCart')}}">
                            <input type="hidden" name="product_id" value="{{$val->id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="button" class="add-to-cart">
                                Add to cart
                                <i class="fa fa-shopping-cart fa-stack-2x" aria-hidden="true"></i>
                            </button>
                        </form>
                        <div class="price">
                            @if($val->discount)
                            <?php $price_new = $val->price - floor(($val->discount)*($val->price)/100); ?>
                            <div class="pricenew">{!! number_format($price_new, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                            <div class="priceold">{!! number_format($val->price, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                            @else
                            <div class="pricenew">{!! number_format($val->price, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>
@endsection