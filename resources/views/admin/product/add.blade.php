@extends('admin.master')
@section('controller','Product')
@section('action','Add')
@section('content')
    <form action="{!! url('/admin/product/add') !!}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="col-lg-12" style="padding-bottom:120px;">
            @include('admin.blocks.errors')
            <div class="form-group">
                <label>Category Parent</label>
                <select class="form-control" name="slParent">
                    <option value="">Please Choose Category</option>
                    <?php callProduct($_parent, 0, '', old('slParent')); ?>
                </select>
            </div>
                <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="txtName" placeholder="Please Enter Username"
                       value="{!! old('txtName') !!}"/>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" class="form-control" name="txtPrice" placeholder="Please Enter Price"
                       value="{!! old('txtPrice') !!}"/>
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
                <textarea class="form-control" rows="3" name="txtIntro">{!! old('txtIntro') !!}</textarea>
                <script type="text/javascript">ckeditor('txtIntro')</script>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" rows="3" name="txtContent">{!! old('txtContent') !!}</textarea>
                <script type="text/javascript">ckeditor('txtContent')</script>
            </div>
            <div class="form-group">
                <label>Images</label>
                <input type="file" name="fImages" value="{!! old('fImages') !!}">
            </div>
            <div class="form-group">
                <label>Product Keywords</label>
                <input class="form-control" name="txtKeywords" placeholder="Please Enter Category Keywords"
                       value="{!! old('txtKeywords') !!}"/>
            </div>
            <div class="form-group">
                <label>Product Description</label>
                <textarea class="form-control" rows="3" name="txtDescription">{!! old('txtDescription') !!}</textarea>
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
                        <div class="form-inline">
                            <div class="form-group col-md-4">
                                <label class="111">Color </label><input type="text" name="color[]" required="">
                            </div><div class="form-group col-md-4">
                                <label class="222">Size </label><input type="text" name="size[]" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="333">So Luong </label><input type="number" min="1" name="soluong[]" required="">
                            </div>
                            {{--<a href="#" class="remove-sizecolor" border="2"><i class="pull-right glyphicon glyphicon-remove"></i></a>--}}
                        </div>
                    </div>
                </div>




            <!-- <div class="col-md-1"></div> -->
            <!--<div class="col-md-4"> -->
                {{--<button type="button" class="btn btn-primary btn-sm" id="addImages">AddImages</button>--}}
                {{--<div id="insertImg" style="margin-top: 20px;"></div>--}}
                <div class="form-group add-remove col-sm-4">
                    <button type="button" class="btn btn-primary btn-sm" id="addImages">AddImages</button>
                    <div id="insertImg" style="margin-top: 20px;"></div>
                </div>

            </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-default">Product Add</button>
            <button type="reset" class="btn btn-default">Reset</button>
        </div>
        </div>
    </form>
@stop