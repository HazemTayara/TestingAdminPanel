<?php

namespace App\Models;

use App\Http\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    protected $fillable = [
        'uuid',
        'product_id',
        'researcher_id',
        'title',
        'file',
        'status',
        'review_status',
        'user_id',
        'canceled_note'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function researcher()
    {
        return $this->belongsTo(Researcher::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Products() {
        return $this->HasManyThrough(Product::class,Report::class);
    }
}
