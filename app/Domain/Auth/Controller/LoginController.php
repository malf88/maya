<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
#[Middleware('web')]
class LoginController extends Controller
{
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

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
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
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
