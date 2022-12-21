<?php

namespace App\Domain\Home\Controller;

use App\Application\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;


#[Middleware(['auth','web'])]
class HomeController extends Controller
{
    #[Get('/', name: 'home')]
    public function index()
    {
        return view('pages.dashboard');
    }
}
