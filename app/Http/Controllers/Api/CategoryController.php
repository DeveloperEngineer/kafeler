<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Category;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use Illuminate\Validation\ValidationException;

    class CategoryController extends Controller
    {

        public function index()
        {
            return response()->json([
                'categories' => Category::where('user_id', Auth::id())->get()
            ]);
        }


        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if (!Auth::check()) {
                return response()->json(['message' => 'Yetkisiz işlem. Giriş yapmalısınız.'], 401);
            }

            $validatedData['user_id'] = Auth::id();

            $slug = Str::slug($validatedData['name']);

            if (Category::where('slug', $slug)->exists()) {
                throw ValidationException::withMessages([
                    'slug' => 'Bu kategori zaten kullanımda, lütfen farklı bir kategori adı girin.'
                ]);
            }

            $validatedData['slug'] = $slug;

            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->file('image')->store('categories', 'public');
            }

            Category::create($validatedData);

            return response()->json([
                'message' => 'Kategori başarıyla oluşturuldu.'
            ]);
        }

        public function show(Category $category)
        {
            return response()->json([
                'category' => $category->where('user_id', Auth::id())->first()
            ]);
        }


        public function update(Request $request, Category $category)
        {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);


            $slug = Str::slug($validateData['name']);

            if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                throw ValidationException::withMessages([
                    'slug' => 'Bu kategori zaten kullanımda, lütfen farklı bir kategori adı girin.'
                ]);
            }

            $validateData['slug'] = $slug;


            if ($request->hasFile('image')) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                $validateData['image'] = $request->file('image')->store('categories', 'public');
            } elseif ($request->filled('existing_image')) {
                $validateData['image'] = str_replace('/storage/', '', $request->existing_image);
            } else {
                unset($validateData['image']);
            }

            $category->update($validateData);

            return response()->json([
                'message' => 'Kategori başarıyla güncellendi.',
                'category' => $category
            ]);
        }


        public function destroy(Category $category)
        {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'message' => 'Kategori başarıyla silindi.'
            ]);
        }
    }
