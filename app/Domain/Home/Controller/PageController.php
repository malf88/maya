<?php

namespace App\Domain\Home\Controller;

use App\Application\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware('auth')]
class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    #[Get('/page/{page}',name: 'page')]
    public function index(string $page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }
    #[Get('/virtual-reality', name:'virtual-reality')]
    public function vr()
    {
        return view("pages.virtual-reality");
    }
    #[Get('/rtl',name: 'rtl')]
    public function rtl()
    {
        return view("pages.rtl");
    }
    #[Get('/profile-static', name:'profile-static')]
    public function profile()
    {
        return view("pages.profile-static");
    }
    #[Get('/sign-in-static',name: 'sign-in-static')]
    public function signin()
    {
        return view("pages.sign-in-static");
    }
    #[Get('/sign-up-static',name: 'sign-up-static')]
    public function signup()
    {
        return view("pages.sign-up-static");
    }
}
