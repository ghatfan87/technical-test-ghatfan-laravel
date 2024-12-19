<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'description',
        'status',
        'checklist_id'
    ];

    public const VALID_STATUSES = ['completed', 'in progress', 'pending','overdue'];

}
