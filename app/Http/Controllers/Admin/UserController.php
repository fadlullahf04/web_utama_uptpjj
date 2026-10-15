<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,editor,staf',
            'phone' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|max:3072',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = asset('storage/'.$request->file('avatar')->store('avatars', 'public'));
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'avatar' => $avatarPath,
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Pengguna CMS baru berhasil ditambahkan!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,editor,staf',
            'phone' => 'nullable|string|max:50',
            'avatar' => 'nullable|image|max:3072',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('avatar')) {
            $userData['avatar'] = asset('storage/'.$request->file('avatar')->store('avatars', 'public'));
        }

        if (! empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return back()->with('success', 'Data pengguna CMS berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
