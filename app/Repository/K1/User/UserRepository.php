<?php

namespace App\Repository\K1\User;

interface UserRepository{
    public function UserRegister($data);
    public function UserLogin($data);
    public function getUserByEmail($email);
}