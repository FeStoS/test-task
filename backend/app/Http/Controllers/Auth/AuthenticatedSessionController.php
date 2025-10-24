<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    public function __construct(
        public UserService $userService
    )
    {
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $user = $this->userService->login($request->email, $request->password, (bool)$request->boolean('remember'));

        if (!$user) {
            return response()->json(['message' => 'Неправильний логін чи пароль'], 422); // тут переклади можуть бути з trans()
        }
        $request->session()->regenerate();
        return response()->json(['success' => true, 'user' => $user]);


    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
