<?php

namespace App\Contracts;

interface AuthRepoInterface {
    public function register(array $data);
    public function login(array $data);
    public function logout();
}
