<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CocoFooterModel extends Model
{
    use HasFactory;

    protected $table = 'coco_footer';
    
    protected $fillable = [
        'name',
        'url',
        'blank',
        'sort',
        'status',
    ];
}
