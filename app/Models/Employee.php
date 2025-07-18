<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Position;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'first_lastname',
        'seccond_lastname',
        'street',
        'interior_number',
        'exterior_number',
        'colony',
        'zip_code',
        'email',
        'phone',
        'employee_number',
        'hire_date',
        'birth_date',
        'gender',
        'RFC',
        'curp',
        'NSS',
        'branch_id',
        'emergency_contact',
        'position_id',
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

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
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
