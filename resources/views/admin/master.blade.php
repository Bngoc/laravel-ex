<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="----------------------------">
    <meta name="author" content="Vu Quoc Tuan">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="{!! url('/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{!! url('/admin/bower_components/metisMenu/dist/metisMenu.min.css') !!}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{!! url('/admin/dist/css/sb-admin-2.css') !!}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{!! url('/admin/bower_components/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet"
          type="text/css">

    <!-- DataTables CSS -->
    <link href="{!! url('/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') !!}"
          rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{!! url('admin/bower_components/datatables-responsive/css/dataTables.responsive.css') !!}"
          rel="stylesheet">

    <!--CKeditor $ CKfinder -->
    <script src="{!! url('/admin/js/ckeditor/ckeditor.js') !!}"></script>
    <script src="{!! url('/admin/js/ckfinder/ckfinder.js') !!}"></script>
    <script type="text/javascript">
        var baseURL = "{!! url('/') !!}";
    </script>
    <script src="{!! url('/admin/js/func_ckfinder.js') !!}"></script>
    <!-- En Ckeditor && CKfinder-->
    
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html"><?php echo $title; ?></a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
			<?php //$auth = Auth::guard('admin')->user();?>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">{!! auth()->guard('admin')->user()->username !!}
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{!! route('admin.user.getEdit', [auth()->guard('admin')->user()->id]) !!}"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <!-- C1: {!! url('admin/logout') !!} -->
                    <!-- C2:  Admin::logout() -->
                    <!-- C3: tao phuong thuc khac -->
                    <li><a href="{!! URL('admin/logout') !!}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Category<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!! url('admin/cate/list') !!}" class="click">List Category</a>
                            </li>
                            <li>
                                <a href="{!! url('admin/cate/add') !!}" class="click">Add Category</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-cube fa-fw"></i> Product<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!! route('admin.product.list') !!}">List Product</a>
                            </li>
                            <li>
                                <a href="{!! route('admin.product.getAdd') !!}">Add Product</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> User<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!! route('admin.user.list') !!}">List User</a>
                            </li>
                            <li>
                                <a href="{!! route('admin.user.getAdd') !!}">Add User</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> Must have<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{!! route('must.list') !!}">List Must Have</a>
                            </li>
                            <li>
                                <a href="{!! route('must.getAdd') !!}">Add Must Have</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('controller')
                        <small>@yield('action')</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-12">
                    @if(Session::has('co_messages'))
                        <div class="alert alert-{!! Session::get('co_level') !!}">
                            {!! Session::get('co_messages') !!}
                        </div>
                    @endif
                </div>
                <!-- Start Phan noi dung -->
                @yield('content')
                <!-- End Phan noi dung-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{!! url('/admin/bower_components/jquery/dist/jquery.min.js') !!}"></script>

<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{!! url('/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{!! url('/admin/bower_components/metisMenu/dist/metisMenu.min.js') !!}"></script>

<!-- Custom Theme JavaScript -->
<script src="{!! url('/admin/dist/js/sb-admin-2.js') !!}"></script>

<!-- DataTables JavaScript -->
<script src="{!! url('/admin/bower_components/datatables/media/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! url('/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}"></script>

<!-- Validator form (SAU JQUERY.JS -->
<!-- <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script> -->
<!-- <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script> -->
<!-- mysrcipt.js -->
<script src="{!! url('/admin/js/mysrcipt.js') !!}"></script>

</body>

</html>
