<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        @if (session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('diplomas.update') }}"
            class="rounded-xl border border-neutral-200 p-5 dark:border-neutral-700">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-semibold">Mijn diploma's</h2>
            <div class="mt-4 flex flex-wrap gap-6">
                @foreach (['postkommandant' => 'Postkommandant', 'kommandant' => 'Kommandant'] as $diploma => $label)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="diplomas[]" value="{{ $diploma }}"
                            @checked(in_array($diploma, auth()->user()->diplomas ?? [], true))>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
            <button type="submit"
                class="mt-4 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white">
                Diploma's opslaan
            </button>
        </form>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>
