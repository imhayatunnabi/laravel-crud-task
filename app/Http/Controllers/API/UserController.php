<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = request()->input('perPage', 20);
        $search = request()->input('search');
        $users = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')->paginate($perPage);
        return $this->responseWithSuccess('User List', $users, Response::HTTP_OK);
    }
    public function store(UserStoreRequest $userStoreRequest)
    {

        try {
            DB::beginTransaction();
            $user = User::create($userStoreRequest->validated());
            DB::commit();
            return $this->responseWithSuccess('User Created Successfully', $user, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('User creation failed: ', ['exception' => $th]);
            return $this->responseWithError('User Creation Failed', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit($slug)
    {
        $user = User::findBySlug($slug);
        if ($user) {
            return $this->responseWithSuccess('User Found', $user, Response::HTTP_OK);
        } else {
            return $this->responseWithError('User Not Found', '', Response::HTTP_NOT_FOUND);
        }
    }
    public function update(UserUpdateRequest $userUpdateRequest, $slug)
    {
        $user = User::findBySlug($slug);
        if (!$user) {
            return $this->responseWithError('User Not Found', [], Response::HTTP_NOT_FOUND);
        }
        try {
            DB::beginTransaction();
            if (!$user) {
                return $this->responseWithError('User Not Found', [], Response::HTTP_NOT_FOUND);
            }
            $user->update($userUpdateRequest->valslugated());
            DB::commit();
            return $this->responseWithSuccess('User Updated Successfully', $user, Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('User update failed: ', ['exception' => $th]);
            return $this->responseWithError('User Update Failed', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function destroy($slug){
        $user = User::findBySlug($slug);
        if (!$user) {
            return $this->responseWithError('User Not Found', [], Response::HTTP_NOT_FOUND);
        }

        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return $this->responseWithSuccess('User Deleted Successfully', [], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('User deletion failed: ', ['exception' => $th]);
            return $this->responseWithError('User Deletion Failed', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
