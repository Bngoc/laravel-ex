@extends('admin.master')
@section('controller','Category')
@section('action','list')
@section('content')
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category Parent</th>
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
                            <td class="text-left"> <?php echo str_repeat('&ndash;&nbsp;', $val['level']) . $val['name']; ?> </td>
                            <td>
                                @if(!$val["parent_id"])
                                    --
                                @else
                                    <?php $_data = DB::table('cates')->where('id', $val["parent_id"])->first();
                                    echo $_data->name;
                                    ?>
                                @endif
                            </td>
                            <!--<td>Hiện</td>-->
                            <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a
                                        onclick="return xacnhanxoa('Bạn có chắc là xóa không!')"
                                        href="{!! URL::route('admin.cate.getDelete', $val['id']) !!}"> Delete</a></td>
                            <td class="center"><i class="fa fa-pencil fa-fw"></i> <a
                                        href="{!! URL::route('admin.cate.getEdit', $val['id']) !!}">Edit</a></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div><!-- /.row -->
    </div>
@endsection