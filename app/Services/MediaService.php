<?php

namespace App\Services;

use Plank\Mediable\Media;
use Plank\Mediable\Facades\MediaUploader;

class MediaService
{

    public function store($args)
    {
        return MediaUploader::fromSource($args['input']['image'])
            ->toDisk('public')
            ->toDirectory($args['input']['image_type'])
            ->upload();
    }

    public function update($args)
    {
        $media = Media::find($args['id']);

        $fileName = pathinfo($args['input']['image']->getClientOriginalName(), PATHINFO_FILENAME);
        
         MediaUploader::fromSource($args['input']['image'])
            ->useFilename($fileName)
            ->replace($media);

        return $media;
    }

    public function destroy($id)
    {
        $media = Media::find($id);
        $media->delete();

        return true;
    }
}
