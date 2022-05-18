<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CocoCategoryModel extends Model
{
    use HasFactory;
    
    protected $table = 'coco_category';
    
    protected $fillable = [
        'name',
        'url',
        'status',
    ];
}
