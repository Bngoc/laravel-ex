@extends('admin.master')
@section('controller','User')
@section('action','Edit')
@section('content')

    <div class="col-lg-7" style="padding-bottom:120px">
        @include('admin.blocks.errors')
        <form action="" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="txtUser" disabled="disabled"
                       value="{!! old('txtUser', isset($data) ? $data->username : null) !!}"/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="txtPass" placeholder="Please Enter Password"
                @if (Auth::guard('admin')->user()->id != 1 && Auth::guard('admin')->user()->id != $data->id && $data->level == 1)
                       disabled="disabled"
                        @endif
                        />
            </div>
            <div class="form-group">
                <label>RePassword</label>
                <input type="password" class="form-control" name="txtRePass" placeholder="Please Enter RePassword"
                @if (Auth::guard('admin')->user()->id != 1 && Auth::guard('admin')->user()->id != $data->id && $data->level == 1)
                       disabled="disabled"
                        @endif/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="txtEmail" placeholder="Please Enter Email"
                @if (Auth::guard('admin')->user()->id != 1 && Auth::guard('admin')->user()->id != $data->id && $data->level == 1)
                       disabled="disabled"
                       @endif
                       value="{!! old('txtEmail', isset($data) ? $data->email : null) !!}"/>
            </div>
            <div class="form-group">
                <label>User Level</label>
                <label class="radio-inline">
                    <input name="rdoLevel" value="1" type="radio"
                    @if($data->level == 1)
                           checked="checked"
                            @endif
                    @if (Auth::guard('admin')->user()->id != 1 && Auth::guard('admin')->user()->id != $data->id && $data->level == 1)
                           disabled="disabled"
                            @endif
                            >Admin
                </label>
                <label class="radio-inline">
                    <input name="rdoLevel" value="2" type="radio"
                    @if($data->level == 2)
                           checked="checked"
                            @endif
                    @if (Auth::guard('admin')->user()->id != 1 && Auth::guard('admin')->user()->id != $data->id && $data->level == 1)
                           disabled="disabled"
                            @endif
                            >Member
                </label>
            </div>
            <button type="submit" class="btn btn-default">User Edit</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <form>
    </div>

@stop
