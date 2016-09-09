<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request; // dung ajax thi ko dung ma dung use Request;
use Request;
use App\Models\Cate;
use App\Models\Product;
use App\Models\User\ProductColor;
use App\Models\User\ProductSize;
use App\Models\User\ProductCount;
use App\Models\ProductImage;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\EditProductRequest;
use Input;
use File;
use DB;
use App\Models\User;


class ProductController extends Controller
{
    public function getAdd()
    {
        $_parent = Cate::select('id', 'name', 'parent_id')->get()->toArray();

        return view('admin.product.add', compact('_parent'));
    }

    public function postAdd(ProductRequest $p_request)
    {
        $alias = Cate::find($p_request->slParent);
        $ext_file = $p_request->file('fImages')->getClientOriginalExtension();
        $fname_image = $alias['alias'] . "-" . substr(md5(rand()), 0, 7) . "." . $ext_file;

         // goi model Product
        $product = new Product();
        $product->name = $p_request->txtName;
        $product->alias = changTitle($p_request->txtName);
        $product->price = $p_request->txtPrice;
        $product->intro = $p_request->txtIntro;
        $product->content = $p_request->txtContent;
        $product->image = $fname_image;
        $product->keywords = $p_request->txtKeywords;
        $product->description = $p_request->txtDescription;
        $product->user_id = User::admin()->id;
        $product->cate_id = $p_request->slParent;
        $product->src = $alias['alias'];
        $product->icon = $p_request->txtIcon;
        $product->discount = (int)($p_request->txtDiscount);
        $p_request->file('fImages')->move('public/upload/' . $alias['alias'], $fname_image);
        $product->save();

        $product_id = $product->id;
        if (Input::hasFile('fProductDetail')) {
            foreach (Input::file('fProductDetail') as $_file) {
                $product_img = new ProductImage();
                if (isset($_file)) {
                    // rename file images
                    $extension = $_file->getClientOriginalExtension();
                    $file_name = ($alias->alias) . "-" . substr(md5(rand()), 0, 7) . "." . $extension;
                    $product_img->image = $file_name;

                    //$product_img->image = $_file->getClientOriginalName();
                    $product_img->product_id = $product_id;
                    $_file->move('public/upload/detail/' . $alias['alias'], $file_name);
                    $product_img->save();
                }
            }
        }

        // insert to product color
        $arr_color = array();
        if (Input::has('color')) {
            foreach (Input::get('color') as $items) {
                $check = DB::table('product_colors')
                    ->where('namecolor', $items)
                    ->where('product_id', $product_id);

                $ischeck = $check->count();
                if (empty($ischeck)) {
                    $product_color = new ProductColor();
                    $product_color->namecolor = $items;
                    $product_color->product_id = $product_id;
                    $product_color->save();

                    $idcolor = $product_color->id;
                } else {
                    $idcolor = $check->first()->id;
                }
                $arr_color[] = $idcolor;
            }
        }

         // insert to product size
        $arr_size = array();
        if (Input::has('size')) {
            foreach (Input::get('size') as $items) {
                $checksize = DB::table('product_sizes')
                    ->where('namesize', $items)
                    ->where('product_id', $product_id);

                $ischecksize = $checksize->count();
                if (empty($ischecksize)) {
                    $product_size = new ProductSize();
                    $product_size->namesize = $items;
                    $product_size->product_id = $product_id;
                    $product_size->save();

                    $idsize = $product_size->id;
                } else {
                    $idsize = $checksize->first()->id;
                }
                $arr_size[] = $idsize;
            }
        }

        // insert to product soluong
        if (Input::has('size')) {
            foreach (Input::get('soluong') as $key => $val) {
                $check_sl = DB::table('product_counts')
                    ->where('color_id', $arr_color[$key])
                    ->where('size_id', $arr_size[$key])
                    ->where('product_id', $product_id);
                $ischeck_sl = $check_sl->count();
                if(empty($ischeck_sl)) {
                    $product_sl = new ProductCount();
                    $product_sl->color_id = $arr_color[$key];
                    $product_sl->size_id = $arr_size[$key];
                    $product_sl->product_id = $product_id;
                    $product_sl->soluong = $val;
                    $product_sl->save();
                }
            }
        }
        return redirect()
           ->route('admin.product.getAdd')
           ->with([
                    'co_level' => 'success',
                    'co_messages' => 'Đã thêm thành công vào bảng Product!'
                ]);
    }

