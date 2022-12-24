<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Interface\UserBusinessInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
#[Middleware('web')]
class LoginController extends Controller
{
    public function __construct(
        private readonly UserBusinessInterface $userBusiness
    )
    {
    }

    /**
     * Display login page.
     *
     * @return Renderable
     */
    #[Get('/login',name: 'login')]
    #[Middleware('guest')]
    public function show()
    {
        return view('login');
    }
    #[Post('/login',name: 'login.perform')]
    #[Middleware('guest')]
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = new UserDTO($credentials);

        if ($this->userBusiness->authUser($user)) {
            $request->session()->regenerate();

            return redirect()->intended('');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    #[Post('/logout',name: 'logout')]
    #[Middleware('auth')]
    public function logout(Request $request)
    {
        $this->userBusiness->logoutUser();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
