<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'reservation_id', 'star', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
