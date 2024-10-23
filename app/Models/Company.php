<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Company extends Model
{

    use HasApiTokens, HasFactory, SoftDeletes, Uuid;

    protected $fillable = [
        'uuid',
        'name',
        'phone',
        'email',
        'password',
        'logo',
        'type',
        'description',
        'domain',
        'employess_count'
    ];
    public function companySpecialization()
    {
        return $this->hasMany(CompanySpecialization::class);
    }
    public function specializations()
    {
        return $this->belongsToMany(Specialization::class, CompanySpecialization::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function reports()
    {
        return $this->hasManyThrough(Report::class, Product::class);
    }
}