    public function getList()
    {
        $_data = Product::select('id', 'name', 'price', 'cate_id', 'created_at', 'updated_at', 'discount', 'icon')
           ->orderBy('id', 'DESC')
           ->orderBy('price', 'DESC')
           ->orderBy('updated_at', 'DESC')
           ->get()
           ->toArray();

        return view('admin.product.list', compact('_data'));
    }

    public function getDelete($_id)
    {
        // ... lấy toàn bộ dư liệu của bảng product_image
        // với product_id = $_id
        // thông qua mối qua hệ 1-N ở Mode Product ...
        $product_detail = Product::find($_id)->pimage;
        $_product = Product::find($_id); // $_product là ojbect

        foreach ($product_detail as $value) {
            // ... xóa file ảnh (tên trong bảng Product_images) có trong đường dẫn ...
            File::delete('public/upload/detail/' . $_product->src .'/'. $value['image']);
        }
       
        File::delete('public/upload/' . $_product->src .'/'. $_product->image);
        // xóa file ảnh chính
        // xóa với $_id trong bảng Product và Cate_id=$_id
        // trong bảng Product_images với quan hệ 1-N (Model hasMany)
        $_product->delete($_id);

        return redirect()
            ->route('admin.product.list')
            ->with([
                    'co_level' => 'success',
                    'co_messages' => 'Đã xóa thành công trong bảng Product!'
                ]);
    }

    public function getEdit($id)
    {
        $_parent = Cate::select('id', 'name', 'alias', 'parent_id')->get()->toArray();
        $_product = Product::find($id);
        $img_product = ProductImage::select('id', 'image', 'product_id')->where('product_id', $id)->get();

        $c_s_c_product = DB::table('product_colors')
            ->select('product_colors.id as co_id', 'product_colors.namecolor', 'product_sizes.id as si_id', 'product_sizes.namesize', 'product_counts.id as sl_id', 'product_counts.soluong')
            ->leftJoin('product_counts', 'product_colors.id', '=', 'product_counts.color_id')
            ->leftJoin('product_sizes', 'product_sizes.id', '=', 'product_counts.size_id')
            ->where('product_counts.product_id', $id)
            ->whereNotNull('product_counts.soluong')
            ->get();
//        dd($c_s_c_product);
        return view('admin.product.edit', compact('_parent', '_product', 'img_product', 'c_s_c_product'));
    }

