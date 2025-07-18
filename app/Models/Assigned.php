<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assigned extends Model
{
    protected $fillable = [
        'computer_id',
        'employee_id',
        'assigned_date',
        'returned_date',
        'notes',
        'assigned_by',
        'created_by',
        'updated_by',
        'cancel_by',
        'deleted_by',
        'active',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'cancel_at'  => 'datetime',
    ];

    public function computer()
    {
        return $this->belongsTo(\App\Models\Computer::class,  'computer_id');
    }

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'assigned_by');
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
