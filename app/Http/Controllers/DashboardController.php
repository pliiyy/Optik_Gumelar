<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Lens;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalUsers = User::count();
        $totalLenses = Lens::count();
        $totalFrames = Frame::count();
        $totalProducts = $totalLenses + $totalFrames;

        if ($user && $user->role === 'PELANGGAN') {
            return view('dashboard', compact('totalUsers', 'totalLenses', 'totalFrames', 'totalProducts'));
        }

        return view('dashboard', compact('totalUsers', 'totalLenses', 'totalFrames', 'totalProducts'));
    }
}
