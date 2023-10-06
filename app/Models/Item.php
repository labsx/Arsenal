<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(FieldGroup::class);
    }
    public function items()
    {
        return $this->belongsTo(Category::class);
    }
    public function itemss()
    {
        return $this->hasMany(ItemAttributes::class);
    }
}
