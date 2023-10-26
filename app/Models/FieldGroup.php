<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fields_group()
    {
        return $this->hasMany(Field::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'field_group_id');
    }
}
