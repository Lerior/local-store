<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct (ProductStoreRequest $request) {

        $data = $request->validated();

    }
}
