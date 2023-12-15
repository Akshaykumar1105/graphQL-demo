<?php

namespace App\Services;

use Plank\Mediable\Media;
use Plank\Mediable\Facades\MediaUploader;

class MediaService
{

    public function store($args)
    {
        if ($args['id']) {
            return $this->update($args);
        }
        
        return MediaUploader::fromSource($args['image'])
            ->toDisk('public')
            ->toDirectory($args['image_type'])
            ->upload();
    }

    public function update($args)
    {
        $media = Media::find($args['id']);
        $fileName = pathinfo($args['image']->getClientOriginalName(), PATHINFO_FILENAME);
        return MediaUploader::fromSource($args['image'])
            ->useFilename($fileName)
            ->replace($media);
    }

    public function destroy($args){
        Media::find($args['id'])->delete();
        return true;
    }
}
