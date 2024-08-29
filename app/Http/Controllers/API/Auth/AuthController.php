<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AuthController extends Controller
{
    /**
     * Validates the login request input and attempts to authenticate the user.
     *
     * If the authentication is successful, returns a JSON response with a success message,
     * the authenticated user details, and a token for API access.
     * If the authentication fails, returns a JSON response with an error message.
     *
     * @param Request $request The request containing the user input and password.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the login status.
     */
    public function login(Request $request)
    {
        $request->validate([
            'input' => [
                'required',
            ],
            'password' => 'required|min:6',
        ]);
        if (Auth::attempt(['email' => $request->input, 'password' => $request->password])) {
            $user = User::where('email', $request->input)->first();
            Log::info($user);

            return response()->json([
                'message' => 'Login Successful',
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'message' => 'Sorry !!! Invalid Credentials',
            ], 500);
        }
    }
    /**
     * Registers a new user.
     *
     * Attempts to create a new user with the provided name, email, and password.
     * If successful, returns a JSON response with a success message, the created user details, and an API token.
     * If an error occurs during user creation, rolls back the transaction and returns a JSON response with the error message.
     *
     * @param UserStoreRequest $request The request containing the user's name, email, and password.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the registration status.
     */

    public function register(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : bcrypt(12345678),
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $user->createToken('API token of ' . $user->name)->plainTextToken,
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }
    /**
     * Logs out the authenticated user.
     *
     * Deletes the current access token of the user upon successful logout.
     * Returns a JSON response with a success message if the user is logged out successfully,
     * or an error message if the user is unauthenticated.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the logout status.
     */

    public function logout()
    {
        $user = auth()->user();
        if (auth()->user()) {
            $user->currentAccessToken()->delete();
            return $this->responseWithSuccess('User logged out successfully', $user, Response::HTTP_OK);
        } else {
            return $this->responseWithError('User Unauthenticated', null, Response::HTTP_NOT_FOUND);
        }
    }
}
