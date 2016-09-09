<?php
namespace app\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// goi namespace requests
use App\Http\Requests\CateRequest;
// goi namespace mode cate
use App\Models\Cate;

class CateController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('admin');
    // }

    public function getAdd()
    {
        //$_parent = Cate::select('id','name','parent_id')->orderBy('id','DESC')->get()->toArray();
        $_parent = Cate::select('id', 'name', 'parent_id')
            ->get()
            ->toArray();

        return view('admin.cate.add', compact('_parent'));
    }

    public function getlist()
    {
        $data = cate::select('id', 'name', 'parent_id')->get()->toArray();
        $_fdata = category_list($data);

        return view('admin.cate.list', compact('_fdata'));
    }

    public function postAdd(CateRequest $request)
    {
        $cate = new Cate();
        $cate->name = $request->txtCateName;
        $cate->alias = changTitle($request->txtCateName);
        $cate->order = $request->txtOrder;
        $cate->parent_id = $request->slParent;
        $cate->keywords = $request->txtKeyWords;
        $cate->description = $request->txtDescription;
        $cate->save();

        return redirect()->route('admin.cate.getAdd')->with([
            'co_level' => 'success',
            'co_messages' => 'Đã thêm thành công bảng Category!'
        ]);
    }

    public function getDelete($id)
    {
        $check = Cate::where('parent_id', $id)->count();
        if ($check == 0) {
            $cateDelete = Cate::find($id);
            $cateDelete->delete($id);

            return redirect()->route('admin.cate.list')->with([
                'co_level' => 'success',
                'co_messages' => 'Đã xóa thành công!'
            ]);
        } else {
            echo "<script type='text/javascript'>
				alert('Xin lỗi, Bạn không thể xóa danh mục này!');
				window.location='" . route('admin.cate.list') . "';
			</script>";
        }
    }

    public function getEdit($id)
    {
        $_gdata = Cate::findOrFail($id);
        $_parent = Cate::select('id', 'name', 'parent_id')->get()->toArray();

        return view('admin.cate.edit', compact('_parent', '_gdata', 'id'));
    }

    public function postEdit(Request $_erequest, $_id)
    {
        $this->validate(
            $_erequest,
            ['txtCateName' => 'required'],
            ['txtCateName.required' => 'Vùi lòng nhập trường category']
        );
        $_cate = Cate::find($_id);
        $_cate->name = $_erequest->txtCateName;
        $_cate->alias = changTitle($_erequest->txtCateName);
        $_cate->order = $_erequest->txtOrder;
        $_cate->parent_id = $_erequest->slParent;
        $_cate->keywords = $_erequest->txtKeyWords;
        $_cate->description = $_erequest->txtDescription;
        $_cate->save();

        return redirect()->route('admin.cate.list')->with([
            'co_level' => 'success',
            'co_messages' => 'Đã sửa thành công!',
        ]);
    }
}
