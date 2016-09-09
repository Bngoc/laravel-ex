<?php

namespace app\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Input;
use App\Models\MustHave;
use Validator;
use Illuminate\Support\Facades\Redirect;
use DB;

class MustHaveController extends Controller
{
    public function getAdd()
    {
        return \View('admin.musthave.add');
    }
    public function postAdd(Request $request)
    {
        $vali_name = Validator::make(
            $request->all(),
            // array(
            //     'txtMustHave' => $request->input('txtMustHave'),
            //     // 'fProductDetail' => Input::hasFile('fProductDetail'),
            //     //'fProductDetail' => Input::file('fProductDetail'),
            // ),
            array(
                'txtMustHave' => 'required|max:255',
                'fProductDetail.*' => 'required',
                //'fProductDetail.*' => 'required|mimes:jpg,jpeg,png,bmp,JPG|max:20000',
            ),
            array(
                'fProductDetail.*.required' => 'Please upload an image',
                //'fProductDetail.*.mimes' => 'Only jpeg,png and bmp images are allowed',
                //'fProductDetail.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            )
        );

        if ($vali_name->fails()) {
            return redirect::route('must.getAdd')
                        ->withErrors($vali_name)
                        ->withInput();
        }

 // dd($request->file('fProductDetail'));
        $_files = Input::file('fProductDetail');
        foreach ($_files as $key => $_file) {
            $_rule = array('fProductDetail' => 'required|max:2048|image');
            $_msg = array(
                'fProductDetail.required' => 'Please upload an image '. $key,
                'fProductDetail.image' => 'Only jpeg,png and bmp images are allowed',
                'fProductDetail.max' => 'Sorry! Maximum allowed size for an image is 2MB',
                );
            $validator = Validator::make(array('fProductDetail' => $_files[$key]), $_rule, $_msg);

            if ($validator->fails()) {
                return redirect::route('must.getAdd')
                            ->withErrors($validator)
                            ->withInput();
                break;
            }
        }
        
        if (Input::hasFile('fProductDetail')) {
            foreach (Input::file('fProductDetail') as $_file) {
                $must_img = new MustHave();
                if (isset($_file)) {
                    // rename file images
                    $extension = $_file->getClientOriginalExtension();
                    $file_name = substr(md5(rand()), 0, 7).'.'.$extension;

                    $name = Input::get('txtMustHave');
                    $must_img->name = $name;
                    $must_img->image = $file_name;
                    $must_img->user_id = User::admin()->id;
                    $must_img->path = changTitle($name);
// move_uploaded_file()

                    $_file->move('public/upload/musthave/'. changTitle($name) .'/', $file_name);
                    $must_img->save();
                }
            }
        }

        return redirect()
           ->route('must.getAdd')
           ->with([
                    'co_level' => 'success',
                    'co_messages' => 'Đã thêm thành công vào bảng Mush Have!',
                ]);
    }
    public function getDel()
    {
    }
    public function getEdit()
    {
    }
    public function postEdit()
    {
    }
    public function getlist()
    {
        $_fdata = DB::table('must_haves')
            ->select('id', 'name', 'image', 'path', 'created_at', 'updated_at')
            ->get();
        return \View('admin.musthave.list', compact('_fdata'));
    }
}
