@extends('admin.master')
@section('controller','User')
@section('action','List')
@section('content')
    @include('admin.blocks.errors')
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach($_user as $val)
                    <tr class="odd gradeX" align="center">
                        <td>{!! ++$i !!}</td>
                        <td>{!! $val->username !!}</td>
                        <td>
                            @if($val->id == \App\Models\AppModel::is_ADMIN && $val->level == \App\Models\AppModel::ACCESS_SUPERADMIN_ACTION)
                                {{\App\Models\AppModel::$statuses[$val->level]}}
                            @elseif($val->level == \App\Models\AppModel::ACCESS_ADMIN_ACTION)
                                {{\App\Models\AppModel::$statuses[$val->level]}}
                            @else
                                {{\App\Models\AppModel::$statuses[$val->level]}}
                            @endif
                        </td>
                        <td>Hiện</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a
                                    onclick="return xacnhanxoa('Bạn có chắc là xóa không!')"
                                    href="{!! URL::route('admin.user.getDelete', $val->id) !!}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a
                                    href="{!! URL::route('admin.user.getEdit', $val->id) !!}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop