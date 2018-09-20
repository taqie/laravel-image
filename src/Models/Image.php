<?php

namespace Taqie\Image\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageTransform;
class Image extends Model
{
    const TYPES = [
        'resize',
        'fit'
    ];
    protected $fillable = [
        'imagetable_id',
        'imagetable_type',
        'disc',
        'path',
        'name'
    ];

    protected $appends = [
        'full_path'
    ];

    public function getFullPathAttribute()
    {
        return Storage::disk($this->getAttribute('disc'))->path($this->getAttribute('path').$this->getAttribute('name'));
    }

    public function thumbResize(?int $width, ?int $height) : string
    {
        $image = ImageTransform::make($this->getAttribute('full_path'));
        $image->resize($width,$height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}