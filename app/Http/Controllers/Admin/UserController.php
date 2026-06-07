<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%");
            });
        }

        if ($request->status === 'banned') {
            $query->where('is_banned', true);
        } elseif ($request->status === 'active') {
            $query->where('is_banned', false);
        }

        $users = $query->withCount('listings')->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleBan(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak bisa memblokir admin.');
        }

        $user->update(['is_banned' => !$user->is_banned]);

        $action = $user->is_banned ? 'diblokir' : 'diaktifkan kembali';
        return back()->with('success', "User {$user->name} berhasil {$action}.");
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak bisa menghapus admin.');
        }

        $user->delete();

        return back()->with('success', "User berhasil dihapus.");
    }
}
