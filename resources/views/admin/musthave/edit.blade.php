@extends('admin.master')
@section('controller','Category')
@section('action','edit')
@section('content')
    <div class="col-lg-7" style="padding-bottom:120px">
        @include('admin.blocks.errors')
        <form action="" method="POST">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>

            <div class="form-group">
                <label>Category Parent</label>
                <select class="form-control" name="slParent">
                    <option value="0">Please Choose Category</option>
                    <?php if ($_parent) callCate($_parent, 0, '', $_gdata['parent_id']); ?>
                </select>
            </div>
            <div class="form-group">
                <label>Category Name</label>
                <input class="form-control" name="txtCateName" placeholder="Please Enter Category Name"
                       value="{!! old('txtCateName', isset($_gdata) ? $_gdata['name'] : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Category Order</label>
                <input class="form-control" name="txtOrder" placeholder="Please Enter Category Order"
                       value="{!! old('txtOrder', isset($_gdata) ? $_gdata['order'] : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Category Keywords</label>
                <input class="form-control" name="txtKeyWords" placeholder="Please Enter Category Keywords"
                       value="{!! old('txtKeyWords', isset($_gdata) ? $_gdata['keywords'] : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Category Description</label>
                <textarea class="form-control" name="txtDescription" rows="3"> {!! old('txtDescription', isset($_gdata) ? $_gdata['description'] : null) !!}
                    </textarea>
            </div>
            <div class="form-group">
                <label>Category Status</label>
                <label class="radio-inline">
                    <input name="rdoStatus" value="1" checked="" type="radio">Visible
                </label>
                <label class="radio-inline">
                    <input name="rdoStatus" value="2" type="radio">Invisible
                </label>
            </div>
            <button type="submit" class="btn btn-default">Category Edit</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <form>
    </div>
@endsection