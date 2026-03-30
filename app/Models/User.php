<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'facebook_id',
        'password',
        'phone',
        'avatar_path',
        'address',
        'city',
        'zip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profileAvatarUrl(): ?string
    {
        if (empty($this->avatar_path)) {
            return null;
        }

        // Use a root-relative URL so it works regardless of APP_URL port
        // (e.g. `php artisan serve` on :8000).
        return '/storage/' . ltrim((string) $this->avatar_path, '/');
    }

    public function hasCompleteShippingProfile(): bool
    {
        return filled(trim((string) $this->address))
            && filled(trim((string) $this->city))
            && filled(trim((string) $this->zip));
    }
}
