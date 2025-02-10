<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('categories')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function productsByCategory(Category $category)
    {
        return response()->json([
            'category' => $category->load('products')
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ], [
            'categories.required' => 'Kategori Seçiniz.',
            'categories.*.exists' => 'Seçtiğiniz kategorilerden biri bulunamadı.',
            'name.required' => 'Ad alanı zorunludur.',
            'name.string' => 'Ad yalnızca metin içerebilir.',
            'name.max' => 'Ad en fazla 255 karakter olabilir.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat yalnızca sayısal değer içerebilir.',
            'image.image' => 'Hatalı dosya türü. Lütfen jpg, jpeg veya png formatında bir resim yükleyin.',
            'image.mimes' => 'Resim yalnızca jpg, jpeg veya png formatında olabilir.',
            'image.max' => 'Resim boyutu en fazla 2MB olabilir.',
            'description.string' => 'Açıklama yalnızca metin içerebilir.',
        ]);


        $validatedData['slug'] = Str::slug($validatedData['name']);

        if (!isset($request->categories) || !is_array($request->categories)) {
            return response()->json(['message' => 'Kategoriler geçerli bir dizi değil.'], 400);
        }

        if ($request->hasFile('image')) {
            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validatedData);

        $product->categories()->sync($request->categories);


        return response()->json([
            'message' => 'Ürün başarıyla eklendi.',
            'product' => $product->load('categories')
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ], [
            'categories.required' => 'Kategori Seçiniz.',
            'categories.*.exists' => 'Seçtiğiniz kategorilerden biri bulunamadı.',
            'name.required' => 'Ad alanı zorunludur.',
            'name.string' => 'Ad yalnızca metin içerebilir.',
            'name.max' => 'Ad en fazla 255 karakter olabilir.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat yalnızca sayısal değer içerebilir.',
            'image.image' => 'Hatalı dosya türü. Lütfen jpg, jpeg veya png formatında bir resim yükleyin.',
            'image.mimes' => 'Resim yalnızca jpg, jpeg veya png formatında olabilir.',
            'image.max' => 'Resim boyutu en fazla 2MB olabilir.',
            'description.string' => 'Açıklama yalnızca metin içerebilir.',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $validatedData['image'] = $request->file('image')->store('products', 'public');
        } elseif (!$request->filled('existing_image')) {
            unset($validatedData['image']);
        }

        $product->update($validatedData);
        $product->categories()->sync($request->categories);

        return response()->json([
            'message' => 'Ürün başarıyla güncellendi.',
            'product' => $product->load('categories')
        ]);
    }


    public function destroy(Product $product)
    {
        $product->categories()->detach();

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'message' => 'Ürün başarıyla silindi.'
        ]);
    }
}
