@extends('admin.master')
@section('controller','User')
@section('action','Add')
@section('content')
    <div class="col-lg-7" style="padding-bottom:120px">
        <!-- include('admin.blocks.errors') -->
        <form action="{!! route('admin.user.postAdd') !!}" method="POST" id="_myform">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

            <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="txtUser" placeholder="Please Enter Username"
                       value="{!! old('txtUser') !!}"/>
					   @if ($errors->has('txtUser'))
							<span class="help-block">
								<strong>{{ $errors->first('txtUser') }}</strong>
							</span>
						@endif
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="txtPass" placeholder="Please Enter Password"/>
				@if ($errors->has('txtPass'))
					<span class="help-block">
						<strong>{{ $errors->first('txtPass') }}</strong>
					</span>
				@endif
			</div>
            <div class="form-group">
                <label>RePassword</label>
                <input type="password" class="form-control" name="txtRePass" placeholder="Please Enter RePassword"/>
				@if ($errors->has('txtRePass'))
					<span class="help-block">
						<strong>{{ $errors->first('txtRePass') }}</strong>
					</span>
				@endif
			</div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="txtEmail" placeholder="Please Enter Email"
                       value="{!! old('txtEmail') !!}"/>
					@if ($errors->has('txtEmail'))
						<span class="help-block">
							<strong>{{ $errors->first('txtEmail') }}</strong>
						</span>
					@endif
            </div>
            <div class="form-group">
                <label>User Level</label>
                <label class="radio-inline">
                    <input name="rdoLevel" value="1" type="radio">Admin
                </label>
                <label class="radio-inline">
                    <input name="rdoLevel" value="2" checked="checked" type="radio">Member
                </label>
            </div>
            <button type="submit" class="btn btn-default">User Add</button>
            <button type="reset" class="btn btn-default">Reset</button>
            <form>
    </div>
	<script type="text/javascript">
		$(function () {
	$('#_myform').validate({
		rules: {
			txtUser: "required",
			txtPass: {
				required : true,
			},
			txtEmail: {
				required: true,
				email: true
			},
			txtRePass: {
				required: true,
			},
		},

		// Specify the validation error messages
		messages: {
			txtUser: "Username là trường bắt buộc",
			// lastname: "Please enter your last name",
			txtPass: {
				required: "Password là trường bắt buộc",
				minlength: "Password nhiều hơn 5 kí tự"
			},
			txtRePass: "Nhập lại trường Re-password",
			txtEmail: "Nhập địa chỉ Email",
			// agree: "Please accept our policy"
		},
		
		highlight: function (element) {
			$(element).closest('.form-control').removeClass('success').addClass('error');
		},
		success: function (element) {
			element.text().addClass('valid')
				.closest('.form-control').removeClass('error').addClass('success');
		},
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if(element.parent('.form-group').length) {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		}
		// submitHandler: function (form) {
		// 	form.submit();
		// }
	});
});


	</script>
@endsection
