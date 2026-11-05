@extends('layouts.layouts')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold">Activiteit toevoegen</h1>
        <p class="mt-2 text-zinc-600 dark:text-zinc-300">
            Maak een nieuwe activiteit voor bewakingen en evenementen.
        </p>

        @if (session('success'))
            <div class="mt-6 rounded-lg bg-green-100 p-4 text-green-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('activiteiten.store') }}" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="type" class="block text-sm font-medium">Type</label>
                <select id="type" name="type" required
                    class="mt-2 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900">
                    <option value="">Kies een type</option>
                    <option value="evenement" @selected(old('type') === 'evenement')>Evenement</option>
                    <option value="bewaking" @selected(old('type') === 'bewaking')>Bewaking</option>
                    <option value="vaartraining" @selected(old('type') === 'vaartraining')>Vaartraining</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="date" class="block text-sm font-medium">Datum</label>
                    <input id="date" name="date" type="date" value="{{ old('date') }}" required
                        class="mt-2 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="time" class="block text-sm font-medium">Tijd</label>
                    <input id="time" name="time" type="time" value="{{ old('time') }}" required
                        class="mt-2 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900">
                    @error('time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium">Locatie</label>
                <input id="location" name="location" type="text" value="{{ old('location') }}" required
                    class="mt-2 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium">Beschrijving</label>
                <textarea id="description" name="description" rows="5" required
                    class="mt-2 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-700">
                Activiteit opslaan
            </button>
        </form>
    </div>
@endsection
