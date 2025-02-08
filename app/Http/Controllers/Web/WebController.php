<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cafes = User::all();
        return view('home' , compact('cafes'));
    }

    /**
     * Display the specified resource.
     */
    public function show($username)
    {
        $cafe = User::where('username', $username)->firstOrFail();
        $cafe->load('categories');
        return view('web.cafe', compact('cafe'));
    }

    public function categoryShow($username, $slug)
    {
        $cafe = User::where('username', $username)->firstOrFail();
        $category = $cafe->categories()->where('slug', $slug)->firstOrFail();
        $category->load('products');

//        return $category->products;

        return view('web.category', compact('cafe', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
