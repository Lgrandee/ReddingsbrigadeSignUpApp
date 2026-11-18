<?php

namespace App\Http\Controllers;

use App\Models\Activiteit;
use App\Models\ActiviteitSignup;
use Illuminate\Http\Request;

class ActiviteitController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'activiteiten' => Activiteit::with('signups')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('planner.create');
    }

    // Slaat de gegevens op
    public function store(Request $request)
    {
        $validated = $this->validateActivity($request);

        $requiredRoles = $this->requiredRoles($validated);

        if ($requiredRoles === []) {
            return back()->withInput()->withErrors([
                'requirements' => 'Vul voor ten minste één functie een aantal groter dan nul in.',
            ]);
        }

        Activiteit::create([
            ...$validated,
            'required_roles' => $requiredRoles,
        ]);

        return redirect()->route('planner.create')->with('success', 'De activiteit is succesvol toegevoegd!');
    }

    public function edit(Activiteit $activiteit)
    {
        return view('planner.create', ['activiteit' => $activiteit]);
    }

    public function update(Request $request, Activiteit $activiteit)
    {
        $validated = $this->validateActivity($request);
        $requiredRoles = $this->requiredRoles($validated);

        if ($requiredRoles === []) {
            return back()->withInput()->withErrors([
                'requirements' => 'Vul voor ten minste één functie een aantal groter dan nul in.',
            ]);
        }

        $activiteit->update([
            ...$validated,
            'required_roles' => $requiredRoles,
        ]);

        return redirect()->route('activiteiten')->with('success', 'De activiteit is gewijzigd!');
    }

    public function destroy(Activiteit $activiteit)
    {
        $activiteit->delete();

        return redirect()->route('activiteiten')->with('success', 'De activiteit is verwijderd!');
    }

    private function validateActivity(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:evenement,bewaking,vaartraining',
            'date' => 'required|date',
            'time' => 'required',
            'deadline_at' => 'required|date|before_or_equal:date',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|array',
            'requirements.*.quantity' => 'nullable|integer|min:0|max:100',
            'requirements.*.diploma' => 'nullable|string|in:postkommandant,kommandant',
        ]);
    }

    private function requiredRoles(array $validated): array
    {
        $requiredRoles = collect($validated['requirements'] ?? [])
            ->map(fn (array $requirement, string $role) => [
                'role' => $role,
                'quantity' => (int) ($requirement['quantity'] ?? 0),
                'diploma' => $requirement['diploma'] ?: null,
            ])
            ->filter(fn (array $requirement) => $requirement['quantity'] > 0)
            ->values()
            ->all();

        return $requiredRoles;
    }

    public function signup(Request $request, Activiteit $activiteit)
    {
        $validated = $request->validate([
            'role' => 'required|string|in:postkommandant,kommandant,lid',
        ]);

        if ($activiteit->deadline_at && now()->greaterThan($activiteit->deadline_at)) {
            return back()->withErrors(['signup' => 'De uiterste aanmeldtijd is verstreken.']);
        }

        $requirement = collect($activiteit->required_roles ?? [])
            ->first(fn (array $item) => $item['role'] === $validated['role']);

        if (! $requirement) {
            return back()->withErrors(['signup' => 'Voor deze functie wordt niet gezocht.']);
        }

        $signedUpCount = $activiteit->signups()
            ->where('role', $validated['role'])
            ->count();

        if ($signedUpCount >= $requirement['quantity']) {
            return back()->withErrors(['signup' => 'Deze functie is al volledig bezet.']);
        }

        $requiredDiploma = $requirement['diploma'] ?? null;
        if ($requiredDiploma && ! in_array($requiredDiploma, $request->user()->diplomas ?? [], true)) {
            return back()->withErrors([
                'signup' => "Je hebt het vereiste diploma '{$requiredDiploma}' niet.",
            ]);
        }

        ActiviteitSignup::updateOrCreate(
            [
                'activiteit_id' => $activiteit->id,
                'user_id' => $request->user()->id,
            ],
            ['role' => $validated['role']],
        );

        return back()->with('success', 'Je bent aangemeld voor de dienst.');
    }

    public function cancelSignup(Request $request, Activiteit $activiteit)
    {
        $activiteit->signups()
            ->where('user_id', $request->user()->id)
            ->delete();

        return back()->with('success', 'Je aanmelding is verwijderd.');
    }

    public function updateDiplomas(Request $request)
    {
        $validated = $request->validate([
            'diplomas' => 'array',
            'diplomas.*' => 'in:postkommandant,kommandant',
        ]);

        $request->user()->update([
            'diplomas' => array_values($validated['diplomas'] ?? []),
        ]);

        return back()->with('success', 'Je diploma\'s zijn opgeslagen.');
    }
}
