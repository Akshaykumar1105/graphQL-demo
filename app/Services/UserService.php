<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class UserService
{

    public function __construct(private User $userObj)
    {
        //
    }

    public function collection($args, $getSelectFields)
    {
        $blogs = $this->userObj->select($getSelectFields()->getSelect());
        $search = $args['search'];
        if ($search) {
            $blogs->search($search);
        }

        return $blogs->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

    public function resource($args, $getSelectFields)
    {
        $fields = $getSelectFields();
        return $this->userObj->where('id', $args['id'])->select($fields->getSelect())->first();
    }
}
