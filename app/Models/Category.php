<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'field_group_id',
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

    public function parent_models()
    {
        return $this->hasMany(ParentModel::class);
    }
}
