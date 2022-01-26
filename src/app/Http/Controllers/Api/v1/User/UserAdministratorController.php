<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserAdminitratorRequest;
use Illuminate\Http\Request;

class UserAdministratorController extends Controller
{
    public function create (UserAdminitratorRequest $request)
    {
        echo "si"; exit;
    }
}
