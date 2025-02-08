<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Category;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use Illuminate\Validation\ValidationException;

    class CategoryController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            return response()->json([
                'categories' => Category::all()
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'name.required' => 'Ad alanı zorunludur.',
                'name.string' => 'Ad yalnızca metin içerebilir.',
                'name.max' => 'Ad en fazla 255 karakter olabilir.',

                'image.image' => 'Hatalı dosya türü. Lütfen jpg, jpeg veya png formatında bir resim yükleyin.',
                'image.mimes' => 'Resim yalnızca jpg, jpeg veya png formatında olabilir.',
                'image.max' => 'Resim boyutu en fazla 2MB olabilir.',
            ]);

            // Kullanıcı doğrulama -- canlıda etkinleştir.
//        if (!auth()->check()) {
//            return response()->json(['message' => 'Yetkisiz işlem. Giriş yapmalısınız.'], 401);
//        }
//        $validatedData['user_id'] = auth()->id();

            $validatedData['user_id'] = $request['user_id'];

            // Kategori adını slug'a çevir
            $slug = Str::slug($validatedData['name']);

            // Eğer slug zaten varsa, hata döndür
            if (Category::where('slug', $slug)->exists()) {
                throw ValidationException::withMessages([
                    'slug' => 'Bu kategori zaten kullanımda, lütfen farklı bir kategori adı girin.'
                ]);
            }

            $validatedData['slug'] = $slug;

            // Eğer resim varsa kaydet
            if ($request->hasFile('image')) {
                if (!Storage::disk('public')->exists('categories')) {
                    Storage::disk('public')->makeDirectory('categories');
                }
                $validatedData['image'] = $request->file('image')->store('categories', 'public'); // storage/app/public/categories/
            }

            Category::create($validatedData);

            return response()->json([
                'message' => 'Kategori başarıyla oluşturuldu.'
            ]);
        }

        /**
         * Display the specified resource.
         */
        public function show(Category $category)
        {
            return response()->json([
                'category' => $category
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Category $category)
        {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'name.required' => 'Ad alanı zorunludur.',
                'name.string' => 'Ad yalnızca metin içerebilir.',
                'name.max' => 'Ad en fazla 255 karakter olabilir.',

                'image.image' => 'Hatalı dosya türü. Lütfen jpg, jpeg veya png formatında bir resim yükleyin.',
                'image.mimes' => 'Resim yalnızca jpg, jpeg veya png formatında olabilir.',
                'image.max' => 'Resim boyutu en fazla 2MB olabilir.',
            ]);

            // Kategori adını slug'a çevir
            $slug = Str::slug($validateData['name']);

            // Eğer slug zaten varsa, hata döndür
            if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                throw ValidationException::withMessages([
                    'slug' => 'Bu kategori zaten kullanımda, lütfen farklı bir kategori adı girin.'
                ]);
            }

            $validateData['slug'] = $slug;

            // Eğer resim varsa kaydet
            if ($request->hasFile('image')) {
                // Eski resmi sil
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $path = $request->file('image')->store('categories', 'public'); // storage/app/public/categories/
                $validateData['image'] = $path;
            }

            $category->update($validateData);

            return response()->json([
                'message' => 'Kategori başarıyla güncellendi.',
                'category' => $category
            ]);
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Category $category)
        {
            // Eğer resim varsa sil
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'message' => 'Kategori başarıyla silindi.'
            ]);
        }
    }
