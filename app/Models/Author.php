<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // 適宜追加

   public function detail()
    {
        return $this->hasOne(AuthorDetail::class);
    }
    
    public function books()
    {
        return $this->belongsToMany(Book::class)->withTimestamps();
    }

    
}