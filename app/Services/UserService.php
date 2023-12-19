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

    public function collection($inputs)
    {
        $users = $this->userObj->with($inputs['with'])->select($inputs['select']);
        $search = $inputs['search'];
        
        if ($search) {
            $users->search($search);
        }

        return $users->paginate($inputs['limit'], ['*'], 'page', $inputs['page']);
    }

    public function resource($id,$inputs)
    {
        if (!in_array('users.first_name', $inputs['select']) || !in_array('users.last_name', $inputs['select'])) {
            $inputs['select'][] = 'users.first_name';
            $inputs['select'][] = 'users.last_name';
        }

        $select = $inputs['select'] ?? '*';

        $with = $inputs['with'] ?? $this->userObj->relationships;

        return $this->userObj->with($with)->select($select)->find($id);
    }

    public function update($inputs){
        $user = $this->userObj->find(Auth::id());

        $user->update($inputs);

        $media = Media::find($inputs['media_id']);

        $user->syncMedia($media, ['blog']);
        
        return $this->resource($user->id, $inputs);
    }
}
