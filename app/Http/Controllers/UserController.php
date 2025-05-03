<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
            'role' => 'required|in:admin,division_head,department_head,section_head,staff,user',
            'division_id' => 'nullable|exists:divisions,id',
            'department_id' => 'nullable|exists:departments,id',
            'section_id' => 'nullable|exists:sections,id',
        ]);

        $user = new User($validated);
        $user->password = Hash::make($validated['password']);
        $user->is_admin = $validated['role'] === 'admin';
        $user->created_by = auth()->id();

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        event(new Registered($user));

        Log::info('User created', ['user_id' => $user->id, 'created_by' => auth()->id()]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        Log::info('User show accessed', ['user_id' => $user->id, 'accessed_by' => auth()->id()]);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        Log::info('User edit form accessed', ['user_id' => $user->id, 'accessed_by' => auth()->id()]);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,division_head,department_head,section_head,staff,user',
        ]);

        $changes = [];
        if ($user->name !== $validated['name']) {
            $changes[] = [
                'field_name' => 'name',
                'old_value' => $user->name,
                'new_value' => $validated['name'],
                'changed_by' => auth()->id(),
                'user_id' => $user->id,
                'changed_at' => now(),
            ];
        }
        if ($user->role !== $validated['role']) {
            $changes[] = [
                'field_name' => 'role',
                'old_value' => $user->role,
                'new_value' => $validated['role'],
                'changed_by' => auth()->id(),
                'user_id' => $user->id,
                'changed_at' => now(),
            ];
        }

        $data = [
            'name' => $validated['name'],
            'role' => $validated['role'],
            'is_admin' => $validated['role'] === 'admin',
        ];

        $user->update($data);

        foreach ($changes as $change) {
            \DB::table('user_changes')->insert($change);
        }

        Log::info('User updated', [
            'user_id' => $user->id,
            'changes' => $changes,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('users.show', $user)->with('success', 'User updated successfully.');
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
        $user = $request->user();
        Log::info('Profile edit form accessed', ['user_id' => $user->id]);
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $rules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ];

        if (auth()->user()->is_admin) {
            $rules['name'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $data = [
            'email' => $validated['email'],
        ];

        $changes = [];
        if (auth()->user()->is_admin && isset($validated['name']) && $user->name !== $validated['name']) {
            $data['name'] = $validated['name'];
            $changes[] = [
                'field_name' => 'name',
                'old_value' => $user->name,
                'new_value' => $validated['name'],
                'changed_by' => auth()->id(),
                'user_id' => $user->id,
                'changed_at' => now(),
            ];
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        foreach ($changes as $change) {
            \DB::table('user_changes')->insert($change);
        }

        Log::info('Profile updated', [
            'user_id' => $user->id,
            'changes' => $changes,
        ]);
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User deleted', ['user_id' => $user->id]);

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
