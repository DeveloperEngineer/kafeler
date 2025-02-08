# Kafelere Ozel Menu Sistemi - Yol Haritasi

## 1. Proje Kurulumu ve Temel Yapilandirma
- Laravel 11 projesi olusturuldu:
  ```sh
  laravel new kafeler
  cd kafeler
  ```
- Vue 3 eklendi ve gerekli paketler yuklendi:
  ```sh
  npm install
  npm install vue@latest vue-router@latest pinia axios
  ```
- Tailwind CSS entegre edildi:
  ```sh
  npm install -D tailwindcss postcss autoprefixer
  npx tailwindcss init -p
  ```
  Tailwind `tailwind.config.js` dosyasi duzenlendi:
  ```js
  export default {
      content: [
          "./resources/**/*.blade.php",
          "./resources/**/*.js",
          "./resources/**/*.vue",
      ],
      theme: {
          extend: {},
      },
      plugins: [],
  };
  ```

## 2. Kullanici Islemleri (CRUD)
- `User` modeli Laravel'in default modeli silinerek bastan olusturuldu:
  ```sh
  rm app/Models/User.php
  rm database/migrations/2014_10_12_000000_create_users_table.php
  php artisan make:model User -m
  ```
- Kullanici migration dosyasi `database/migrations/YYYY_MM_DD_create_users_table.php` icerisine eklendi:
  ```php
  public function up()
  {
      Schema::create('users', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('lastname');
          $table->string('username')->unique();
          $table->string('email')->unique();
          $table->string('password');
          $table->timestamps();
      });
  }
  ```
  ```sh
  php artisan migrate
  ```
- `UserController` olusturuldu ve API tabanli CRUD islemleri eklendi:
  ```sh
  php artisan make:controller Api/UserController --api
  ```
- Kullanici API rotalari `routes/api.php` icerisine eklendi:
  ```php
  use App\Http\Controllers\Api\UserController;
  Route::apiResource('/users', UserController::class);
  ```
- Kullanici CRUD islemleri Postman ile test edildi.

## 3. Kategori Islemleri (CRUD)
- `Category` modeli olusturulacak.
  ```sh
  php artisan make:model Category -m
  ```
- `categories` tablosu icin migration dosyasi olusturulacak:
  ```php
  public function up()
  {
      Schema::create('categories', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->string('name');
          $table->string('slug')->unique();
          $table->timestamps();
      });
  }
  ```
  ```sh
  php artisan migrate
  ```
- `CategoryController` olusturulacak ve CRUD islemleri eklenecek.
  ```sh
  php artisan make:controller Api/CategoryController --api
  ```
- `routes/api.php` icerisine `Category` CRUD islemleri icin API rotalari eklenecek.
  ```php
  use App\Http\Controllers\Api\CategoryController;
  Route::apiResource('/categories', CategoryController::class);
  ```
- Kullanici sadece **kendi kategorilerini** yönetebilecek.
- Postman ile kategori ekleme, listeleme, güncelleme ve silme test edilecek.

## 4. Urun Islemleri (CRUD) ve Çoktan Çoğa Kategori İlişkisi
- `Product` modeli olusturulacak.
  ```sh
  php artisan make:model Product -m
  ```
- `products` tablosu icin migration dosyasi olusturulacak:
  ```php
  public function up()
  {
      Schema::create('products', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('slug')->unique();
          $table->decimal('price', 8, 2);
          $table->string('image')->nullable();
          $table->text('description')->nullable();
          $table->timestamps();
      });
  }
  ```
  ```sh
  php artisan migrate
  ```
- `ProductController` olusturulacak ve CRUD islemleri eklenecek.
  ```sh
  php artisan make:controller Api/ProductController --api
  ```
- **Ürünler birden fazla kategoriye ait olabilir**. Bunun için **ara tablo** oluşturulacak:
  ```sh
  php artisan make:migration create_category_product_table --create=category_product
  ```
  ```php
  public function up()
  {
      Schema::create('category_product', function (Blueprint $table) {
          $table->id();
          $table->foreignId('category_id')->constrained()->onDelete('cascade');
          $table->foreignId('product_id')->constrained()->onDelete('cascade');
          $table->timestamps();
      });
  }
  ```
  ```sh
  php artisan migrate
  ```
- **Model ilişkileri tanımlanacak:**
    - `Product` modeline:
      ```php
      public function categories()
      {
          return $this->belongsToMany(Category::class, 'category_product');
      }
      ```
    - `Category` modeline:
      ```php
      public function products()
      {
          return $this->belongsToMany(Product::class, 'category_product');
      }
      ```
- `routes/api.php` icerisine `Product` CRUD islemleri icin API rotalari eklenecek.
  ```php
  use App\Http\Controllers\Api\ProductController;
  Route::apiResource('/products', ProductController::class)->except(['index', 'show']);
  Route::get('/categories/{category}', [ProductController::class, 'productsByCategory']);
  ```
- Kullanici sadece **kendi kategorilerine** bağlı ürünleri ekleyebilecek.
- Başka bir kullanıcıya ait kategoriye ürün eklemeye çalışırsa **403 Forbidden hatası** döndürülecek.
- Ürün silindiğinde **ilişkili kategoriler de temizlenecek** (`detach()`).
- Postman ile urun islemleri test edilecek.

## 5. On Yuz (Blade) ve Admin Paneli (Vue)
- Musteri tarafi Blade ile gelistirilecek.
- Admin paneli Vue.js ile olusturulacak.
- API entegrasyonu Vue tarafinda Axios ile saglanacak.
- Vue icinde Pinia kullanilarak state yonetimi saglanacak.
- Kullanici deneyimini iyilestirmek icin SweetAlert2 veya Vue-toastification eklenecek.

## 6. Son Dokunuslar ve Deployment
- Validation kontrolleri ve hata yonetimi tamamlanacak.
- Resim yukleme ve storage kullanimi eklenecek.
- Performans iyilestirmeleri yapilacak.
- Proje Canli ortama deploy edilecek.

Devam edilecek...

