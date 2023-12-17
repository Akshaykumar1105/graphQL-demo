<?php

namespace App\Services;

use App\Models\Blog;
use Plank\Mediable\Media;
use Illuminate\Support\Facades\Auth;

class BlogService
{

    public function __construct(private Blog $blogObj)
    {
        //
    }

    public function collection($args)
    {
        $search = $args['search'];
        $categoryId = $args['category_id'];

        $blogs = $this->blogObj->with($args['with'])->select($args['select']);

        if ($search) {
            $blogs->search($search);
        } elseif ($categoryId) {
            $blogs->categoryFilter($args['category_id']);
        }

        return $blogs->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    public function store($args)
    {
        $args['input']['user_id'] = Auth::id();

        $blog = $this->blogObj->create($args['input']);

        $media = Media::find($args['input']['media_id']);

        $blog->attachMedia($media, ['blog']);

        return $blog;
    }

    public function resource($args)
    {
        return  $this->blogObj->whereId($args['id'])->with($args['with'])->select($args['select'])->first();
    }

    public function update($args)
    {
        $blog = $this->blogObj->find($args['id']);

        $blog->update($args['input']);

        return $blog;
    }

    public function destroy($id)
    {
        $blog = $this->blogObj->whereId($id)->first();

        foreach ($blog->getMedia('blog') as $media) {
            $media->delete();
        }

        $blog->delete();

        return true;
    }
}
