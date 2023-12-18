<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Plank\Mediable\Media;

class UserService
{

    public function __construct(private User $userObj)
    {
        //
    }

    public function collection($args)
    {
        $blogs = $this->userObj->with($args['with'])->select($args['select']);
        $search = $args['search'];
        
        if ($search) {
            $blogs->search($search);
        }

        return $blogs->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    public function resource($args)
    {
        return $this->userObj->whereId(Auth::id())->with($args['with'])->select($args['select'])->first();
    }

    public function update($args){
        $user = $this->userObj->find(Auth::id());

        $user->update($args['input']);

        $media = Media::find($args['input']['media_id']);

        $user->syncMedia($media, ['blog']);
        
        return $user;
    }
}
