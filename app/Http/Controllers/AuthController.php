<?php

namespace App\Http\Controllers;

use App\Constants\DBTypes;
use App\Constants\Routes;
use App\Constants\Systems;
use App\Models\Type;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $type, $user;

    public function __construct(Type $type, User $user)
    {
        $this->type = $type;
        $this->user = $user;
    }

    public function signup(): View
    {
        $roles = $this->type
            ->where('master_id', $this->type->getIdByCode(DBTypes::UserRole))
            ->whereNotIn('id', [
                $this->type->getIdByCode(DBTypes::RoleSuperAdmin),
                $this->type->getIdByCode(DBTypes::RoleAdmin),
                $this->type->getIdByCode(DBTypes::RoleGuruPrem),
                $this->type->getIdByCode(DBTypes::RoleSiswaPrem),
            ])->get();
        return view('AuthPages.signup', compact('roles'));
    }

    public function signupAction(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = $this->user->create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => $validatedData['role'],
            ]);

            $this->successToast('Registration Success');
            return redirect()->route(Routes::routeSignin);
        } catch (\Exception $e) {
            $this->failedToast('Registration failed. Please try again later.');
            return redirect()->back()->withInput();
        }
    }

    public function signin(): View
    {
        return view('AuthPages.signin');
    }

    public function signinAction(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Periksa apakah email dan password cocok
        $user = User::where('email', $validatedData['email'])->first();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect ke halaman dashboard
            $this->successToast('Signin Successful');
            return redirect()->route(Routes::routeAdminDashboard);
        } else {
            // Login gagal
            $this->failedToast('Invalid email or password');
            return redirect()->back()->withInput();
        }
    }

    public function signout()
    {
        Auth::logout();
        $this->successToast('Signout Success\n Anda berhasil Logout');
        return redirect()->route(Routes::routeGuestHome);
    }
}
