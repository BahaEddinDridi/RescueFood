<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Don;

class DonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $don = Don::paginate(6);
    return view('Don.View', compact('don'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('Don.AddDon');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_aliment' => 'required',
            'quantité' => 'required',
            'date_peremption' => 'required',
            'date_don' => 'required',
            'statut' => 'required',
        ]);

        Don::create($request->all());

        return redirect()->route('Dons.index')->with('success', 'Don créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $don = Don::find($id);
        return view('Don.showDon', compact('don'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $don = Don::find($id);
        return view('Don.Edit', compact('don'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type_aliment' => 'required',
            'quantité' => 'required',
            'date_peremption' => 'required',
            'date_don' => 'required',
            'statut' => 'required',
        ]);

        $don = Don::find($id);
        $don->update($request->all());

        return redirect()->route('Dons.index')->with('success', 'Don updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Don::find($id)->delete();

        return redirect()->route('Dons.index')->with('success', 'Don deleted successfully.');
    }
}
