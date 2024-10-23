<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;


class Researcher extends Model
{
    use HasApiTokens,HasFactory,SoftDeletes,Uuid;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'phone',
        'code',
        'image',
        'points',
        'facebook',
        'linkedin',
        'github'
    ];
 
    protected $dates = ['deleted_at'] ;
  

 
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function Products() {
        return $this->belongsToMany(Product::class,Report::class);
    }
}
