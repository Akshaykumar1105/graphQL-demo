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
        $categoryId = $args['input']['category_id'];
        $isPublished = $args['input']['is_published'];

        $blogs = $this->blogObj->with($args['with'])->select($args['select']);

        if ($search) {
            $blogs->search($search);
        } elseif ($categoryId) {
            $blogs->categoryFilter($categoryId);
        } elseif ($isPublished){
            $blogs->isPublished($isPublished);
        }

        return $blogs->latest()->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    public function store($inputs)
    {
        $inputs['user_id'] = Auth::id();

        $blog = $this->blogObj->create($inputs);

        $media = Media::find($inputs['media_id']);

        $blog->attachMedia($media, ['blog']);

        return $blog;
    }

    public function resource($id, $args)
    {
        return  $this->blogObj->whereId($id)->with($args['with'])->select($args['select'])->first();
    }

    public function update($id, $inputs)
    {
        $blog = $this->blogObj->find($id);

        $blog->update($inputs);

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
