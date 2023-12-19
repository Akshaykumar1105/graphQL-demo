<?php

namespace App\Services;

use App\Models\User;
use Plank\Mediable\Media;
use Illuminate\Support\Facades\Auth;

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

    public function update($inputs){
        $user = $this->userObj->find(Auth::id());

        $user->update($inputs);

        $media = Media::find($inputs['media_id']);

        $user->syncMedia($media, ['blog']);
        
        return $user;
    }
}
