<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Don;
use Illuminate\Support\Facades\Auth;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $reservations = Reservation::with('don')->get();
        return view('reservations.index', compact('reservations')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Récupère uniquement les dons avec le statut "disponible"
    $donsDisponibles = Don::where('statut', 'disponible')->get();

    // Si aucun don n'est disponible, redirigez avec un message d'erreur
    if ($donsDisponibles->isEmpty()) {
        return redirect()->route('reservations.index')
            ->withErrors(['no_dons' => 'Vous ne pouvez pas ajouter une nouvelle réservation, car il n\'y a pas de don disponible pour le moment.']);
    }

    return view('reservations.create', compact('donsDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  

    public function store(Request $request)
    {
        // Ensure the user is authenticated and has the 'beneficiaire' role
        $user = Auth::user();
        if (!$user || !$user->isBeneficiaire()) {
            return redirect()->route('reservations.index')
                ->withErrors(['not_allowed' => 'Vous n\'êtes pas autorisé à ajouter une réservation.']);
        }

        $request->validate([
            'date_reservation' => 'required|date|after_or_equal:today',
            'type_aliment' => 'required|string'
        ]);

        // Find an available 'Don' with the specified type
        $don = Don::where('type_aliment', $request->type_aliment)
                    ->where('statut', 'disponible')
                    ->first();

        if (!$don) {
            return redirect()->back()->withErrors(['type_aliment' => 'Aucun don disponible pour ce type d\'aliment.']);
        }

            // Vérifier si le bénéficiaire a déjà réservé ce don
        $existingReservation = Reservation::where('beneficiare_id', $user->id)
        ->where('don_id', $don->id)
        ->exists();

        if ($existingReservation) {
            return redirect()->back()->withErrors(['duplicate' => 'Vous avez déjà réservé ce type d\'aliment.']);
        }


        Reservation::create([
            'beneficiare_id' => $user->id, // Set the logged-in user as the beneficiare
            'don_id' => $don->id,
            'date_reservation' => $request->date_reservation,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation créée avec succès.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // Récupérer la réservation demandée avec le don associé
    $reservation = Reservation::with('don')->findOrFail($id);

    // Récupérer toutes les réservations pour le calcul du numéro
    $reservations = Reservation::with('don')->orderBy('date_reservation')->get(); // Trier selon la logique souhaitée

    // Calculer le numéro de réservation
    $reservationNumber = $reservations->search(function ($item) use ($reservation) {
        return $item->id === $reservation->id;
    }) + 1; // +1 pour obtenir un numéro basé sur 1

    // Passer la réservation et le numéro de réservation à la vue
    return view('reservations.show', compact('reservation', 'reservationNumber'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $reservation = Reservation::with('don')->findOrFail($id);
        $donsDisponibles = Don::where('statut', 'disponible')->get(); // Récupérer les dons disponibles
        return view('reservations.edit', compact('reservation', 'donsDisponibles'));
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
            // Validation des données
        $request->validate([
            'date_reservation' => 'required|date|after_or_equal:today',
            'type_aliment' => 'required|string',
        ]);

        $reservation = Reservation::findOrFail($id);
        $user = Auth::user(); // Obtenez l'utilisateur connecté

        // Vérifiez si le type d'aliment sélectionné est disponible
        $don = Don::where('type_aliment', $request->type_aliment)
                    ->where('statut', 'disponible')
                    ->first();

        if (!$don) {
            return redirect()->back()->withErrors(['type_aliment' => 'Aucun don disponible pour ce type d\'aliment.']);
        }

        // Vérifiez si l'utilisateur a déjà réservé ce don
        $existingReservation = Reservation::where('beneficiare_id', $user->id)
            ->where('don_id', $don->id)
            ->where('id', '!=', $reservation->id) // Exclure la réservation en cours de mise à jour
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->withErrors(['duplicate' => 'Vous avez déjà réservé ce type d\'aliment.']);
        }

        // Mettre à jour la réservation
        $reservation->update([
            'date_reservation' => $request->date_reservation,
            'don_id' => $don->id, // Mettez à jour avec le nouvel don
    ]);

    return redirect()->route('reservations.index')
        ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id); 
        $reservation->delete(); 
    
        return redirect()->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
    
}
