<?php

namespace Taqie\Image\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageTransform;
class Image extends Model
{
    protected $fillable = [
        'imagetable_id',
        'imagetable_type',
        'disk',
        'path',
        'name'
    ];

    protected $appends = [
        'full_path'
    ];

    public function getFullPathAttribute()
    {
        return Storage::disk($this->getAttribute('disk'))->path($this->getAttribute('path').$this->getAttribute('name'));
    }

    public function thumbResize(?int $width, ?int $height, $ext = 'jpg') : string
    {
        $storage = Storage::disk($this->disk);
        $directory = 'thumbs/';
        $fileName = $width.'_'.$height.'_'.$this->id.'.'.$ext;
        $thumbPath = $directory.$fileName;
        $storagePathThumb = $storage->path($directory);

        if(!file_exists($storagePathThumb))
        {
            mkdir($storagePathThumb);
        }

        if($storage->exists($thumbPath))
        {
            return $thumbPath;
        }

        $image = ImageTransform::make($this->getAttribute('full_path'));
        $image->resize($width,$height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->encode($ext);
        $image->save($storagePathThumb.$fileName);

        return $thumbPath;

    }
}