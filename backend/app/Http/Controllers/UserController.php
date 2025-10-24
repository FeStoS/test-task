<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        public UserService $userService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->list();

        return response()->json(['success' => true, 'result' => $users]);
    }

    public function update(Request $request, int $id)
    {
        $rules = [
            'first_name' => ['sometimes','string','max:255'],
            'last_name'  => ['sometimes','string','max:255'],
            'middle_name' => ['sometimes','nullable','string','max:255'],
            'email'      => ['sometimes','email','max:255',"unique:users,email,{$id}"],
            'role_id'    => ['sometimes','integer','exists:roles,id'],
            'password'   => ['sometimes','string','min:8'], // опц.
        ];

        $messages = [
            'last_name.required' => 'Прізвище повинно бути заповнене',
            'first_name.required' => 'Ім\'я повинно бути заповнене',
            'middle_name.required' => 'По батькові повинно бути заповнене',
            'email.required' => 'Введіть email',
            'email.unique' => 'Користувач з такою :attribute вже існує.',
            'password.confirmed' => 'Підтвердження пароля не співпадає.',
        ];
        $fieldLabels = [
            'last_name'            => 'прізвище',
            'first_name'           => 'ім’я',
            'middle_name'          => 'по батькові',
            'email'                => 'електронна пошта',
            'password'             => 'пароль',
            'password_confirmation'=> 'підтвердження пароля',
        ];
        $data = $request->validate($rules, $messages, $fieldLabels);

        $user = $this->userService->update($id, $data);
        if (!$user) {
            return response()->json(['success'=>false,'message'=>'User not found'], 404);
        }
        return response()->json(['success'=>true,'result'=>$user]);
    }


    public function destroy(int $id)
    {
        $deleted = $this->userService->delete($id);
        if (!$deleted) {
            return response()->json(['success'=>false,'message'=>'User not found'], 404);
        }
        return response()->json(['success'=>true]);
    }



}
