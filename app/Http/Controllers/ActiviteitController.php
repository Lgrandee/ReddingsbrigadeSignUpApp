<?php

namespace App\Http\Controllers;

use App\Models\Activiteit;
use Illuminate\Http\Request;

class ActiviteitController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'activiteiten' => Activiteit::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('planner.create');
    }

    // Slaat de gegevens op
    public function store(Request $request)
    {
        // Valideer de invoer
        $validated = $request->validate([
            'type' => 'required|in:evenement,bewaking,vaartraining',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Sla op in de database
        Activiteit::create($validated);

        // Stuur de planner terug met een succesmelding
        return redirect()->route('planner.create')->with('success', 'De activiteit is succesvol toegevoegd!');
    }
}
