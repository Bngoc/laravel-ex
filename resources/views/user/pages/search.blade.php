@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')
    <hr>
    @if(count($data_search))
        <div class="container">
            <div class="row">
                <section id="category">
                    <div class="span12">
                        <!-- Category-->
                        <section id="categorygrid">
                            <ul class="thumbnails grid">
                                @foreach($data_search as $val)
                                    <li class="span3">
                                        <a class="prdocutname" href="{!! route('section', [$val->alias, $val->id]) !!}"
                                           title="{!! $val->name !!}">{!! str_replace($keyword, '<mark>'.$keyword.'</mark>', $val->name) !!}</a>

                                        <div class="thumbnail">
                                            @if($val->icon)
                                                <span class="{!! $val->icon !!} tooltip-test">{!! $val->icon !!}</span>
                                            @endif
                                            <div class="set-box">
                                                <a href="{!! route('section', [$val->alias, $val->id]) !!}"><img
                                                            alt="{!! $val->name !!}"
                                                            src="{!! asset('/upload/'. $val->src .'/'. $val->image) !!}"></a>
                                            </div>
                                            <div class="pricetag">
                                                <span class="spiral"></span>
                                                <form method="POST" action="{{action('FrontEnd\ShoppingCartController@postCart')}}">
                                                    <input type="hidden" name="product_id" value="{{$val->id}}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="button" class="add-to-cart">
                                                        Add to cart
                                                        <i class="fa fa-shopping-cart fa-stack-2x" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                <div class="price">
                                                    @if($val->discount)
                                                        <?php $price_new = $val->price - floor(($val->discount) * ($val->price) / 100); ?>
                                                        <div class="pricenew">{!! number_format($price_new, 0, ",", ".")
                                                            !!} <sup> &#8363;</sup></div>
                                                        <div class="priceold">{!! number_format($val->price, 0, ",",
                                                            ".") !!} <sup> &#8363;</sup></div>
                                                    @else
                                                        <div class="pricenew">{!! number_format($val->price, 0, ",",
                                                            ".") !!} <sup> &#8363;</sup></div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="pagination pull-right">
                                <ul>
                                    @if ($data_search->currentPage() != 1)
                                    <li><a href="{!! $data_search->url($data_search->currentPage()-1) !!}">Prev</a></li>
                                    @elseif ($data_search->currentPage() == 1)
                                    <li class="active"><a href="javascript:void(0)">Prev</a></li>
                                    @endif
                                    @for ($i = 1; $i <= $data_search->lastPage(); $i++)
                                    <li class="{!! $data_search->currentPage() == $i ? 'active' : null !!}"><a href="{!! $data_search->appends(['k' => $keyword])->url($i) !!}">{!! $i !!}</a></li>
           							@endfor
                                    @if ($data_search->currentPage() != $data_search->lastPage())
                                    <li><a href="{!! $data_search->url($data_search->currentPage()+1) !!}">Next</a></li>
                                    @elseif ($data_search->currentPage() == $data_search->lastPage())
                                    <li class="active"><a href="javascript:void(0)">Next</a></li>
                                    @endif
                                </ul>
                            </div>
                        </section>
                    </div>
                </section>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="output_notsearch">
                        <p class="lead">Không tìm thấy sản phẩm nào với từ khóa
                            <b><span class="text-danger"><mark>{{ $keyword }}</mark></span></b> trong mục
                            <span>"Tất cả"</span>
                        </p>
                        <ul class="note">
                            <li>- Bạn hãy chắc chắn rằng từ khóa tìm kiếm đúng chính tả.</li>
                            <li>- Thử tìm với từ khóa khác.</li>
                            <li>- Thử tìm với từ khóa có nội dung chung chung hơn.</li>
                        </ul>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    @endif
@endsection