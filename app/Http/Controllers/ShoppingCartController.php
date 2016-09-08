<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Product;
use App\User\ProductCount;
use App\User\ProductSize;
use App\User\ProductSoLuong;
use Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Input;
use Redirect;
use Request;

class ShoppingCartController extends Controller
{
    // xoa tat ca san pham
    public function getClearCart()
    {
        cart::destroy();
        $datacart = array();
        return view('user.pages.shopping', compact('datacart'));
    }

    // view shopping cart
    public function getCart()
    {
        $contentcart = Cart::content();

        $datacart = array();
        foreach ($contentcart as $rowid => $items) {
            $data_procount= ProductCount::with('soluong_color')
                ->with('soluong_size')
                //->with('soluong_product')
                ->select('color_id', 'size_id', 'soluong', 'product_id')
                ->where('product_id', $items['id'])
                ->get()
                ->toArray();
            $slmax = 1;
            $color_size = array();
            foreach ($data_procount as $key => $val) {
                $color_size[] = array(
                    'c_id' => $val['color_id'],
                    'namecolor' => $val['soluong_color']['namecolor'],
                    's_id' => $val['size_id'],
                    'namesize'  => $val['soluong_size']['namesize'],
                    'slmax' => $val['soluong'],
                );
                if ($items['options']['color'] == $val['color_id'] && $items['options']['size'] == $val['size_id']) {
                    $slmax = $val['soluong'];
                }
            }

            $datacart[$rowid] = array(
                'id' => $items['id'],
                'name' => $items['name'],
                'qty' => $items['qty'],
                'price' => $items['price'],
                'image' => $items['options']['image'],
                'src' => $items['options']['src'],
                'discount' => $items['options']['discount'],
                'alias' => $items['options']['alias'],
                'size_id' => $items['options']['size'],
                'color_id' => $items['options']['color'],
                'subtotal' => $items['subtotal'],
                'slmax' => $slmax,
                'dtcolorsize' => $color_size,
            );
        }

        // var_dump(Cart::tax());
//        var_dump(Cart::subtotal());
//        die();
        $total = Cart::total();
        return view('user.pages.shopping', compact('datacart', 'total'));
    }

    // add vao shopping cart
    public function postCart(Request $request)
    {
        try {
            if (Request::isMethod('POST')) {
                $product_id = (int)Request::get('product_id');
                if (Input::has('soluong')) {
                    $soluong = (int)Request::get('soluong') or 1;
                } else {
                    $soluong = 1;
                }
                if (Input::has('size_id')) {
                    $size = Request::get('size_id') or null;;
                } else {
                    $size = null;
                }
                if (Input::has('color_id')) {
                    $color = Request::get('color_id') or null;
                } else {
                    $color = null;
                }

                $product = Product::findOrFail(Request::get('product_id'));
                $product_count = $product->productsoluong->toArray();

                foreach ($product_count as $key => $al) {
                    if (empty($color) || empty($size)) {
                        $color = $al['color_id'];
                        $size = $al['size_id'];
                        $slmax = $al['soluong'];
                        break;
                    }
                    if ($al['color_id'] == $color && $al['size_id'] == $size) {
                        $slmax = $al['soluong'];
                        break;
                    }
                }

                if (empty($color) || empty($size) || empty($slmax)) {
                    return 'false';
                }


                $content_cart = Cart::content()->toArray();
                if (count($content_cart)) {
                    foreach ($content_cart as $key => $val) {
                        if ($val['id'] == $product_id && $val['options']['size'] == $size && $val['options']['color'] == $color) {
                            $cruent_qty = $val['qty'];
                            break;
                        }
                    }
                }
                if (isset($cruent_qty)) {
                    if ($cruent_qty >= $slmax) {
                        return "none";
                    } else {
                        $dtsl = $slmax - $cruent_qty;
                        if ($dtsl < $soluong) {
                            $soluong = $dtsl;
                        }
                    }
                }
                Cart::add(array(
                    'id' => $product_id,
                    'name' => $product->name,
                    'qty' => $soluong,
                    'price' => $product->price,
                    'options' => array(
                        'image' => $product->image,
                        'src' => $product->src,
                        'discount' => $product->discount,
                        'alias' => $product->alias,
                        'size' => $size,
                        'color' => $color,
                    )
                ));

                return "Oke";
            } else {
                return "false";
            }
        } catch (ModelNotFoundException $e) {
            return "false";
        }
    }

