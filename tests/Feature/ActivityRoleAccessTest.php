<?php

use App\Models\User;
use App\Models\Activiteit;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('users cannot open or submit the activity management page', function () {
    $user = User::factory()->create(['role' => 'gebruiker']);

    $this->actingAs($user)
        ->get(route('planner.create'))
        ->assertForbidden();

    $this->actingAs($user)
        ->post(route('activiteiten.store'), [])
        ->assertForbidden();
});

test('users do not see activity management links', function () {
    $user = User::factory()->create(['role' => 'gebruiker']);

    $this->actingAs($user)
        ->get('/')
        ->assertOk()
        ->assertDontSee('Nieuwe activiteit');
});

test('planners can open the activity management page', function () {
    $planner = User::factory()->create(['role' => 'planner']);

    $this->actingAs($planner)
        ->get(route('planner.create'))
        ->assertOk();
});

test('planner can create an activity with a deadline and required roles', function () {
    $planner = User::factory()->create(['role' => 'planner']);

    $this->actingAs($planner)
        ->post(route('activiteiten.store'), [
            'type' => 'bewaking',
            'date' => '2026-12-01',
            'time' => '18:00',
            'deadline_at' => '2026-11-25 18:00',
            'location' => 'Brandweerkazerne',
            'description' => 'Nachtbewaking',
            'requirements' => [
                'postkommandant' => ['quantity' => 1, 'diploma' => 'postkommandant'],
                'kommandant' => ['quantity' => 1, 'diploma' => 'kommandant'],
                'lid' => ['quantity' => 3, 'diploma' => ''],
            ],
        ])
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('activiteiten', [
        'location' => 'Brandweerkazerne',
    ]);
});

test('user cannot signup for a role without the required diploma', function () {
    $activity = Activiteit::create([
        'type' => 'bewaking',
        'date' => '2026-12-01',
        'time' => '18:00',
        'deadline_at' => '2026-11-25 18:00',
        'location' => 'Kazerne',
        'description' => 'Bewaking',
        'required_roles' => [
            [
                'role' => 'kommandant',
                'quantity' => 1,
                'diploma' => 'kommandant',
            ],
        ],
    ]);
    $user = User::factory()->create([
        'role' => 'gebruiker',
        'diplomas' => [],
    ]);

    $this->actingAs($user)
        ->post(route('activiteiten.signup', $activity), ['role' => 'kommandant'])
        ->assertSessionHasErrors('signup');

    $this->assertDatabaseMissing('activiteit_signups', [
        'activiteit_id' => $activity->id,
        'user_id' => $user->id,
    ]);
});
