<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class WebController extends Controller
{
    public function index()
    {
        $cafes = User::all();
        return view('home' , compact('cafes'));
    }

    public function show($username)
    {
        $cafe = User::where('username', $username)->firstOrFail();
        $cafe->load('categories');
        return view('web.cafe', compact('cafe'));
    }

    public function categoryShow(User $cafe, Category $category)
    {
        $category->load('products');

        return view('web.category', compact('cafe', 'category'));
    }

    public function productShow(User $cafe, Category $category, Product $product)
    {
        return view('web.product', compact('cafe', 'category', 'product'));
    }

}
