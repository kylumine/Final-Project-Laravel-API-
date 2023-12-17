<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function sold_items() {
        return $this->hasMany(Sold_Item::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $guarded = [];
}
