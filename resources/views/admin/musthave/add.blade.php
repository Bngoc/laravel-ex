@extends('admin.master')
@section('controller','Must Have')
@section('action','Add')
@section('content')

<div class="col-lg-7" style="padding-bottom:120px">
    @include('admin.blocks.errors')
    <form action="{!! route('must.getAdd') !!}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>

        <div class="form-group">
            <label>Must Have Name</label>
            <input class="form-control" name="txtMustHave" placeholder="Please Enter Must have Name" value="{!! old('txtMustHave') !!}" />
        </div>
        
        <div class="form-group add-remove">
            <button type="button" class="btn btn-primary btn-sm" id="addImages">AddImages</button>
            
            <div class="form-groud">
                <label>Image Product detail </label>
                <input type="file" name="fProductDetail[]">
            </div>
            <div id="insertImg" style="margin-top: 20px;"></div>
        </div>
        <button type="submit" class="btn btn-default">Must Have Add</button>
        <button type="reset" class="btn btn-default">Reset</button>
        <form>
</div>
@endsection()