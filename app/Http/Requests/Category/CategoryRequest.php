<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }
    

    public function rules()
    {
        $rules = [
            'name' => ['required', 'string'],
        ];

        if ($this->method() == 'POST'){
            array_push($rules['name'], 'unique:categories,name');
        }
        else{
            array_push($rules['name'], 'unique:categories,name,' .$this->category->id);
        }

        return $rules;
    }
}
