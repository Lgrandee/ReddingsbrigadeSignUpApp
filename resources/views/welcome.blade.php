@extends('layouts.layouts')


@section('content')
    <div class="mx-auto max-w-4xl p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Activiteiten</h1>
            <a href="{{ route('planner.create') }}"
               class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white shadow-sm transition hover:bg-blue-700">
                Nieuwe activiteit
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @forelse($activiteiten as $activiteit)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <h2 class="text-xl font-semibold text-blue-600">{{ $activiteit->type }}</h2>
                    <p class="mt-2 text-sm text-gray-600">{{ $activiteit->description }}</p>

                    <div class="mt-4 space-y-1 border-t border-gray-100 pt-3 text-xs text-gray-500">
                        <p>Datum: {{ $activiteit->date }} om {{ $activiteit->time }}</p>
                        <p>Locatie: {{ $activiteit->location }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-2 text-gray-500">Er zijn momenteel nog geen activiteiten aangemaakt.</p>
            @endforelse
        </div>
    </div>
@endsection