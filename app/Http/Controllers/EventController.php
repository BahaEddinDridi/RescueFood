<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use LucianoTonet\GroqLaravel\Facades\Groq;
use \LucianoTonet\GroqPHP\GroqException;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $partners = User::all(); // Fetch all users as potential partners
        return view('events.create', compact('partners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'location' => 'required',
            'partner_id' => 'required|exists:users,id',
        ]);

        Event::create($validated);
        return redirect()->route('events.index');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $partners = User::all(); // Fetch all users as potential partners
        return view('events.edit', compact('event', 'partners'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'location' => 'required',
        ]);

        $event->update($validated);
        return redirect()->route('events.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index');
    }


  public function generateDescription(Event $event)
    {
        $eventDetails = [
            'name' => $event->name,
            'location' => $event->location,
            'date' => $event->date,
            'description' => $event->description,
        ];

        try {
            // Generate the description using the Node.js server
            $response = $this->generateDescriptionFromNode($eventDetails);

            if ($response['success']) {
                // Return the event.show view and pass the generated description to it
                return view('events.show', [
                    'event' => $event,
                    'generatedDescription' => $response['generatedDescription']
                ]);
            } else {
                return redirect()->route('events.show', $event->id)
                                 ->with('error', 'Failed to generate description');
            }
        } catch (\Exception $e) {
            \Log::error('Description generation error: ' . $e->getMessage());
            return redirect()->route('events.show', $event->id)
                             ->with('error', 'Error generating description');
        }
    }

    protected function generateDescriptionFromNode($eventDetails)
    {
        $nodeServerUrl = "http://127.0.0.1:3000/generate-description"; // URL of your Node.js server

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $nodeServerUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['eventDetails' => $eventDetails]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlError) {
            throw new \Exception('cURL error: ' . $curlError);
        } elseif ($httpCode !== 200) {
            throw new \Exception("Node server returned HTTP status code {$httpCode}");
        }

        return json_decode($response, true);
    }
}
