@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')
    <section id="product">
        <div class="container">
            <!--  breadcrumb -->
            {!! Breadcrumbs::render('_product', Route::current()->parameters(), $data_cate) !!}

            <div class="row">
                <!-- Sidebar Start-->
                <aside class="span3">
                    <!-- Category-->
                    <div class="sidewidt">
                        <h2 class="heading2"><span>Categories</span></h2>
                        <ul id="menu-content" class="menu-content"><!-- class="nav nav-list categories" -->
                            
                            @foreach($data_cate as $items)
                            <li data-toggle="collapse" data-target="#{!! $items['alias'] !!}" class="nav-heade <?php if (Route::current()->getParameter('products') == $items['alias']) echo 'collapsed';?>">
                                <i class="glyphicon glyphicon-chevron-<?php if (Route::current()->getParameter('products') == $items['alias']) echo 'down'; else echo 'right'; ?>"></i>
                                <span class="pull-right badge bage-total">{{ $items['total'] }}</span>
                                <a href="{!! route('product_page', [$items['url'], $items['alias']]) !!}" title="{{ $items['name'] }}">{{ $items['name'] }}</a>
                            </li>
                            <hr>
                            <ul class="sub-menu <?php if (Route::current()->getParameter('products') == $items['alias']) echo 'in';?> collapse" id="{!! $items['alias'] !!}">
                                @foreach($items['count_product'] as $val)
                                <li>
                                    <span class="badge pull-right bage-chidl">{{ $val['count'] }}</span>
                                    <a title="{{ $val['name'] }}" href="{!! route('sections_page', [$items['url'], $items['alias'], $val['alias']]) !!}" class="click"> {{ $val['name'] }}</a>
                                </li>
                                @endforeach
                                <hr>
                            </ul>
                            @endforeach
                        </ul>
                    </div>

                    <!--  Best Seller -->
                    <div class="sidewidt">
                        <h2 class="heading2"><span>Best Seller</span></h2>
                        <ul class="bestseller">
                            @foreach ($product_best as $key => $item)
                                <li>
                                    <img width="50" height="50" src="{!! asset('/upload/'. $item->src .'/'. $item->image) !!}" alt="product" title="product">
                                    <a class="productname" href="{!! route('section', [$item->alias, $item->id]) !!}"> {!! $item->name !!}</a>
                                    <span class="procategory">{!! $item->catename !!}</span>
                                    @if($item->discount)
                                        <div class="price">{!! number_format($item->price - floor(($item->discount)*($item->price)/100), 0, ",", ".") !!} <sup> &#8363;</sup></div>
                                    @else
                                        <div class="price">{!! number_format($item->price, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Latest Product -->
                    <div class="sidewidt">
                        <h2 class="heading2"><span>Latest Products</span></h2>
                        <ul class="bestseller">
                            @foreach ($product_last as $key => $item)
                            <li>
                                <img width="50" height="50" src="{!! asset('/upload/'. $item->src .'/'. $item->image) !!}" alt="product" title="product">
                                <a class="productname" href="{!! route('section', [$item->alias, $item->id]) !!}"> {!! $item->name !!}</a>
                                <span class="procategory">{!! $item->catename !!}</span>
                                @if($item->discount)
                                    <div class="price">{!! number_format($item->price - floor(($item->discount)*($item->price)/100), 0, ",", ".") !!} <sup> &#8363;</sup></div>
                                @else
                                    <div class="price">{!! number_format($item->price, 0, ",", ".") !!} <sup> &#8363;</sup></div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--  Must have -->
                    <div class="sidewidt">
                        <h2 class="heading2"><span>Must have</span></h2>

                        <div class="flexslider" id="mainslider">
                            <ul class="slides">
                                @foreach($musthave as $val)
                                <li>
                                    <img src="{!! asset('/upload/musthave/'. $val->path .'/'. $val->image) !!}" alt=""/>
                                </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                </aside>
                <!-- Sidebar End-->
                <!-- Category-->
                <div class="span9">
                    <!-- Category Products-->
                    @if(count($data_product))
                    <section id="category">
                        <div class="row">
                            <div class="span9">
                                <!-- Category-->
                                <section id="categorygrid">
                                    <ul class="thumbnails grid">
                                       @foreach($data_product as $val)
                                            <li class="span3">
                                                <a class="prdocutname" href="{!! route('section', [$val->alias, $val->id]) !!}" title="{!! $val->name !!}">{!! $val->name !!}</a>

                                                <div class="thumbnail">
                                                    @if($val->icon)
                                                    <span class="{!! $val->icon !!} tooltip-test">{!! $val->icon !!}</span>
                                                    @endif
                                                    <div class="set-box">
                                                        <a href="{!! route('section', [$val->alias, $val->id]) !!}"><img alt="{!! $val->name !!}" src="{!! asset('/upload/'. $val->src .'/'. $val->image) !!}"></a>
                                                    </div>
                                                    <div class="pricetag">
                                                        <span class="spiral"></span>
                                                        {{--<a href="#" class="productcart">ADD TO CART</a>--}}
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
                                    <div class="pagination pull-right">
                                        <ul>
                                            
		                                    @if ($data_product->currentPage() != 1)
		                                    <li><a href="{!! $data_product->url($data_product->currentPage()-1) !!}">Prev</a></li>
		                                    @elseif ($data_product->currentPage() == 1)
		                                    <li class="active"><a href="javascript:void(0)">Prev</a></li>
		                                    @endif
		                                    @for ($i = 1; $i <= $data_product->lastPage(); $i++)
		                                    <li class="{!! $data_product->currentPage() == $i ? 'active' : null !!}"><a href="{!! $data_product->url($i) !!}">{!! $i !!}</a></li>
		                                    @endfor
		                                    @if ($data_product->currentPage() != $data_product->lastPage())
		                                    <li><a href="{!! $data_product->url($data_product->currentPage()+1) !!}">Next</a></li>
		                                    @elseif ($data_product->currentPage() == $data_product->lastPage())
		                                    <li class="active"><a href="javascript:void(0)">Next</a></li>
		                                    @endif
                               
                                        </ul>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                    @else
                        <h3>Hiện tại không có sản phẩm nào trong danh mục {{$danhmuc}}</h3>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection