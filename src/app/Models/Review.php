<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['reservation_id', 'star', 'comment','image'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }


}
