<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'user_id'
    ];

    public function items(){
        return $this->hasMany(ChecklistItem::class,'checklist_id');
    }
}
