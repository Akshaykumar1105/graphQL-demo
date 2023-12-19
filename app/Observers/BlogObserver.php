<?php

namespace App\Observers;

use App\Models\Blog;

class BlogObserver
{
   
    public function deleting(Blog $blog): void
    {
        foreach ($blog->getMedia('blog') as $media) {
            $media->delete();
        }
    }
}
