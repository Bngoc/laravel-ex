<!--
/ Viet them delete multi
/
/
-->

@extends('admin.master')
@section('controller','Product')
@section('action','List')
@section('content')
<div class="col-12 col-sm-12 col-lg-12">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <tr align="center">
                <th>#</th>
                <th>Name</th>
                <th>Price <em>VNĐ</em></th>
                <th>Sales</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Date Created</th>
                <th>Date Updated</th>
                <th>Category</th>
                <th>Delete <input type="checkbox" name="master_box" title="Check All" onclick="check_uncheck_all('selected_news[]')"></th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0; ?>
            @foreach($_data as $val)
                <tr class="odd gradeX" align="center">
                    <td>{!! ++$i !!}</td>
                    <td class="text-justify"><i class="fa fa-pencil fa-fw"></i> <a href="{!! URL::route('admin.product.getEdit', $val['id']) !!}">{!! $val['name'] !!}</a></td>
                    <td>{!! number_format($val['price'],0,",",".") !!}</td>
                    <td>{!! $val['discount'] !!}<em>%</em></td>
                    <td>
                    @if($val['icon'])
                        {!! $val['icon'] !!}
                    @else
                           null
                    @endif
                    </td>
                    <td>Hiện</td>
                    <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($val['created_at']))->diffForHumans() !!}</td>
                    <td>{!! \Carbon\Carbon::createFromTimeStamp(strtotime($val['updated_at']))->diffForHumans() !!}</td>
                    <td>
                        <?php //$cate = App\Cate::findorFail($val['cate_id']);
                        $cate = DB::table('cates')->where('id', $val['cate_id'])->first();  ?>
                        @if($cate)
                            {!! $cate->name !!}
                        @else
                            --
                        @endif
                    </td>
                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a
                                onclick="return xacnhanxoa('Bạn có chắc là xóa không!')"
                                href="{!! URL::route('admin.product.getDelete', $val['id']) !!}"> Delete</a><input type="checkbox" name="selected_news[]"></td>
                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! URL::route('admin.product.getEdit', $val['id']) !!}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop