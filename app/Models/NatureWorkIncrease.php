<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureWorkIncrease extends Model
{
    use HasFactory;
    protected $table = 'nature_work_increases';

    public $timestamps = false;
    protected $fillable = ['nature_work', 'scientific_qualification','percentage'];
}
