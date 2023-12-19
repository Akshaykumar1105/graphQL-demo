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
            ->toDirectory($args['input']['type'])
            ->upload();
    }

    public function update($id, $inputs)
    {
        $media = Media::find($id);

        $fileName = pathinfo($inputs['image']->getClientOriginalName(), PATHINFO_FILENAME);
        
         MediaUploader::fromSource($inputs['image'])
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
