<?php

namespace App\Http\Controllers;

use App\Product;
use Input;

class SearchController extends Controller
{
    public function getSearch()
    {
        $keyword = Input::get('k', '');
        //$replacement = '<mark>'.$keyword.'</mark>';
        $data_search = Product::where('name', 'LIKE', '%'.$keyword.'%')->orwhere('price', 'LIKE', '%'.$keyword.'%')->paginate(4);
        // if (count($data_search)) {
        //     foreach ($data_search as $key => $value) {
        //         $data_search[$key]->name = preg_replace('/'.$keyword.'/', $replacement, $value->name);
        //     }
        // }
        //dd($data_search[0]->name);

        // str_replace

        return \View('user.pages.search')->with(['data_search' => $data_search, 'keyword' => $keyword]);
    }
}
