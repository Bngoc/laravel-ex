<?php

use App\Models\Cate;
use Illuminate\Database\Eloquent\ModelNotFoundException;

setlocale(LC_ALL, 'en_US.UTF8');

function stripUnicode($str, $replace = array(), $delimiter = '-')
{
    if (!$str) {
        return false;
    }

    // con thieu :D
    $unicode = array(
        'a' => 'à|á|ả|ã|ạ|ă|ằ|ắ|ẳ|ẵ|ặ|â|ầ|ấ|ẩ|ẫ|ậ|ä|å|æ|À|Á|Ả|Ã|Ạ|Ă|Ằ|Ắ|Ẳ|Ẵ|Ặ|Â|Ầ|Ấ|Ẩ|Ẫ|Ậ',
        'd' => 'Đ|đ',
        'c' => 'ç',
        'e' => 'è|é|ẻ|ẽ|ẹ|ê|ề|ế|ể|ễ|ệ|ë|È|É|Ẻ|Ẽ|Ẹ|Ê|Ề|Ế|Ể|Ễ|Ệ|',
        'i' => 'ì|í|ỉ|ĩ|ị|î|ï|Ì|Í|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|ð|ö|ø|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|',
        'u' => 'ù|ú|ủ|ũ|ụ|ư|ừ|ứ|ử|ữ|ự|û|Ù|Ú|Ủ|Ũ|Ụ|Ư|Ừ|Ứ|Ữ|Ự|Ử|',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|ÿ|Ý|Ỳ|Ỷ|Ỹ|Ỵ|',
        'z' => 'ž',
        's' => 'š',
        //''  => '|\"|?|>|<|=|.|,|/|(|)|*|\'|^|@|!|{|}|-|;|:|%|[|]'
    );

    if (!empty($replace)) {
        $str = str_replace((array)$replace, ' ', $str);
    }
    foreach ($unicode as $khongdau => $codau) {
        $arr = explode('|', $codau);
        $str = str_replace($arr, $khongdau, $str);
    }
    $str = strtolower($str);
    $str = str_replace('|', '', $str);
    $str = str_replace(' ', '-', $str);

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $str = strtolower(trim($str, '-'));
    $str = preg_replace("/[\/_|+ -]+/", $delimiter, $str);

    return $str;
}

// convert name -> alias
function changTitle($str)
{
    $str = trim($str);
    if ($str == '') {
        return '';
    }
    $str = str_replace('"', '', $str);
    $str = str_replace("'", '', $str);
    $str = stripUnicode($str);
    $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
    //MB_CASE_LOWER | MB_CASE_TITLE | MB_CASE_UPPER
    //$str = str_replace('-', ' ', $str);

    return $str;
}

function checkalias($args, $alias_temple = '')
{
    global $is_check;
    try {
        foreach ($args as $key => $alias) {
            $_cate = Cate::where('alias', '=', trim($alias))->firstOrFail();
            if ($_cate->alias == $alias_temple) {
                if ($_cate->parent_id) {
                    $parent_id = Cate::findOrFail($_cate->parent_id);
                    checkalias($args, $parent_id->alias);
                } //else {
                //break;
                //}
            }
        }
    } catch (ModelNotFoundException $e) {
        return $is_check = false;

    }

    return $is_check = true;
}

// de quy tu id products -> ve cate
function proToCate($_cate, $key = 'id')
{
    try {
        global $list_raw;
        $_parent_id = $_cate->parent_id;

        $list_raw[$_cate->$key] = array(
            'id' => $_cate->id,
            'name' => $_cate->name,
            'alias' => $_cate->alias,
            'parent_id' => $_cate->parent_id,
        );

        if ($_parent_id) {
            $check = Cate::findOrFail($_parent_id);
            // $check = Cate::where('parent_id', $id)->get();

            if (count($check)) {
                proToCate($check, $key);
            }
        }

        return $list_raw;
    } catch (ModelNotFoundException $e) {
        return false;
    }
}

// de quy trong bang cates
function idCate($cate, $parent = 0, $list_id_ = null)
{
    global $list_id;
    if (empty($list_id_)) {
        $list_id = [];
    } else {
        $list_id = $list_id_;
    }

    foreach ($cate as $val) {
        $id = $val['id'];
        $_parent_id = $val['parent_id'];

        if ($_parent_id == $parent) {
            $check = Cate::where('parent_id', $id)->get();
            if (count($check) == 0) {
                $list_id[$val['id']] = array(
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'alias' => $val['alias'],
                    'parent_id' => $val['parent_id'],
                );
            } else {
                idCate($check, $id, $list_id);
            }
        }
    }

    return $list_id;
}

function callCate($data, $parent = 0, $str = '', $select = 0)
{
    foreach ($data as $val) {
        $id = $val['id'];
        $name = $val['name'];
        $_parent_id = $val['parent_id'];

        if ($_parent_id == $parent) {
            if (($select == $id) && ($select)) {
                echo "<option value='$id' selected='selected'>$str$name </option>";
            } else {
                echo "<option value='$id'>$str$name </option>";
            }

            callCate($data, $id, $str . '&ndash;&nbsp;', $select); //'- '
        }
    }
}

function callProduct($data, $parent = 0, $str = '', $select = 0)
{
    foreach ($data as $val) {
        $id = $val['id'];
        $name = $val['name'];
        $_parent_id = $val['parent_id'];

        if ($_parent_id == $parent) {
            if (($select == $id) && ($select)) {
                echo "<option value='$id' selected='selected'>$str$name </option>";
            } else {
                $check = Cate::where('parent_id', $id)->count();
                if ($check == 0) {
                    echo "<option value='$id'>$str$name </option>";
                } else {
                    echo "<option disabled='disabled' value='$id'>$str$name </option>";
                }
            }

            callProduct($data, $id, $str . '&ndash;&nbsp;', $select); //'- '
        }
    }
}

function category_list($data, $_parent = 0, $level = 0)
{
    global $list_items;
    foreach ($data as $cat) {
        if ((int)$cat['parent_id'] !== (int)$_parent) {
            continue;
        }
        $list_items[] = array(
            'name' => $cat['name'],
            'id' => $cat['id'],
            'parent_id' => $cat['parent_id'],
            'level' => $level,
        );
        category_list($data, $cat['id'], $level + 1);
    }

    return $list_items;
}
