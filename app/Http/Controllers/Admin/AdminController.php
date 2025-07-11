<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizProgress;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function home() : View {
        $this->setMenuSession();
        $this->setUserSession();
        $data = QuizProgress::where('user_id', auth()->id())->orderBy('id', 'desc')->get();
        return view('AdminPages.dashboard', compact('data'));
    }
}
