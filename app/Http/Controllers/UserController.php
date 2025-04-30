<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        Log::info('Users index accessed', ['user_id' => auth()->id()]);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        Log::info('User create form accessed', ['user_id' => auth()->id()]);
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = new User($validated);
        $user->password = Hash::make($validated['password']);

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        event(new Registered($user));

        Log::info('User created', ['user_id' => $user->id, 'created_by' => auth()->id()]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        Log::info('User edit form accessed', ['user_id' => $user->id, 'accessed_by' => auth()->id()]);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user->fill($validated);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        Log::info('User updated', ['user_id' => $user->id, 'updated_by' => auth()->id()]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function changePasswordForm(Request $request)
    {
        $user = $request->user();
        Log::info('Change password form accessed', ['user_id' => $user->id, 'accessed_by' => auth()->id()]);
        return view('users.change-password', compact('user'));
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        Log::info('Password changed', ['user_id' => $user->id, 'changed_by' => auth()->id()]);

        return redirect()->route('dashboard')->with('success', 'Password changed successfully.');
    }

    public function editProfile(Request $request)
    {
        Log::info('Profile edit form accessed', ['user_id' => auth()->id()]);
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user->fill($validated);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        Log::info('Profile updated', ['user_id' => $user->id]);
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function show(User $user)
    {
        Log::info('User show accessed', ['user_id' => $user->id, 'accessed_by' => auth()->id()]);
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->delete();
        Log::info('User deleted', ['user_id' => $user->id, 'deleted_by' => auth()->id()]);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
