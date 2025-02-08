<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class User extends Model
    {
        use HasFactory;

        protected $fillable = [
            'name',
            'lastname',
            'username',
            'email',
            'password',
        ];

        protected $hidden = [
            'password'
        ];

        protected $casts = [
            'passwoed' => 'hashed',
            'email_verified_at' => 'datetime',
        ];

        public function categories(): HasMany
        {
            return $this->hasMany(Category::class);
        }

    }
