<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ isset($title) ? $title . ' — ' : '' }}Manga Collection
    </title>

    {{-- Applique le thème avant l'affichage pour éviter le flash blanc --}}
    <script>
        (() => {
            const theme = localStorage.getItem('theme') || 'auto';

            const dark =
                theme === 'dark' ||
                (
                    theme === 'auto' &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                );

            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased
           bg-[#f7f3eb] text-zinc-900
           transition-colors duration-200
           dark:bg-[#111113] dark:text-zinc-100"
>
    <div class="min-h-screen">

        @include('layouts.navigation')

        @isset($header)
            <header
                class="border-b border-zinc-200 bg-[#fffdf8] shadow
                       dark:border-zinc-800 dark:bg-[#18181b]"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>

    </div>
</body>
</html>