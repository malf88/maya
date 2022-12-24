<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Interface\UserBusinessInterface;
use App\Models\User;
use App\Notifications\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ResetPasswordController extends Controller
{

    public function __construct(
        private readonly UserBusinessInterface $userBusiness
    )
    {
    }

    #[Get('reset-password',name: 'reset-password', middleware: 'guest')]
    public function show()
    {
        return view('reset-password');
    }


    #[Post('reset-password',name: 'reset.perform', middleware: 'guest')]
    public function send(Request $request)
    {

        $email = $request->validate([
            'email' => ['required']
        ]);
        $user = new UserDTO($email);

        if($this->userBusiness->resetPasswordUser($user))
        {
            return back()->with('succes', 'An email was send to your email address');
        }

    }
}