    // cap nhap lai shopping cart
    public function postEditCart(Request $request)
    {
        $result ['_url'] = URL('/cart');
        if (Request::isMethod('POST')) {
            if (Request::get('product_id') && Request::get('qty')) {
                $product_id = (int)Request::get('product_id');
                $qty = (int)Request::get('qty');
                $color_id = (int)Request::get('color_id');
                $size_id = (int)Request::get('size_id');
                $option = (String) Request::get('option');
                $rowId = Cart::search(array('id' => $product_id));
                //$is_fasle = false;
                $product_count = ProductCount::where('product_id', $product_id)
                    ->where('color_id', $color_id)
                    ->where('size_id', $size_id)
                    ->get()
                    ->toArray();
                $slmax = $product_count[0]['soluong'];
                if ($slmax < $qty) {
                    $qty = $slmax;
                };

                if ($option === 'qty') {
                    foreach ($rowId as  $key) {
                        $item = Cart::get($key);
                        // update so luong
                        if ($item['options']['color'] == $color_id && $item['options']['size'] == $size_id) {
                            if ($qty >= 1 && $item['qty'] != $qty) {
                                $is_fasle = true;
                                Cart::update($key, [$item['qty'] = $qty]);// $item['options']['color'] = $color_id, $item['options']['size'] = $size_id]);
                                $result ['_key'] = "Oke";
                                break;
                            }
                        }
                    }
                }
                // thay doi color size
                else {
                    $arr_temp = array();
                    $solg = 0;
                    foreach ($rowId as $key) {
                        $item = Cart::get($key);
                        // co ton tai san pham voi color_id size_is
                        if ($item['options']['color'] == $color_id && $item['options']['size'] == $size_id && $option != $key) {
                            $solg += $item['qty'];
                            $arr_temp[] = array(
                                'key' => $key,
                                'color_id' => $item['options']['color'],
                                'size_id' => $item['options']['size'],
                            );
                        } else {

                        }
                    }

                    if (count($arr_temp)) {
                        $tg = $solg + $qty;
                        if ($solg > $slmax || $tg > $slmax) {
                            $updatesl = $slmax;
                        } else {
                            $updatesl = $tg;
                        }
                        Cart::remove($option);
                        $_item = Cart::get($arr_temp[0]['key']);

                        Cart::update($arr_temp[0]['key'], $_item['qty'] = $updatesl);
                    } else {
                        $__item = Cart::get($option);
                        Cart::update($option, [$__item['qty'] = $qty, $__item['options']['color'] = $color_id, $__item['options']['size'] = $size_id]);
                    }
                }
                if (!isset($is_fasle)) {
                    $result ['_key'] = "Oke";
                }
            } else {
                $result ['_key'] = "fsp";
            }
        } else {
            $result ['_key'] = "fsp";
        }

        return $result;
    }

    // xoa san pham trong shopping cart
    public function getDelCart($id)
    {
        Cart::remove($id);

        return Redirect::route('getCart');
    }

    public function getCountPro()
    {
        try {
            if (Request::isMethod('POST')) {
                $color_id = (int)Request::get('color_id');
                $size_id = (int)Request::get('size_id');
                $countmax = ProductCount::select('soluong')
                    ->where('color_id', $color_id)
                    ->where('size_id', $size_id)
                    ->first();

                //'<input type="number" class="input-text qty text number" pattern="\d*" maxlength="3" title="Qty" size="4" value="1" name="quantity" id="soluong" min="1" step="1">';
                return $countmax;
            } else {
                return null;
            }
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}
