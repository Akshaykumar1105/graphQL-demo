<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Facades\MediaUploader;
use Plank\Mediable\Media;

class BlogService
{

    public function __construct(private Blog $blogObj)
    {
        //
    }

    public function collection($fields, $args)
    {
        $search = $args['search'];
        $categoryId = $args['category_id'];

        $blogs = $this->blogObj->select($fields->getSelect());

        if ($search) {
            $blogs->search($search);
        }elseif($categoryId){
            $blogs->categoryFilter($args['category_id']);
        }
        return $blogs->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    public function store($args)
    {
        $args['user_id'] = Auth::id();
        $blog = $this->blogObj->create($args);

        $media = Media::find($args['media_id']);
        $blog->attachMedia($media, ['blog']);

        return $blog;
    }

    public function resource($args, $select, $with)
    {
        return  $this->blogObj->whereId($args['id'])->select($select)->first();
    }

    public function update($args)
    {
        return  $this->blogObj->whereId($args['id'])->update($args);
    }

    public function destroy($args)
    {
        $blog = $this->blogObj->whereId($args['id'])->first();

        foreach ($blog->getMedia('blog') as $media) {
            $media->delete();
        }

        $blog->delete();

        return true;
    }
}
