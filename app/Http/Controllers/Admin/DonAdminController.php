<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Don;
use App\Models\User;

class DonAdminController extends Controller
{
    public function index()
    {
        $don = Don::paginate(10);
        return view('admin.dons.index', compact('don'));
    }

    public function create()
    {
        $users = User::all(); 
        return view('admin.dons.create', compact('users')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type_aliment' => 'required|string|max:255',
            'quantité' => 'required|integer|min:1',
            'date_peremption' => 'required|date',
            'date_don' => 'required|date',
            'statut' => 'required|string|max:50',
        ]);

        Don::create($request->all());
        
        return redirect()->route('admin.dons.index')->with('success', 'Don ajouté avec succès');
    }


    public function edit($id)
{
    $don = Don::findOrFail($id); 
    $users = User::all(); 
    return view('admin.dons.edit', compact('don', 'users')); 
}

public function update(Request $request, $id)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'type_aliment' => 'required|string|max:255',
        'quantité' => 'required|integer|min:1',
        'date_peremption' => 'required|date',
        'date_don' => 'required|date',
        'statut' => 'required|string|max:50',
    ]);

    $don = Don::findOrFail($id); 
    $don->update($request->all()); 

    return redirect()->route('admin.dons.index')->with('success', 'Don modifié avec succès');
}


public function destroy($id)
{
    $don = Don::findOrFail($id);
    $don->delete(); 

    return redirect()->route('admin.dons.index')->with('success', 'Don supprimé avec succès');
}
}
