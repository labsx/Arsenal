<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category_list()
    {
        return $this->belongsTo(Category::class);
    }

    public function category_lists()
    {
        return $this->hasMany(FieldGroup::class);
    }
}
