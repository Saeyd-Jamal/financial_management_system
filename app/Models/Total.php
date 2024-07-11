<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Total extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];


    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
