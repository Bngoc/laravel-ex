@extends('user.master')
@section('description_sp', 'Demo sản phẩm .....')
@section('content')
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
        /*body {*/
            /*margin: 0;*/
            /*padding: 0;*/
            /*width: 100%;*/
            /*height: 100%;*/
            /*color: #B0BEC5;*/
            /*display: table;*/
            /*font-weight: 100;*/
            /*font-family: 'Lato';*/
        /*}*/

        .container {
            text-align: center;
            /*display: table-cell;*/
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
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
    <div class="content">
        <span>
            <h1>{{$e->getStatusCode()}}</h1>
            <h2>{{ $e->getMessage() }}</h2>
        </span>
        <img src="{{asset('public/user/img/503.jpg')}}" width="600" height="449" />
        <a href="{{url('/')}}" title="Back to site" class="error-back">back</a>
    </div>
</div>
@stop
