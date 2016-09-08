@extends('admin.master')
@section('controller','Product')
@section('action','Edit')
@section('content')
    <style>
        .img-height {
            height: 100px;
        }

        .icon_del {
            position: relative;
            top: -105px;
            float: right;
        }

        #insertImg {
            margin-top: 20px
        }

        .centered {
            vertical-align: middle;
            text-align: center;
        }

        .centered img {
            display: block;
            margin: 0 auto;
        }
    </style>
    <form action="" method="POST" enctype="multipart/form-data" name="frmEditProduct">
        <div class="col-lg-12" style="padding-bottom:120px">
            @include('admin.blocks.errors')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>

            <div class="form-group">
                <label>Category Parent</label>
                <select class="form-control" name="slParent">
                    <option value="0">Please Choose Category</option>
                    <?php callProduct($_parent, 0, '', $_product->cate_id); ?>
                </select>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="txtName" placeholder="Please Enter Username"
                       value="{!! old('txtName', isset($_product) ? $_product->name : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" name="txtPrice" placeholder="Please Enter Password"
                       value="{!! old('txtPrice', isset($_product) ? $_product->price : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Discount</label>
                <input class="form-control" type="number" min="0" max="100" rows="3" name="txtDiscount" value="{!! old('txtDiscount', 0) !!}">
            </div>
            <div class="form-group">
                <label>Icon =><em>new, sale, offer, fire</em></label>
                <input class="form-control" rows="3" name="txtIcon" value="{!! old('txtIcon') !!}">
            </div>
            <div class="form-group">
                <label>Intro</label>
                <textarea class="form-control" rows="3"
                          name="txtIntro">{!! old('txtIntro', isset($_product) ? $_product->intro : null) !!}</textarea>
                <script type="text/javascript">ckeditor('txtIntro')</script>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" rows="3"
                          name="txtContent">{!! old('txtContent', isset($_product) ? $_product->content : null) !!}</textarea>
                <script type="text/javascript">ckeditor('txtContent')</script>
            </div>
            <div class="form-group">
                <label class="col-sm-3 text-center">Images Current</label>
                <img class="img-responsive img-height" src="{!! asset('/upload/' . $_product->src .'/'. $_product->image) !!}">
            </div>
            <div class="form-group">
                <label>Images</label>
                <input type="file" name="fImages">
            </div>
            <div class="form-group">
                <label>Product Keywords</label>
                <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords"
                       value="{!! old('txtKeywords', isset($_product) ? $_product->keywords : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Product Description</label>
                <textarea class="form-control" rows="3"
                          name="txtDescription">{!! old('txtDescription', isset($_product) ? $_product->description : null) !!}</textarea>
            </div>
            <div class="form-group">
                <label>Product Status</label>
                <label class="radio-inline">
                    <input name="rdoStatus" value="1" checked="" type="radio">Visible
                </label>
                <label class="radio-inline">
                    <input name="rdoStatus" value="2" type="radio">Invisible
                </label>
            </div>
            <div class="form-group" style="padding-bottom:20px">

                <div class="form-group resize-color col-sm-8">
                    <button type="button" class="btn btn-primary btn-sm" id="sizecolor">Add-Size-Color</button>
                    <div id="insSizeColor">
                        @foreach ($c_s_c_product as $item)
                        <div class="form-inline">
                            <div class="form-group col-md-4">
                                <label class="111">Color </label>
                                <input type="text" name="colorold[{!!$item->co_id!!}]" required="required" value="{!!$item->namecolor!!}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="222">Size </label>
                                <input type="text" name="sizeold[{!!$item->si_id!!}]" required="required" value="{!!$item->namesize!!}">
                            </div><div class="form-group col-md-4">
                                <label class="333">So Luong </label>
                                <input type="number" min="1" name="soluongold[{!!$item->sl_id!!}]" required="required" value="{!!$item->soluong!!}">
                            </div>
                            <a href="#" class="remove-sizecolor" border="2">
                                <i class="pull-right glyphicon glyphicon-remove"></i></a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group add-remove col-sm-4">
                    <div class="form-group">
                        <table class="table table-striped table-bordered">
                            <tr>
                                @foreach($img_product as $key => $val)
                                    <td class="centered" id="hinh-{!! $val->id !!}">
                                        <div class="form-group img-hover">
                                            <img src="{!! asset('/upload/detail/' . $_product->src . '/' .$val->image) !!}"
                                                 title="{!! $val->image !!}" alt="{!! $val->image !!}"
                                                 class="img-responsive img-height" idhinh="{!! $val->id !!}">
                                            <a href="javascript:void(0)" id="del_img" title="Xóa hình {!! $val->image !!}"
                                               class="btn btn-danger btn-circle icon_del" onclick="xoahinhanh({{$val->id}}, 'Xóa hình {!! $val->image !!}');" /><i class="fa fa-times"></i></a>

                                            <div>
                                    </td>
                                    <!--  {!! $_key = $key %3 !!}
                                    @if($_key == 0) {{ "</tr><tr>" }}
                                    @endif -->
                                    <?php if (++$key % 3 == 0) echo "</tr><tr>"; ?>
                                @endforeach
                            </tr>
                        </table>
                        <hr>
                        {{--<button type="button" class="btn btn-primary btn-sm" id="addImages">AddImages</button>--}}
                        {{--<div id="insertImg"></div>--}}
                        <div class="form-group add-remove">
                            <button type="button" class="btn btn-primary btn-sm" id="addImages">AddImages</button>
                            <div id="insertImg" style="margin-top: 20px;"></div>
                            <div id="selectedFiles"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <input action="action" class="btn btn-default pull-right" type="button" value="Back" onclick="history.go(-1);" />
                <button type="submit" class="btn btn-default">Product Edit</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </div>

        </div>
    </form>
    <script>
        var selDiv = "";

        document.addEventListener("DOMContentLoaded", init, false);

        function init() {
            document.getElementsByName('fProductDetail').addEventListener('change', handleFileSelect, false);
            selDiv = document.querySelector("#selectedFiles");
        }

        function handleFileSelect(e) {

            if(!e.target.files) return;

            selDiv.innerHTML = "";

            var files = e.target.files;
            for(var i=0; i<files.length; i++) {
                var f = files[i];

                selDiv.innerHTML += f.name + "<br/>";

            }

        }
    </script>
@stop