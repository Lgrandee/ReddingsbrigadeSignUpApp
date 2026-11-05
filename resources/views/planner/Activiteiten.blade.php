@extends('layouts.layouts')

@section('content')
    <div class="flex flex-col items-start gap-4 max-w-2xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800">Activiteiten</h1>
        
        <p class="text-gray-600 text-base">
            Maak hier nieuwe activiteiten voor bewakingen en evenementen.
        </p>
        
        <a href="{{ route('planner.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-5 rounded-lg shadow-sm transition duration-150 ease-in-out">
            Nieuwe activiteit
        </a>
    </div>
@endsection