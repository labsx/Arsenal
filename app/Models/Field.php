<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fields()
    {
        return $this->hasMany(Items::class);
    }

    public function fields_group()
    {
        return $this->belongsTo(FieldGroup::class);
    }
}
