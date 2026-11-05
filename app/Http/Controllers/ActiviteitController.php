<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activiteit;
class ActiviteitController extends Controller
{
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
        activiteit::create($validated);

        // Stuur de planner terug met een succesmelding
        return redirect()->route('planner.create')->with('success', 'De activiteit is succesvol toegevoegd!');
    }
}
