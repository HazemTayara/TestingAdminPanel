<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Product extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    protected $fillable = [
        'uuid',
        'title',
        'description',
        'company_id',
        'status',
        'terms',
        'url'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class , 'company_id');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

   

}
