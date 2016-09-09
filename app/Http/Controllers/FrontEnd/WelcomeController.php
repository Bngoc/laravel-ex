<?php

namespace app\Http\Controllers\FrontEnd;

/// No query results for model check
use App\Http\Controllers\Controller;
use App\Models\Cate;
use App\Models\Product;
use DB, Mail, Redirect, Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Request;

class WelcomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        $featur_product = DB::table('products')
            ->select('id', 'name', 'image', 'price', 'alias', 'src', 'icon', 'discount')
            ->orderBy('id', 'DESC')
            ->skip(0)
            ->take(4)
            ->get();
        $last_product = DB::table('products')
            ->select('id', 'name', 'image', 'price', 'alias', 'src', 'icon', 'discount')
            ->orderBy('id', 'DESC')
            ->skip(1)
            ->take(4)
            ->get();

        $is_true = true;
        return view('user.pages.home', compact('featur_product', 'last_product', 'is_true'));
    }

    public function showproduct()
    {
        //dd(Route::getCurrentRoute()->getPath()); //3
        //dd(app()->router->getCurrentRoute());
        //dd(Route::current()->getPath());
        //print_r(Route::current()->parameters());
        //dd(Route::current()->getUri());
        //dd(Route::currentRouteName());

        //$args = func_get_args();
        $args = array_reverse(func_get_args());
        if (!checkalias($args, $args[0])) {
            //die("kiem tra False alias.......");
            //$message = 'Invalid parent_id.';
            echo  $message = "kiem tra False alias.......<br>";
//            return Redirect::to('errors.503')->with('message', $message);
            abort(404, 'oops! page not found');
        } else {
            if(count($args) > 1) {
//                $_cate = Cate::where('alias', '=', end($args))->firstOrFail();
                $_cate = Cate::where('alias', '=', $args[0])->firstOrFail();
                $menu = Cate::where('alias', '=', end($args))->firstOrFail();
            } else {
                $menu = $_cate = Cate::where('alias', '=', $args[0])->firstOrFail();
            }
        }

        $cate = Cate::where('parent_id', '=', $_cate->id)->get();
        $menucate = Cate::where('parent_id', '=', $menu->id)->get();
        //$dmuc = Cate::where('parent_id', '=', Cate::where('alias', '=', end($args))->firstOrFail()->id)->get();

        $datacate = idCate($menucate, $menu->id);

        if (empty(count($datacate))) {
            return response(view('errors.build'), 404);
//            abort(503, 'Service unavailable');
        }

        if (count($cate)) {
            $dataproduct = idCate($cate, $cate[0]->parent_id, null);
        }
        else {
            $dataproduct[$_cate->id] = array(
                                "id" => $_cate->id,
                                "name" => $_cate->name,
                                "alias" => $_cate->alias,
                                "parent_id" => $_cate->parent_id,

            );
        }

        //$data_product = DB::table('products')
        $data_product = Product::whereIn('cate_id', array_keys($dataproduct))
            ->orderBy('products.id', 'DESC')
            ->paginate(15);
            //->get();
        //dd($data_product);
        //$pro_count = $data_product->productsoluong;
        //dd($pro_count);

        $raw_pid = array_flip(array_column($datacate, 'parent_id'));
        foreach ($raw_pid as $key => $value) {
            if ($menu->id == $key) {
                unset($raw_pid[$key]);
            }
        }

        $raw_cate = DB::table('cates')
            ->whereIn('id', array_keys($raw_pid))
            ->get();


        $data_cate = array();
        foreach ($raw_cate as $k => $val) {
//        foreach ($dmuc as $k => $val) {
            $search_id = DB::table('cates')
                ->where('parent_id', $val->id)
                ->get();
            $count_product = array();
            $total = 0;
            foreach ($search_id as $key => $value) {
                $_count = Cate::findOrFail($value->id)->product->count();
                $count_product[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'alias' => $value->alias,
                    'count' => $_count,
                );
                $total += $_count;
            }
            $data_cate[] = array(
                'id' => $val->id,
                'name' => $val->name,
                'url' => end($args),
                'alias' => $val->alias,
                'total' => $total,
                'count_product' => $count_product,
            );
        }

        $musthave = DB::table('must_haves')
            ->take(4)
            ->get();

        $product_best = DB::table('products')->join('cates','cates.id','=','products.cate_id')
            ->select('products.id', 'price', 'products.name', 'image', 'discount', 'src', 'products.alias', 'cates.name as catename')
            -> whereIn('cates.id', array_keys($dataproduct))
//            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();
        $product_last = DB::table('products')->join('cates','cates.id','=','products.cate_id')
            ->select('products.id', 'price', 'products.name', 'image', 'discount', 'src', 'products.alias', 'cates.name as catename')
            -> whereIn('cates.id', array_keys($dataproduct))
            ->orderBy('products.id', 'DESC')
            ->take(3)
            ->get();

        $danhmuc = $_cate->name;

        return \View('user.pages.product', compact('data_product', 'data_cate', 'musthave', 'product_best', 'product_last', 'danhmuc'));
    }

    public function showdetail($alias, $id)
    {
        $args = func_get_args();
        try {
            $detail = Product::with('cate')->findOrFail($id);

            // $detail = Product::findOrFail($id);

            //$detail = Product::with('cate')->get()->toArray();


            $breadcrumb = proToCate($detail->cate, 'alias');

            // khong co san pham voi id uri
            if (!$breadcrumb) {
                // bao loi
            }
            //$breadcrumb = array_reverse(array_keys($_breadcrumb));
            //dd($breadcrumb);

            //$dataCate = $detail->cate;
            $image_detail = $detail->pimage;
            $color_detail = $detail->productcolor;
            $size_detail = $detail->productsize;
            $soluong_detail = $detail->productsoluong;

            $is_check = $soluong_detail->count();
            if ($is_check) {
                $first_default = $soluong_detail->first()->toArray();
                $default_c = $first_default['color_id'];
                $default_s = $first_default['size_id'];
                $default_sl = $first_default['soluong'];
            } else {
                $default_c = $default_s = $default_sl = '';
            }

            $product_cate = Product::where('cate_id', '=', $detail->cate_id)
                ->where('id', '<>', $id)
                ->take(4)
                ->get();

            $breadcrumb_detail = array(
                'id' => $detail->id,
                'name' => $detail->name,
                'alias' => $detail->alias,
                'as' => Route::currentRouteName(),
                'breadcrumb_product' => $breadcrumb,
            );

            return \View('user.pages.detail', compact(
                    'detail',
                    'image_detail',
                    'product_cate',
                    'breadcrumb_detail',
                    'color_detail',
                    'size_detail',
                    'soluong_detail',
                    'default_c',
                    'default_s',
                    'default_sl'
                    )
                );
        } catch (ModelNotFoundException $e) {
            die("loi.... delail page");
        }
    }

    public function getlienhe ()
    {
        return \View('user.pages.contact');
    }
    public function postlienhe (ContactRequest $request)
    {
//        $hoten = Request::input('name');
//        $data = array(
//            'hoten' => $hoten,
//            'email' => Request::input('email'),
//            'title' => Request::input('title'),
//            'messages' => Request::input('message'),
//        );
        $data = array(
            'hoten' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'messages' => $request->message,
        );
        Mail::send('emails.blanks', $data, function ($smg) use ($data){
            //$smg->from('ngoctbhy@gmail.com', 'admin');
            $smg->to($data['email'], $data['hoten'])->subject($data['title']);
        });
        if(Mail::failures()) {
            $info = 'danger';
            $success = 'Failed to send email, please try again.';
            return Redirect::route('getlienhe')
                ->with('co_level', $info)
                ->with('co_messages', $success);
        } else {
            $info = 'success';
            $success = 'Cám ơn bạn đã góp ý. Chúng tôi sẽ liên hệ sớm với bạn!';
            return Redirect::route('getlienhe')
                ->with('co_level', $info)
                ->with('co_messages', $success);
        }
    }
}