    //c1: Request::input('txtPrice');
    //c2: [Request $req] => $req::input('txtName');
    //c3: [EditProductRequest $req] => $req->txtName;
    /**
     * @param EditProductRequest $req
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(EditProductRequest $req, $id)
    {
        $product = Product::find($id);
        $img_current = 'public/upload/' . $product->src .'/'. $product->image;
        
        $product->name = $req->txtName;
        $product->alias = changTitle($req->txtName);
        $product->price = Request::input('txtPrice');
        $product->intro = Request::input('txtIntro');
        $product->content = Request::input('txtContent');
        $product->keywords = Request::input('txtKeywords');
        $product->description = Request::input('txtDescription');
        $product->user_id = User::admin()->id;
        $product->cate_id = Request::input('slParent');
        $product->icon = Request::input('txtIcon');
        $product->discount = (int)(Request::input('txtDiscount'));
        if (Request::file('fImages')) {
           //$file_name = Request::file('fImages')->getClientOriginalName();
            //ime images
            $ext_file = Request::file('fImages')->getClientOriginalExtension();
            $file_name = $product->src . "-" . substr(md5(rand()), 0, 7) . "." . $ext_file;

            $product->image = $file_name;
            Request::file('fImages')->move('public/upload/' . $product->src .'/', $file_name);
            if (File::exists($img_current)) {
                File::delete($img_current);
            }
        }
        $product->save();
        if (Request::File('fProductDetail')) {
            foreach (Request::File('fProductDetail') as $val) {
                $product_img = new ProductImage();
                if (isset($val) && $val) {
                    // rename file images
                    $extension = $val->getClientOriginalExtension();
                    $file_images = $product->src . "-" . substr(md5(rand()), 0, 7) . "." . $extension;

                    $product_img->image = $file_images;
                    //$product_img->image = $val->getClientOriginalName();
                    $product_img->product_id = $id;
                    $val->move('public/upload/detail/' . $product->src . '/', $file_images);
                    $product_img->save();
                }
            }
        }
        // insert to product color
        $arr_color = array();
        if (Input::has('color')) {
            foreach (Input::get('color') as $items) {
                $check = DB::table('product_colors')
                    ->where('namecolor', $items)
                    ->where('product_id', $id);

                $ischeck = $check->count();
                if (empty($ischeck)) {
                    $product_color = new ProductColor();
                    $product_color->namecolor = $items;
                    $product_color->product_id = $id;
                    $product_color->save();

                    $idcolor = $product_color->id;
                } else {
                    $idcolor = $check->first()->id;
                }
                $arr_color[] = $idcolor;
            }
        }
        //edit to product color
        if (Input::has('colorold')) {

            foreach (Input::get('colorold') as $key => $val) {
                DB::table('Product_colors')
                    ->where('id', $key)
                    ->update(['namecolor' => $val]);
            }
        }

        // insert to product size
        $arr_size = array();
        if (Input::has('size')) {
            foreach (Input::get('size') as $items) {
                $checksize = DB::table('product_sizes')
                    ->where('namesize', $items)
                    ->where('product_id', $id);

                $ischecksize = $checksize->count();
                if (empty($ischecksize)) {
                    $product_size = new ProductSize();
                    $product_size->namesize = $items;
                    $product_size->product_id = $id;
                    $product_size->save();

                    $idsize = $product_size->id;
                } else {
                    $idsize = $checksize->first()->id;
                }
                $arr_size[] = $idsize;
            }
        }
        // edit to product size
        if (Input::has('sizeold')) {
            foreach (Input::get('sizeold') as $key => $val) {
                $product_s = ProductSize::find($key);
                $product_s->namesize = $val;
                $product_s->save();
            }
        }

        // insert to product soluong
        if (Input::has('size')) {
            foreach (Input::get('soluong') as $key => $val) {
                $check_sl = DB::table('product_counts')
                    ->where('color_id', $arr_color[$key])
                    ->where('size_id', $arr_size[$key])
                    ->where('product_id', $id);
                $ischeck_sl = $check_sl->count();
                if(empty($ischeck_sl)) {
                    $product_sl = new ProductCount();
                    $product_sl->color_id = $arr_color[$key];
                    $product_sl->size_id = $arr_size[$key];
                    $product_sl->product_id = $id;
                    $product_sl->soluong = $val;
                    $product_sl->save();
                }
            }
        }
        // edit to product so luong
        if (Input::has('soluongold')) {
            foreach (Input::get('soluongold') as $key => $val) {
                $product_sl = ProductCount::find($key);
                $product_sl->soluong = $val;
                $product_sl->save();
            }
        }
        return redirect()
            ->route('admin.product.list')
            ->with([
                    'co_level' => 'success',
                    'co_messages' => 'Đã cập thành công trong bảng Product!'
                ]);

    }

    public function getDelImg($id)
    {
        if (Request::ajax()) {
            $idHinh = (int)Request::get('idHinh');
            $img_detail = ProductImage::find($idHinh);
            $product = Product::findOrFail($img_detail->product_id);

            if ($img_detail) {
                $img = 'public/upload/detail/' . $product->src . '/' . $img_detail->image;
                if (File::exists($img)) {
                    File::delete($img);
                    $img_detail->delete();
                }

                return 'Oke';
            }
        }
    }
}
