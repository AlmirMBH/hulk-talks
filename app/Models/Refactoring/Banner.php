<?php

namespace App\Models\Refactoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'template',
        'description',
        'image',
        'link',
        'status',
        'order'
    ];
}
