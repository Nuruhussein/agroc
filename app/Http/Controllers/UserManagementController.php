<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'role', 'phone', 'region', 'created_at')->get();
        return inertia('Users/Index', ['users' => $users]);
    }

    public function show(User $user)
    {
        Log::info('User show data:', $user->toArray()); // Debug log for user data
        return inertia('Users/Show', ['user' => $user->load('produce', 'orders')]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'role' => 'required|in:admin,farmer,buyer',
            'phone' => 'nullable|string|max:20',
            'region' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'phone' => $validated['phone'],
                'region' => $validated['region'],
                'password' => Hash::make($validated['password']),
            ]);
            return redirect()->route('admin.users')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create user']);
        }
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'role' => 'required|in:admin,farmer,buyer',
            'phone' => 'nullable|string|max:20',
            'region' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'phone' => $validated['phone'],
                'region' => $validated['region'],
            ];
            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }
            $user->update($data);
            return redirect()->route('admin.users')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update user']);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete user']);
        }
    }
}