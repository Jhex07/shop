<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Product\ProductRequest;


class ProductUpdateRequest extends ProductRequest
{


    public function rules()
    {

        $this->rules['file'] = ['sometimes', 'image'];
        return $this->rules;
    }


}
