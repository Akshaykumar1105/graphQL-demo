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
        $users = $this->userObj->with($args['with'])->select($args['select']);
        $search = $args['search'];
        
        if ($search) {
            $users->search($search);
        }

        return $users->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    public function resource($id,$inputs)
    {
        $select = $inputs['select'] ?? '*';

        $with = $inputs['with'] ?? $this->userObj->relationships;
        
        return $this->userObj->whereId($id)->with($with)->select($select)->first();
    }

    public function update($inputs){
        $user = $this->userObj->find(Auth::id());

        $user->update($inputs);

        $media = Media::find($inputs['media_id']);

        $user->syncMedia($media, ['blog']);
        
        return $this->resource($user->id, $inputs);
    }
}
