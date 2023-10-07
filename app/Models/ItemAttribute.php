<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemAttribute extends Model
{
    use HasFactory;

    protected $guarded = []; 

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
