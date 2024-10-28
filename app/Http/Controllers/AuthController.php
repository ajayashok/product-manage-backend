<?php

namespace App\Http\Controllers;

use App\Contracts\AuthRepoInterface;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepoInterface $authRepo) {
        $this->authRepository = $authRepo;
    }

    // User Registration API
    public function register() {
        request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255'
        ]);

        try {
            $data = $this->authRepository->register(request()->all());
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to login',400,[$th->getMessage()]);
        }

        return $this->successResponse($data, 'Register successfully');
    }

    // User Login API
    public function login() {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->toArray());
        }

        try {
            $data = $this->authRepository->login(request()->only('email', 'password'));
            if(empty($data))
                return $this->errorResponse('Invalid email or password', 401, [
                    'email' => ['Invalid email or password'],
                ]);
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to login',400,[$th->getMessage()]);
        }

        return $this->successResponse($data, 'Login successfully');
    }

    // User Logout API
    public function logout() {
        try {
            $data = $this->authRepository->logout();
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to logout',400,[$th->getMessage()]);
        }

        return $this->successResponse($data, 'Logout successfully');
    }
}
