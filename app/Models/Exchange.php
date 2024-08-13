<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'receivables_discount',
        'savings_discount',
        'discount_date',
        'notes',
        'username'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
