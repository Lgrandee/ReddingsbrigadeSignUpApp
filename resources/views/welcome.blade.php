@extends('layouts.layouts')


@section('content')
    <div class="mx-auto max-w-4xl p-6">
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Activiteiten</h1>
            @can('manage-activities')
                <a href="{{ route('planner.create') }}"
                   class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white shadow-sm transition hover:bg-blue-700">
                    Nieuwe activiteit
                </a>
            @endcan
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @forelse($activiteiten as $activiteit)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-xl font-semibold text-blue-600">{{ $activiteit->type }}</h2>
                    <p class="mt-2 text-sm text-gray-600">{{ $activiteit->description }}</p>

                    <div class="mt-4 space-y-1 border-t border-gray-100 pt-3 text-xs text-gray-500">
                        <p>Datum: {{ $activiteit->date }} om {{ $activiteit->time }}</p>
                        <p>Locatie: {{ $activiteit->location }}</p>
                        @if ($activiteit->deadline_at)
                            <p>Aanmelden tot: {{ $activiteit->deadline_at->format('d-m-Y H:i') }}</p>
                        @endif
                    </div>

                    @if ($activiteit->required_roles)
                        <div class="mt-4 space-y-1 text-sm">
                            @foreach ($activiteit->required_roles as $requirement)
                                @php
                                    $count = $activiteit->signups->where('role', $requirement['role'])->count();
                                    $complete = $count >= $requirement['quantity'];
                                @endphp
                                <p class="{{ $complete ? 'text-green-700' : 'text-amber-700' }}">
                                    {{ ucfirst($requirement['role']) }}: {{ $count }}/{{ $requirement['quantity'] }}
                                    @if ($requirement['diploma'])
                                        — diploma: {{ $requirement['diploma'] }}
                                    @endif
                                </p>
                            @endforeach
                        </div>
                    @endif

                    @can('manage-activities')
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('activiteiten.edit', $activiteit)"
                               class="rounded-lg border border-zinc-300 px-3 py-2 text-sm hover:bg-zinc-100">
                                Bewerken
                            </a>
                            <form method="POST" action="{{ route('activiteiten.destroy', $activiteit) }}"
                                onsubmit="return confirm('Deze activiteit verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded-lg border border-red-300 px-3 py-2 text-sm text-red-700 hover:bg-red-50">
                                    Verwijderen
                                </button>
                            </form>
                        </div>
                    @endcan

                    @auth
                        @php
                            $userSignup = $activiteit->signups->firstWhere('user_id', auth()->id());
                        @endphp
                        @if ($userSignup)
                            <form method="POST" action="{{ route('activiteiten.cancel-signup', $activiteit) }}" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-zinc-300 px-3 py-2 text-sm">
                                    Aanmelding verwijderen
                                </button>
                            </form>
                        @elseif (! $activiteit->deadline_at || now()->lessThanOrEqualTo($activiteit->deadline_at))
                            <form method="POST" action="{{ route('activiteiten.signup', $activiteit) }}" class="mt-4 flex items-end gap-2">
                                @csrf
                                <div>
                                    <label for="role_{{ $activiteit->id }}" class="block text-xs">Aanmelden als</label>
                                    <select id="role_{{ $activiteit->id }}" name="role"
                                        class="mt-1 rounded-lg border-zinc-300 text-sm">
                                        @foreach ($activiteit->required_roles ?? [] as $requirement)
                                            <option value="{{ $requirement['role'] }}">{{ $requirement['role'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="rounded-lg bg-zinc-900 px-3 py-2 text-sm text-white">
                                    Aanmelden
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="col-span-2 text-gray-500">Er zijn momenteel nog geen activiteiten aangemaakt.</p>
            @endforelse
        </div>
    </div>
@endsection