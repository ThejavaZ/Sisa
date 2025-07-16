<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'password',
        'role', // User role, default is 2 (user)
        'languaje', // Language preference, default is 1 (Spanish)
        'created_by',
        'updated_by',
        'cancel_by',
        'deleted_by',
        'active', // Active status, default is 'S'
        'status', // Status, default is 1 (active)
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

    public function created_user()
    {
        return $this->belongsTo( User::class, 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo( User::class, 'updated_by');
    }

    public function cancel_user()
    {
        return $this->belongsTo( User::class, 'cancel_by');
    }

    public function deleted_user()
    {
        return $this->belongsTo( User::class, 'deleted_by');
    }
}
