<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{



    public function authorize()
    {
        return true;
    }



    public function rules()
    {
            $rules = [
                'name' => ['required', 'string'],
                'description' => ['required', 'string'],
                'stock' => ['required', 'numeric'],
                'price' => ['required', 'numeric'],
                'category_id' => ['required', 'exists:categories,id'],
            ];

            if ($this->method() == 'POST'){
                array_push($rules['name'], 'required');
                array_push($rules['description'], 'required');
                array_push($rules['stock'], 'required');
                array_push($rules['price'], 'required');
                array_push($rules['category_id'], 'required');
            }else {
                array_push($rules['name'], 'required');
                array_push($rules['description'], 'required');
                array_push($rules['stock'], 'required');
                array_push($rules['price'], 'required');
                array_push($rules['category_id'], 'required');
            }

            return $rules;
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.string' => 'El nombre debe de ser valido',
            'description.required' => 'La descripcion es requerida',
            'description.string' => 'La descripcion debe de ser valida',
            'stock.required' => 'La cantidad es requerida',
            'stock.numeric' => 'La cantidad debe de ser un numero valido',
            'category_id.required' => 'La categoria es requerida',
            'category_id.exists' => 'La categoria no existe',
        ];
    }
}
