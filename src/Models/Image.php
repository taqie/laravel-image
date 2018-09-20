<?php

namespace Taqie\Image\Models;

use Illuminate\Database\Eloquent\Model;
class Image extends Model
{
    protected $fillable = [
        'imagetable_id',
        'imagetable_type',
        'disc',
        'path',
        'name'
    ];
}