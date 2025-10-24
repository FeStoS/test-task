<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IRepositoryInterface
{

    public function list()
    {
        return User::orderBy('created_at', 'desc')->with('role')->get();
    }

    public function store(array $data = []): User | null
    {
        if(empty($data)) return null;
        $userRole = Role::where('name','user')->first();
        if(!is_null($userRole)){
            $user = User::create([
                'last_name'   => $data['last_name'],
                'first_name'  => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'email'       => $data['email'],
                'password'    => Hash::make($data['password']),
                'role_id'     => $userRole->id,           // ← ПРИКРІПИЛИ РОЛЬ
            ]);




            return $user;

        }

        return null;

    }

    public function update(int $userId, array $data): User |null
    {
        $user = \App\Models\User::find($userId);
        if (!$user) return null;

        if (isset($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        }
        $user->fill($data)->save();
        return $user->with('role')->first();
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);
        return $user ? (bool) $user->delete() : false;
    }

    public function findByEmail(string $e): ?User{ return User::where('email',$e)->first(); }
}
