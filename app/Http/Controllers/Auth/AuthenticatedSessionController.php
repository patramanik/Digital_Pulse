<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();
    //     $request->session()->regenerate();

    //     // Get the authenticated user
    //     $user = $request->user();
    //     // dd($user);  

    //     // Redirect based on user_role value
    //     return (int) $user->user_role === 1
    //         ? redirect('/developer-page')
    //         : redirect(RouteServiceProvider::HOME);
    // }
    public function store(LoginRequest $request): RedirectResponse
    {
        // Find user by email before authentication
        $user = \App\Models\User::where('email', $request->email)->first();

        // If user exists and is blocked (user_status == 0), prevent login
        if ($user && (int) $user->user_status === 0) {
            return redirect()->route('login')
                ->withInput($request->only('email'))
                ->with('error', 'You are blocked, Contact Your Developer!');
        }

        // Proceed with authentication
        $request->authenticate();
        $request->session()->regenerate();

        // Redirect to the default home route
        return redirect(RouteServiceProvider::HOME);
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function UsersList()
    {
        $users = User::all();
        // return view('usersList/users');
        return view('usersList.users', compact('users'));
    }
    public function SuspendUser($id)
    {
        $user = User::findOrFail($id);
        $user->user_status = 0;
        $user->save();
        return response()->json(['message' => 'User Suspended successfully']);
    }
    public function ActiveUser($id)
    {

        $user = User::findOrFail($id);
        $user->user_status = 1;
        $user->save();
        return response()->json(['message' => 'User Activated successfully']);
    }
}
