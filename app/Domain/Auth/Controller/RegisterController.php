<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use App\Models\User;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
#[Middleware('web')]
class RegisterController extends Controller
{
    #[Get('register', name: 'register')]
    #[Middleware('guest')]
    public function create()
    {
        return view('register');
    }
    #[Post('register', name: 'register.perform')]
    #[Middleware('guest')]
    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'terms' => 'required'
        ]);
        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/');
    }
}
