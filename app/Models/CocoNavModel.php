<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CocoNavModel extends Model
{
    use HasFactory;

    protected $table = 'coco_nav';
    
    protected $fillable = [
        'name',
        'url',
        'position',
        'parent_id',
        'blank',
        'sort',
        'status',
    ];
}
