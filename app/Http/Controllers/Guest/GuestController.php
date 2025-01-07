<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home() : View {
        return view('GuestPages.index');
    }
    public function about() : View {
        return view('GuestPages.about');
    }
    public function courses() : View {
        return view('GuestPages.courses');
    }
    public function contact() : View {
        return view('GuestPages.contact');
    }
    public function testimoni() : View {
        return view('GuestPages.testimoni');
    }
    // public function notFound() : View {
    //     return view('GuestPages.404');
    // }
}
