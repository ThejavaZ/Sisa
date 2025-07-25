<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'manager_id',
        'address',
        'phone',
        'status',
    ];

    /**
     * Get the employee associated with the branch.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class , 'manager_id');
    }
}
