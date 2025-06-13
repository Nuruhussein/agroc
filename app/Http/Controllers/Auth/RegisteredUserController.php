<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        $role = null;
        $title = 'Register';
        
        if (request()->is('register/farmer')) {
            $role = 'farmer';
            $title = 'Register as Farmer';
        } elseif (request()->is('register/buyer')) {
            $role = 'buyer';
            $title = 'Register as Buyer';
        }

        return Inertia::render('auth/Register', [
            'userRole' => $role,
            'title' => $title,
        ]);
    }

    public function storeFarmer(Request $request): RedirectResponse
    {
        return $this->store($request, 'farmer');
    }

    public function storeBuyer(Request $request): RedirectResponse
    {
        return $this->store($request, 'buyer');
    }

    protected function store(Request $request, ?string $role = null): RedirectResponse
    {
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for profile picture
        ];

        if ($role) {
            $validationRules['phone'] = 'required|string|max:20';
            $validationRules['region'] = 'required|string|max:255';
        }

        $request->validate($validationRules);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ];

        if ($role) {
            $userData['phone'] = $request->phone;
            $userData['region'] = $request->region;
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $userData['profile_picture'] = $path;
        }

        $user = User::create($userData);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}