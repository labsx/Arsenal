<?php

namespace App\Models;

use App\Models\ItemAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function attributes()
    {
        return $this->hasMany(ItemAttributes::class);
    }
}
