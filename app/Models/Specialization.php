<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialization extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    protected $fillable = [
        'uuid',
        'title'
    ];
    public function companySpecialization()
    {
        return $this->hasMany(CompanySpecialization::class);
    }
    public function companies()
    {
        return $this->belongsToMany(Company::class, CompanySpecialization::class);
    }
}
