<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ScholarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $validSorts = ['a-z', 'z-a', 'newest', 'oldest'];

        if (!in_array($sort, $validSorts, true)) {
            $sort = null;
        }

        $scholars = User::where('role', 'scholar')
            ->when($search, fn($query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('id_member', 'like', "%{$search}%"))
            ->when($sort === 'a-z', fn($query) => $query->orderBy('name', 'asc'))
            ->when($sort === 'z-a', fn($query) => $query->orderBy('name', 'desc'))
            ->when($sort === 'newest', fn($query) => $query->orderBy('created_at', 'desc'))
            ->when($sort === 'oldest', fn($query) => $query->orderBy('created_at', 'asc'))
            ->when(!$sort, fn($query) => $query->orderBy('name', 'asc'))
            ->paginate(10)
            ->withQueryString();

        $totalScholars = User::where('role', 'scholar')->count();
        $activeBorrowers = User::where('role', 'scholar')->whereHas('borrowings', fn($q) => $q->where('status', 'borrowed'))->count();
        $suspended = User::where('role', 'scholar')->whereHas('borrowings', fn($q) => $q->where('status', 'overdue'))->count();

        return view('librarian.manage-scholars.index', compact('scholars', 'search', 'sort', 'totalScholars', 'activeBorrowers', 'suspended'));
    }

    public function create()
    {
        return view('librarian.manage-scholars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'scholar';

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('librarian.manage-scholars')->with('success', 'Scholar added successfully.');
    }

    public function edit(User $scholar)
    {
        return view('librarian.manage-scholars.edit', compact('scholar'));
    }

    public function show(User $scholar)
    {
        return view('librarian.manage-scholars.show', compact('scholar'));
    }

    public function update(Request $request, User $scholar)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $scholar->id,
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($scholar->avatar) {
                \Storage::disk('public')->delete($scholar->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $scholar->update($data);

        return redirect()->route('librarian.manage-scholars')->with('success', 'Scholar updated successfully.');
    }

    public function destroy(User $scholar)
    {
        if ($scholar->avatar) {
            \Storage::disk('public')->delete($scholar->avatar);
        }
        $scholar->delete();

        return redirect()->route('librarian.manage-scholars')->with('success', 'Scholar deleted successfully.');
    }
}
