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
    /**
     * Retrieves a list of users based on the search criteria provided in the request.
     *
     * @param Request $request The request object containing search parameters.
     * @return Response A JSON response with the list of users matching the search criteria.
     */
    public function index(Request $request)
    {
        $perPage = request()->input('perPage', 20);
        $search = request()->input('search');
        $users = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('slug', 'like', '%' . $search . '%')->paginate($perPage);
        return $this->responseWithSuccess('User List', $users, Response::HTTP_OK);
    }
    /**
     * Store a new user in the database.
     *
     * @param UserStoreRequest $userStoreRequest The request containing user data for creation.
     * @return Response A JSON response indicating the success or failure of user creation.
     */
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
    /**
     * Retrieve a user based on the provided slug.
     *
     * @param string $slug The unique identifier of the user.
     * @return Response A JSON response indicating the success or failure of finding the user.
     */

    public function edit($slug)
    {
        $user = User::findBySlug($slug);
        if ($user) {
            return $this->responseWithSuccess('User Found', $user, Response::HTTP_OK);
        } else {
            return $this->responseWithError('User Not Found', '', Response::HTTP_NOT_FOUND);
        }
    }
    /**
     * Update a user's information based on the provided user update request and slug.
     *
     * @param UserUpdateRequest $userUpdateRequest The request containing updated user data.
     * @param string $slug The unique identifier (slug) of the user to be updated.
     * @return Response A JSON response indicating the success or failure of the user update operation.
     */
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
    /**
     * Delete a user based on the provided slug.
     *
     * @param string $slug The unique identifier (slug) of the user to be deleted.
     * @return Response A JSON response indicating the success or failure of the user deletion operation.
     */
    public function destroy($slug)
    {
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
