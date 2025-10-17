<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class so extends Model
{
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'cancel_by',
        'deleted_by',
        'active',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'cancel_at'  => 'datetime',
    ];

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
