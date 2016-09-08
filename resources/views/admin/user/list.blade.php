@extends('admin.master')
@section('controller','User')
@section('action','List')
@section('content')
    @include('admin.blocks.errors')
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
                    @if($val->id ==1 && $val->level == 1)
                        SuperAdmin
                    @elseif($val->level == 1)
                        Admin
                    @else($val->)
                        Member
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
@stop