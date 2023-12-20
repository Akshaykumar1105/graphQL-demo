<?php

namespace App\Services;

use Plank\Mediable\Media;
use Plank\Mediable\Facades\MediaUploader;

class MediaService
{

    public function store($inputs)
    {
        return MediaUploader::fromSource($inputs['image'])
            ->toDisk('public')
            ->toDirectory($inputs['type'])
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
        return Media::destroy($id);
    }
}
