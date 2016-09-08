<?php

use App\Cate;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', URL('/'));
});

// // Home > Dien dan
// Breadcrumbs::register('Dien Dan', function ($breadcrumbs) {
//     $breadcrumbs->parent('home');
//     $breadcrumbs->push('diendan', route('aaaaaaaaaa'));
// });

// Home > lien he
Breadcrumbs::register('lien-he', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('liên hệ', route('getlienhe'));
});

Breadcrumbs::register('cart', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Shopping Cart', route('getCart'));
});

// Home > Category
Breadcrumbs::register('_product', function ($breadcrumbs, $data, $data_cate) {
    try {
        // $data_category = [];
        // foreach ($data_cate as $key => $value) {
        //     $data_category[$value['alias']] = $value;
        // }

        $breadcrumbs->parent('home');
        //global $data;
        $tmpUrl = '/danh-muc';
        //$i = 0;
        foreach ($data as $key => $value) {
            $getName = DB::table('cates')->select('name')->where('alias', '=', $value)->first()->name;

            $name = Cate::where('alias', '=', $value)->firstOrFail()->name;

            //dd($getName->name);
            //echo $key.'=> '.$value.'=> '.$name.'<br>';
            // if ($i == 0) {
            //     $name = 'Thời trang nữ';
            // } elseif ($i == 1) {
            //     $name = $data_category[$value]['name'];
            //     $parentKey = $value;
            // } elseif ($i == 2) {
            //     foreach ($data_category[$parentKey]['count_product'] as $childValue) {
            //         if ($childValue['alias'] == $value) {
            //             $name = $childValue['name'];
            //         }
            //     }
            // }

            $breadcrumbs->push($name, url($tmpUrl, $value));
            $tmpUrl = $tmpUrl . '/' . $value;
            // ++$i;
        }
    } catch (ModelNotFoundException $e) {
        die('sdjkdsldklsd');
    }

});

// // Home > Category > [products]
// Breadcrumbs::register('category', function ($breadcrumbs, $category) {
//     $breadcrumbs->parent('blog');
//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

// // Home > Category > [products] > [Page]
// Breadcrumbs::register('page', function ($breadcrumbs, $page) {
//     $breadcrumbs->parent('category', $page->category);
//     $breadcrumbs->push($page->title, route('page', $page->id));
// });
// Home > Category > [products] > [sections]
Breadcrumbs::register('_detail', function ($breadcrumbs, $breadcrumb_detail) {
    $breadcrumb = array_reverse(array_keys($breadcrumb_detail['breadcrumb_product']));

    $bcrum_product = array_reverse($breadcrumb);

    $breadcrumbs->parent('_product', $breadcrumb, $bcrum_product);

    $breadcrumbs->push(ucwords($breadcrumb_detail['name']), route($breadcrumb_detail['as'], [$breadcrumb_detail['alias'], $breadcrumb_detail['id']]));

});
// // Home > Category > [products] > [sections] > [page]
// Breadcrumbs::register('page', function ($breadcrumbs, $page) {
//     $breadcrumbs->parent('category', $page->category);
//     $breadcrumbs->push($page->title, route('page', $page->id));
// });
