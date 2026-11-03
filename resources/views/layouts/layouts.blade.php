<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-zinc-100">
    <header class="w-full border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <nav class="mx-auto flex w-full max-w-7xl flex-wrap items-center justify-between px-4 py-3 sm:flex-nowrap lg:px-8"
            aria-label="Main navigation">
            <a class="order-1 flex-none text-xl font-semibold text-zinc-950 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 dark:text-white dark:focus:ring-offset-zinc-900"
                href="{{ route('home') }}">Reddingsbrigade</a>
            <div class="order-3 flex items-center gap-2 sm:order-3">
            <button type="button"
                class="relative flex size-9 items-center justify-center rounded-lg border border-zinc-200 text-zinc-700 shadow-sm hover:bg-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 sm:hidden dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                id="navbar-toggle" aria-expanded="false" aria-controls="navbar-menu" aria-label="Toggle navigation">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                </svg>
            </button>
            @guest
                <a class="inline-flex items-center rounded-lg border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-700 shadow-sm hover:bg-zinc-100 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                    href="{{ route('login') }}">Log in</a>
            @endguest
        </div>
        <div id="navbar-menu" class="hidden basis-full sm:order-2 sm:block sm:basis-auto" role="region">
            <div class="mt-4 flex flex-col gap-4 sm:mt-0 sm:flex-row sm:items-center sm:gap-6">
                <a class="text-sm font-medium text-zinc-950 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 dark:text-white"
                    href="{{ route('home') }}" aria-current="page">Home</a>
                <a class="text-sm text-zinc-600 hover:text-zinc-950 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 dark:text-zinc-300 dark:hover:text-white"
                    href="#about">About</a>
                <a class="text-sm text-zinc-600 hover:text-zinc-950 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 dark:text-zinc-300 dark:hover:text-white"
                    href="#contact">Contact</a>
            </div>
        </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>


 <footer class="w-full border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mx-auto flex w-full max-w-7xl flex-wrap items-center justify-between px-4 py-3 sm:flex-nowrap lg:px-8">
            <p class="text-sm text-zinc-600 dark:text-zinc-300">&copy; {{ date('Y') }} Reddingsbrigade. All rights reserved.</p>
            <div class="mt-2 flex gap-4 sm:mt-0">
                <a href="#" class="text-sm text-zinc-600 hover:text-zinc-950 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 dark:text-zinc-300 dark:hover:text-white">Privacy Policy</a>
                <a href="#" class="text-sm text-zinc-600 hover:text-zinc-950 focus:outline-hidden focus:ring-2 focus:ring-zinc-500 dark:text-zinc-300 dark:hover:text-white">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>

</html>