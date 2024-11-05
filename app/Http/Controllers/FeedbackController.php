<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Feedback::all(); 

        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedbacks.create');
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
            'type_feedback' => 'required|in:don,evenement,reservation',
            'contenu_feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'type_feedback.required' => 'Le type de feedback est obligatoire.',
            'contenu_feedback.required' => 'Le contenu du feedback est obligatoire.',
            'rating.required' => 'Veuillez sélectionner une note !',
        ]);

        // Crée un nouveau feedback avec l'ID de l'utilisateur connecté
        Feedback::create([
            'user_id' => Auth::id(), // Récupérer l'ID de l'utilisateur connecté
            'type_feedback' => $request->type_feedback,
            'contenu_feedback' => $request->contenu_feedback,
            'rating' => $request->rating,
        ]);

        return redirect()->route('feedbacks.index')
            ->with('success', 'Feedback created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id); 
        return view('feedbacks.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id); 
        return view('feedbacks.edit', compact('feedback'));
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
            'type_feedback' => 'required|in:don,evenement,reservation', 
            'contenu_feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5', // Ajoutez cette ligne pour valider la note
        ]);
    
        $feedback = Feedback::findOrFail($id);
        
        // Mettez à jour les champs 'type_feedback', 'contenu_feedback' et 'rating'
        $feedback->update($request->only(['type_feedback', 'contenu_feedback', 'rating']));  
    
        return redirect()->route('feedbacks.index')
            ->with('success', 'Feedback updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); 
        $feedback->delete(); 

        return redirect()->route('feedbacks.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}
