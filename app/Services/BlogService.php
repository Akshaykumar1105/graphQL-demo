<?php

namespace App\Services;

use App\Models\Blog;
use Plank\Mediable\Media;
use App\Traits\FilterTrait;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    use FilterTrait;

    public function __construct(private Blog $blogObj)
    {
        //
    }

    public function collection($inputs)
    {
        $blogs = $this->blogObj->with($inputs['with'])->select($inputs['select']);

        if ($inputs['search']) {
            $blogs->search($inputs['search']);
        }

        $this->filter($blogs, $inputs['input']);

        return $blogs->latest()->paginate($inputs['limit'], ['*'], 'page', $inputs['page']);
    }

    public function store($inputs)
    {
        $inputs['user_id'] = Auth::id();

        $blog = $this->blogObj->create($inputs);

        $media = Media::find($inputs['media_id']);

        $blog->attachMedia($media, ['blog']);

        return $this->resource($blog->id, $inputs);
    }

    public function resource($id, $inputs)
    {
        $select = $inputs['select'] ?? '*';

        $with = $inputs['with'] ?? $this->blogObj->relationships;

        return  $this->blogObj->with($with)->select($select)->find($id);
    }

    public function update($id, $inputs)
    {
        $blog = $this->blogObj->find($id);

        $blog->update($inputs);

        if ($blog->firstMedia('blog')->id !== $inputs['media_id']) {
            $blog->firstMedia('blog')->delete();
            
            $media = Media::find($inputs['media_id']);

            $blog->syncMedia($media, ['blog']);
        }

        return $this->resource($id, $inputs);
    }

    public function destroy($id)
    {
        return  $this->blogObj->destroy($id);
    }
}
