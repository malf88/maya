<?php

namespace App\Domain\Auth\Controller;

use App\Application\Abstracts\AuthAbstract;
use App\Application\Http\Controllers\Controller;
use App\Domain\Auth\DTO\UserDTO;
use App\Domain\Auth\Interface\UserBusinessInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware('auth')]
class UserProfileController extends Controller
{
    public function __construct(
        private readonly UserBusinessInterface $userBusiness
    )
    {
    }

    #[Get('/profile',name: 'profile')]
    public function show()
    {
        return view('user-profile');
    }

    #[Post('/profile', name: 'profile.update')]
    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required','max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255']
        ]);

        $user = new UserDTO($attributes);
        $user->id = AuthAbstract::user()->id;
        $this->userBusiness->updateUserWithoutPassword($user);
        return back()->with('succes', 'Profile succesfully updated');
    }
}
