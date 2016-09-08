@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')
<!-- Header End -->
<div class="container">
    <!-- nghiem cuu cache  -->
    <!--  breadcrumb --> 
    {!! Breadcrumbs::render('_detail', $breadcrumb_detail) !!}
</div>
<div id="maincontainer">
    <section id="product">
        <div class="container">

            <!-- Product Details-->
            <div class="row">
                <!-- Left Image-->
                <div class="span5">
                    <ul class="thumbnails mainimage">
                        <li class="span5">
                            <a rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4"
                               class="thumbnail cloud-zoom" href="{{ asset('/upload/'.$detail->src.'/'.$detail->image)}}">
                                <img src="{{ asset('/upload/'.$detail->src.'/'.$detail->image)}}" alt="{{ $detail->name}}" title="{{ $detail->name}}">
                            </a>
                        </li>
                        @foreach($image_detail as $val)
                        <li class="span5">
                            <a rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4"
                               class="thumbnail cloud-zoom" href="{{ asset('/upload/detail/'.$detail->src.'/'.$val->image)}}">
                                <img src="{{ asset('/upload/detail/'.$detail->src.'/'.$val->image)}}" alt="{{ ucfirst($detail->name)}}" title="{{ ucfirst($detail->name) }}">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <ul class="thumbnails mainimage">
                        <li class="producthtumb">
                            <a class="thumbnail">
                                <img src="{{ asset('/upload/'.$detail->src.'/'.$detail->image)}}" alt="{{ $detail->name}}" title="{{ $detail->name}}">
                            </a>
                        </li>
                        @foreach($image_detail as $val)
                        <li class="producthtumb">
                            <a class="thumbnail">
                                <img src="{{ asset('/upload/detail/'.$detail->src.'/'.$val->image)}}" alt="" title="">
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Right Details-->
                <div class="span7">
                    <div class="row">
                        <div class="span7">
                            <h1 class="productname"><span class="bgnone">{{{ ucfirst($detail->name)}}}</span></h1>

                            <div class="productprice">
                                <div class="productpageprice">
                                    @if ($detail->discount)
                                        <span class="spiral"></span>{{{ number_format(($detail->price - floor(($detail->discount*($detail->price)/100))), 0, ',', '.') }}}
                                    @else
                                        <span class="spiral"></span>{{{ number_format($detail->price, 0, ',', '.') }}}
                                    @endif
                                    <sup> &#8363;</sup>
                                </div>
                            </div>
                            <ul class="desc">
                                <li><b>Mã sản phẩm: 160501</b></li>
                                <li><h4>Thông tin sản phẩm</h4>
                                    <br>
                                </li>
                                <li>Số lượt xem : 32</li>
                                <li class="attrs-item option">Chọn size: &nbsp;&nbsp;
                                    <select name="size" id="size" onchange="getsoluong({{$detail->id}})">
                                        @foreach ($size_detail as $val)
                                        <option <?php if ($val->id == $default_s) echo 'selected' ?> name="{{$val->id}}" value="{{$val->id}}">{{$val->namesize}}</option>
                                        @endforeach
                                    </select>
                                    <div class="clr"></div>
                                </li>
                                <li class="attrs-item option">Chọn màu: &nbsp;
                                    <select name="color" id="color" onchange="getsoluong({{$detail->id}})">
                                        @foreach ($color_detail as $val)
                                            <option <?php if ($val->id == $default_c) echo 'selected' ?> name="{{$val->id}}" value="{{$val->id}}">{{$val->namecolor}}</option>
                                        @endforeach
                                    </select>
                                    <div class="clr"></div>
                                </li>
                            </ul>

                            {{--<input class="input-text qty text number" maxlength="3" title="Qty" size="4" value="1" name="quantity" id="soluong" max="50" min="1" step="1">--}}
                            <ul class="productpagecart">
                                <div id="setsoluong">
                                    <input type="number" class="input-text qty text number" pattern="\d*" maxlength="3" title="Qty" size="4" value="1" name="quantity" id="soluong" min="1" step="1" max="{{$default_sl}}" />
                                </div>
                                <li>
                                    <a class="cart" href="javascript:add_to_cart({{$detail->id}})">Add to Cart</a>

                                </li>
                            </ul>
                            <!-- Product Description tab & comments-->
                            <div class="productdesc">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a href="#description">Description</a>
                                    </li>
                                    <li><a href="#specification">Specification</a>
                                    </li>
                                    <li><a href="#review">Review</a>
                                    </li>
                                    <li><a href="#producttag">Tags</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="description">
                                        {!! $detail->description !!}
                                        <!-- <h2>h2 tag will be appear</h2>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum <br>
                                        <br>
                                        <ul class="listoption3">
                                            <li>Lorem ipsum dolor sit amet Consectetur adipiscing elit</li>
                                            <li>Integer molestie lorem at massa Facilisis in pretium nisl aliquet</li>
                                            <li>Nulla volutpat aliquam velit</li>
                                            <li>Faucibus porta lacus fringilla vel Aenean sit amet erat nunc Eget
                                                porttitor lorem
                                            </li>
                                        </ul> -->
                                    </div>
                                    <div class="tab-pane " id="specification">
                                        <ul class="productinfo">
                                            <li>
                                                <span class="productinfoleft"> Product Code:</span> Product 16
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Reward Points:</span> 60
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Availability: </span> In Stock
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Old Price: </span> $500.00
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Ex Tax: </span> $500.00
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Ex Tax: </span> $500.00
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Product Code:</span> Product 16
                                            </li>
                                            <li>
                                                <span class="productinfoleft"> Reward Points:</span> 60
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" id="review">
                                        <h3>Write a Review</h3>

                                        <form class="form-vertical">
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="control-label">Text input</label>

                                                    <div class="controls">
                                                        <input type="text" class="span3">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Textarea</label>

                                                    <div class="controls">
                                                        <textarea rows="3" class="span3"></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <input type="submit" class="btn btn-orange" value="continue">
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="producttag">
                                        <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                            Lorem Ipsum has been the industry's standard dummy text ever since the
                                            1500s, when an unknown printer took a galley of type and scrambled it to
                                            make a type specimen book. It has survived not only five centuries, but also
                                            the leap into electronic typesetting, remaining essentially unchanged. It
                                            was popularised in the 1960s with the release of Letraset sheets containing
                                            Lorem Ipsum passages, and more recently with desktop publishing software
                                            like Aldus PageMaker including versions of Lorem Ipsum <br>
                                            <br>
                                        </p>
                                        <ul class="tags">
                                            <li><a href="#"><i class="icon-tag"></i> Webdesign</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> html</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> html</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> css</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> jquery</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> css</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> jquery</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> Webdesign</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> css</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> jquery</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> Webdesign</a>
                                            </li>
                                            <li><a href="#"><i class="icon-tag"></i> html</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  Related Products-->
    <section id="related" class="row">
        <div class="container">
            <h1 class="heading1"><span class="maintext">Related Products</span><span class="subtext"> See Our Most featured Products</span>
            </h1>
            <ul class="thumbnails"><!-- slides -->
               @foreach($product_cate as $val)
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
                                    <button type="submit" class="add-to-cart">
                                        Add to cart
                                        <i class="fa fa-shopping-cart fa-stack-2x" aria-hidden="true"></i>
                                    </button>
                                </form>
                            {{--<a href="#" class="productcart">ADD TO CART</a>--}}
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
    <!-- Popular Brands-->
</div>
    <script type="application/javascript">
//        $(document).ready(function () {
//            var size_id = document.getElementById('size').value;
//            var color_id = document.getElementById('color').value;
//            var crsfToken = document.head.querySelector("[name=csrf-token]").content;
//            var dataString = "size_id=" + size_id+ "&color_id=" + color_id + "&_token=" + crsfToken;
//            var output ='<input type="number" class="input-text qty text number" pattern="\d*" maxlength="3" title="Qty" size="4" value="1" name="quantity" id="soluong" min="1" step="1"';
//            $.ajax({
//                type: "POST",
//                url: baseURL+"/color-size-soluong",
//                data: dataString,
//                cache: false,
//                success: function(response)
//                {
//                    if (response['soluong']) {
//                        output += 'max="'+ response['soluong'] + '" />';
//                    }
//                    else {
//                        output += 'max="9999" />';
//                    }
//                    document.getElementById("setsoluong").innerHTML = output;
//                }
//            });
//        });
    </script>
@endsection