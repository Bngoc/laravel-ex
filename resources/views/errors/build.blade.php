@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')
<style>
    .setspan{
        text-align: center;
        margin: 22px 0px;
    }
    .setspan span{
        font-size: 15px;
        color: black;
    }
    .error-back {
        text-decoration: none;
        color: #430400;
        font-size: 15px;
        text-transform: uppercase;
        font-weight: bold;}
    .error-back:hover {
        color: #EB957D;
        text-shadow: 0 0 3px black;
        text-transform: uppercase;
        font-weight: bold;
    }
</style>
<div class="container">
    <div class="span12 setspan">
        <span>Đường dẫn không tồn tại hoặc đang được cập nhật</span>
        <br>
        <span>Vùi lòng trở lại sau <a href="{{url('/')}}" title="Back to site" class="error-back">back</a></span>
    </div>
</div>
@stop