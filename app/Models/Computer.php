<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $fillable =[
        'name',
        'serial_number',
        'brand_id',
        'model',
        'description',
        'specify',
        'os',
        'purchase_date',
        'warranty_until',
        'branch_id',
        'created_by',
        'updated_by',
        'cancel_by',
        'deleted_by',
        'active',
        "status",
        "created_at",
        "updated_at"
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'cancel_at'  => 'datetime',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
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
