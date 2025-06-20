<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    /// BorrowRequest.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class);
    }
}
