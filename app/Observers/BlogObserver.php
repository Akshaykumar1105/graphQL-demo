<?php

namespace App\Observers;

use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class BlogObserver
{
    
    public function deleting(Blog $blog): void
    {
        Log::info("Deleting media for Blog ID: {$blog->id}");
        $blog->firstMedia('blog')->delete();
    }
}
