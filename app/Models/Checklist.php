<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable=[
    'title',
    'description',
    'user_id'
];

public function items(){
    return $this->hasMany(ChecklistItem::class);
}
}
