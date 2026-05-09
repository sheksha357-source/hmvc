<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $posts = Auth::user()->posts()->latest()->get();

        return view('user::dashboard', compact('posts'));
    }
}
