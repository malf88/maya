<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class ResetPasswordController extends Controller
{
    use Notifiable;

    #[Get('reset-password',name: 'reset-password', middleware: 'guest')]
    public function show()
    {
        return view('reset-password');
    }

    public function routeNotificationForMail() {
        return request()->email;
    }
    #[Post('reset-password',name: 'reset.perform', middleware: 'guest')]
    public function send(Request $request)
    {
        $email = $request->validate([
            'email' => ['required']
        ]);
        $user = User::where('email', $email)->first();

        if ($user) {
            $this->notify(new ForgotPassword($user->id));
            return back()->with('succes', 'An email was send to your email address');
        }
    }
}
