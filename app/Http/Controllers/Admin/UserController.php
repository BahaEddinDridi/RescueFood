<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', 
            'phone_number' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date',
            'sector' => 'nullable|string|max:255',
            'association_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'role' => 'required|in:admin,donateur,beneficiaire,transporteur',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        try {
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            }
    
            User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']), 
                'phone_number' => $validated['phone_number'],
                'birthdate' => $validated['birthdate'],
                'sector' => $validated['sector'],
                'association_name' => $validated['association_name'],
                'city' => $validated['city'],
                'bio' => $validated['bio'],
                'role' => $validated['role'],
                'profile_picture' => $profilePicturePath, 
            ]);
    
            return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! Please try again.');
        }
    }
    

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user->birthdate = $user->birthdate ? $user->birthdate->format('Y-m-d') : null;
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,donateur,beneficiaire,transporteur',
            'sector' => 'nullable|string',
            'association_name' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $user->update($request->except('password', 'password_confirmation', 'profile_picture'));
    
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }
    
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index');
    }
  
}
