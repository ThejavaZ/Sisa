<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'level',
        'department_id',
        'description',
        'salary',
        'created_by',
        'updated_by',
        'cancel_by',
        'deleted_by',
        'active',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
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
