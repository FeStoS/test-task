<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class UserService
{
    public function __construct(private UserRepository $users) {}

    public function list()
    {
        return $this->users->list();
    }

    public function store(array $data): ?User
    {
        return empty($data) ? null : $this->users->store($data);
    }

    public function update(int $id, array $data): ?User
    {
        return $this->users->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->users->delete($id);
    }

    public function login(string $email, string $password, bool $remember = false): ?User
    {
        $user = $this->users->findByEmail($email);
        if (!$user || !Hash::check($password, $user->password)) return null;

        Auth::login($user, $remember);
        return $user;
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
