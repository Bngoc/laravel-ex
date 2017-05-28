@extends('admin.master')
@section('controller','Must have')
@section('action','list')
@section('content')
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <!--<th>Status</th>-->
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @if($_fdata)
                    @foreach($_fdata as $val)
                        <tr class="odd gradeX" align="center">
                            <td>{!! ++$i !!}</td>
                            <td class="text-left"> <?php echo $val->name; ?> </td>
                            <td><img width="50" height="50"
                                     src="{!! asset('/upload/musthave/'. $val->path .'/'. $val->image) !!}"
                                     alt="{{$val->name}}" title="{{$val->name}}"></td>
                            <!--<td>Hiện</td>-->
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a
                                        onclick="return xacnhanxoa('Bạn có chắc là xóa không!')"
                                        href="{!! URL::route('must.getDel', $val->id) !!}"> Delete</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a
                                        href="{!! URL::route('must.getEdit', $val->id) !!}">Edit</a></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection