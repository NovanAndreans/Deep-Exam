<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home() : View {
        $this->setMenuSession();
        $this->setUserSession();
        return view('AdminPages.dashboard');
    }
}
