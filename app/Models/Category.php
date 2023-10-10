<?php

namespace App\Models;

use App\Models\CategoryList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'name',
        'parent_id',
        'field_group_id'
    ];

    public function category()
    {
        return $this->hasMany(CategoryList::class);
    }
    public function category_table()
    {
        return $this->hasMany(Item::class);
    }
    public function categories()
    {
        return $this->hasMany(FieldGroup::class);
    }
}
