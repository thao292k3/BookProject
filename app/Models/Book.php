<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'published_date',
        'isbn',
        'price',
        'description',
        'status',
        'category_id',
        'cover_image',
        'stock'
    ];
    public function cat()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
