<?php

namespace App\Domain\Auth\Controller;

use App\Application\Http\Controllers\Controller;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Interface\UserBusinessInterface;
use App\Domain\Auth\Model\User;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware('guest')]
class ChangePasswordController extends Controller
{
    public function __construct(private readonly UserBusinessInterface $userBusiness)
    {
    }

    #[Get('change-password', name: 'change-password')]
    public function show()
    {
        return view('change-password');
    }

    #[Post('change-password', name: 'change.perform')]
    public function update(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required'],
            'password' => ['required', 'min:5'],
            'confirm-password' => ['same:password']
        ]);
        $userDto = new UserDTO($attributes);

        if ($this->userBusiness->resetPasswordUser($userDto)) {
            return redirect('login');
        } else {
            return back()->with('error', 'Your email does not match the email who requested the password change');
        }
    }
}
