<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySpecialization extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'specialization_id'
    ];
    protected $table = 'company_specializations';
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    public function specilazation()
    {
        return $this->belongsTo(Specialization::class,'specialization_id');
    }
}
