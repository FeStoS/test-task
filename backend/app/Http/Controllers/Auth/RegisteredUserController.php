<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{

    public function __construct(
        public UserService $userService
    )
    {
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    public function store(Request $request)
    {


        $messages = [
            'last_name.required' => 'Прізвище повинно бути заповнене',
            'first_name.required' => 'Ім\'я повинно бути заповнене',
            'middle_name.required' => 'По батькові повинно бути заповнене',
            'email.required' => 'Введіть email',
            'email.unique' => 'Користувач з такою :attribute вже існує.',
            'password.confirmed' => 'Підтвердження пароля не співпадає.',
        ];
        $rules = [
            'last_name'   => ['required', 'string', 'max:255'],
            'first_name'  => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        $fieldLabels = [
            'last_name'            => 'прізвище',
            'first_name'           => 'ім’я',
            'middle_name'          => 'по батькові',
            'email'                => 'електронна пошта',
            'password'             => 'пароль',
            'password_confirmation'=> 'підтвердження пароля',
        ];
        // можна через FormRequest.

        $validated = $request->validate($rules, $messages, $fieldLabels);
        $registeredUser = $this->userService->store($validated);
        return \response()->json($registeredUser,Response::HTTP_CREATED);
    }
}
