<?php

namespace app\Http\Requests;

use App\Http\Requests\Request;

class EditProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'slParent'	=>	'required',
            'txtName' => 'required:products,name',
            'fImages' => 'image',
        ];
    }

    public function messages()
    {
        return [
            //'slParent.required'		=>	'Vùi lòng chọn danh mục Category',
            'txtName.required' => 'Vùi lòng nhập tên cho Product',
            //'txtName.unique'		=>	'Product đã tồn tại',
            //'fImages.required'		=>	'Vùi lòng chọn ảnh',
            'fImages.image' => 'Đây không phải là hình ảnh!',
        ];
    }
}
