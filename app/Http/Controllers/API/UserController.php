<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = request()->input('perPage', 20);
        $search = request()->input('search');
        $users = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')->paginate($perPage);
        return $this->responseWithSuccess('User List', $users);
    }
}
