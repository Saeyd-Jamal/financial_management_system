<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'employee_id',
        'date_of_birth',
        'age',
        'gender',
        'matrimonial_status',
        'number_wives',
        'number_children',
        'number_university_children',
        'scientific_qualification',
        'specialization',
        'university',
        'area',
        'address',
        'email',
        'phone_number',
    ];

    protected static function booted()
    {

    }

    // Relationships
    public function banks() :BelongsToMany
    {
        return $this->belongsToMany(
            Bank::class,     // Related Model
            'banks_employees',  // Pivot table name
        )->as('bank_employee')->withPivot(['account_number','default']);
    }
    public function workData() :HasOne
    {
        return $this->hasOne(workData::class);
    }
    public function totals() :HasOne
    {
        return $this->hasOne(Total::class);
    }
    public function fixedEntries() :HasMany
    {
        return $this->hasMany(FixedEntries::class,'employee_id');
    }
    public function salary() :HasMany
    {
        return $this->hasMany(Salary::class,'employee_id');
    }

    // rolue
    public static function rules($id = 0){
        return  [
            // 'employee_id' => [
            //     'required',
            //     'string',
            //     "unique:employees,employee_id,$id,employee_id"
            //     // Rule::unique('employees', 'id')->ignore($id),
            // ],
        ];
    }
    public static function messages(){
        return  [
            'required' => 'هذا الحقل مطلوب',
        ];
    }
}
