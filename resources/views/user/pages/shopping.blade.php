@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')

    <section id="product">
        <div class="container">

            <!--  breadcrumb -->
            {!! Breadcrumbs::render('cart') !!}
            {{--kiem tra cart null--}}
            @if (count($datacart))
            <h1 class="heading1"><span class="maintext"> Shopping Cart</span><span class="subtext"> All items in your  Shopping Cart</span>
            </h1>
            <!-- Cart-->
            <a class="pull-right" href="{{action('ShoppingCartController@getClearCart')}}">Clear Shopping Cart</a>
            <div class="cart-info">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th style="text-align:center;" class="image">Image</th>
                        <th style="text-align:center;" class="name">Product Name</th>
                        <th style="text-align:center;" class="model">Size - Color</th>
                        <th style="text-align:center;" class="quantity">Qty</th>
                        <th style="text-align:center;" class="action">Action</th>
                        <th style="text-align:center;" class="price">Unit Price</th>
                        <th style="text-align:center;" class="total">Total</th>

                    </tr>
                    {{--<form method="POST" action="action('ShoppingCartController@postEditCart')">--}}
{{--                        <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                        @foreach($datacart as $key => $items)
                        <tr>
                            <td class="image">
                                <a href="{{ route('section',[$items['alias'], $items['id']]) }}"><img title="{{ $items['name'] }}" alt="" src="{!! asset('/upload/'. $items['src'] .'/'. $items['image']) !!}" height="50" width="50"></a>
                            </td>
                            <td class="name"><a href="{{ route('section',[$items['alias'], $items['id']]) }}">{{{ ucfirst($items['name']) }}}</a>
                                <?php
                                    if($items['discount']){
                                        $discount = $items['discount'];
                                        $dongia = $items['price'] - floor($discount*$items['price']/100);
                                    } else {
                                        $discount = 0;
                                        $dongia = $items['price'];
                                    }
                                ?>
                                @if ($discount)
                                    <br>
                                    <span style="color:red">Sale: {{ $discount }} % </span>
                                @else
                                @endif
                                <br>
                                <span class="productid" name="{{ $items['id'] }}" style="color:red">Mã SP: {{ $items['id'] }} </span>
                            </td>
                            <td class="model">
                                <select name="size" id="size" onchange="editcart({{ $items['qty'] }}, this, true)">
                                    @foreach ($items['dtcolorsize'] as $val)
                                        <option <?php if($val['c_id'] == $items['color_id'] && $val['s_id'] == $items['size_id']) echo 'selected'; ?>  name="{!! $val['c_id'] !!}|{!! $val['s_id'] !!}|{{ $items['id'] }}|{{$key}}" value="{!! $val['c_id'] !!}|{!! $val['s_id'] !!}|{{ $items['id'] }}">{!! $val['namecolor'] !!} - Size {{ $val['namesize'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="quantity">
                                <label onclick="editcart({{ $items['qty'] }}, this)" id='sl' for='options'>{{ $items['qty'] }}</label>
                                <?php
                                if ($items['slmax'] < 5) {
                                    $sisl = $items['slmax'];
                                } elseif ($items['slmax'] < 10) {
                                    $sisl = $items['slmax'];
                                } else {
                                    $sisl=10;
                                }
                                ?>
                                <select class="none" size="{{ $sisl }}" name="qty_" id="qty_" data-rel="popup" >
                                    @for($i = 1; $i <= $items['slmax']; $i++)
                                        <option <?php if($i == $items['qty']) echo 'selected'; ?>  name="{{$items['color_id']}}|{{$items['size_id']}}|{{$items['id']}}|qty" value="{!! $i !!}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                            <td class="action">
                                <a href="{!! route('postDelCart', $key) !!}" onclick="return xacnhanxoa('Bạn có chắc là xóa không!')">
                                    <img class="tooltip-test" data-original-title="Remove" src="{{ asset('/user/img/remove.png')}}" alt="">
                                </a>
                            </td>


                            <td class="price">{!! number_format($dongia, 0, ",", ".") !!} <sup> &#8363;</sup></td>
                            <td class="total">{!!number_format($items['qty']*$dongia, 0, ",", ".") !!}<sup> &#8363;</sup></td>

                        </tr>
                        @endforeach
                    {{--</form>--}}
                </table>
            </div>
            <div class="container">
                <div class="pull-right">
                    <div class="span4 pull-right">
                        <table class="table table-striped table-bordered ">
                            <tr>
                                <td><span class="extra bold">Sub-Total :</span></td>
                                <td><span class="bold">$101.0</span></td>
                            </tr>
                            <tr>
                                <td><span class="extra bold">Eco Tax (-5.00) :</span></td>
                                <td><span class="bold">$11.0</span></td>
                            </tr>
                            <tr>
                                <td><span class="extra bold">VAT (18.2%) :</span></td>
                                <td><span class="bold">$21.0</span></td>
                            </tr>
                            <tr>
                                <td><span class="extra bold totalamout">Total :</span></td>
                                <td><span class="bold totalamout">{!!number_format($total, 0,",", ".")!!} <sup> &#8363;</sup></span></td>
                            </tr>
                        </table>
                        <input type="submit" value="CheckOut" class="btn btn-orange pull-right">
                        <input type="submit" onclick="window.location='{!!URL('/')!!}';" value="Continue Shopping" class="btn btn-orange pull-right mr10">
                    </div>
                </div>
            </div>
        </div>
        @else
            @include('user.errors.notfoundcart')
        @endif
    </section>
@endsection