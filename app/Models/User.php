<?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\Authenticatable;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Model implements Authenticatable
    {
        use HasApiTokens, HasFactory, AuthenticatableTrait;

        protected $fillable = [
            'name',
            'lastname',
            'username',
            'email',
            'password',
            'email_verified_at'
        ];

        protected $hidden = [
            'password', 'remember_token',
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
