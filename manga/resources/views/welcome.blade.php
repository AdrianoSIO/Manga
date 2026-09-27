<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manga Collection</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen text-zinc-950 antialiased"
    style="
        background-color: #f7f3eb;
        background-image:
            linear-gradient(rgba(24,24,27,.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(24,24,27,.025) 1px, transparent 1px);
        background-size: 28px 28px;
    "
>

    {{-- ============================================================
        NAVIGATION
    ============================================================ --}}
    <header class="border-b-2 border-zinc-950 bg-[#fffdf8]">

        <div
            class="mx-auto flex max-w-7xl items-center
                   justify-between px-4 py-4 sm:px-6 lg:px-8"
        >

            {{-- Logo --}}
            <a
                href="{{ url('/') }}"
                class="group flex items-center gap-3"
            >

                <div
                    class="flex h-10 w-10 items-center justify-center
                           bg-red-600 text-sm font-black text-white
                           shadow-[3px_3px_0_#18181b]"
                >
                    漫
                </div>

                <div>
                    <p class="text-sm font-black uppercase tracking-tight">
                        Manga Collection
                    </p>

                    <p
                        class="text-[8px] font-bold uppercase
                               tracking-[0.3em] text-zinc-400"
                    >
                        漫画コレクション
                    </p>
                </div>

            </a>


            {{-- Connexion --}}
            @if (Route::has('login'))

                <nav class="flex items-center gap-2">

                    @auth

                        <a
                            href="{{ route('collection.index') }}"
                            class="border-2 border-zinc-950
                                   bg-red-600 px-4 py-2
                                   text-xs font-black uppercase
                                   tracking-wider text-white
                                   shadow-[3px_3px_0_#18181b]
                                   transition
                                   hover:-translate-x-[1px]
                                   hover:-translate-y-[1px]
                                   hover:bg-red-700
                                   hover:shadow-[4px_4px_0_#18181b]"
                        >
                            Ma collection
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="px-3 py-2 text-xs font-black
                                   uppercase tracking-wider text-zinc-600
                                   transition hover:text-red-600"
                        >
                            Connexion
                        </a>


                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="border-2 border-zinc-950
                                       bg-red-600 px-4 py-2
                                       text-xs font-black uppercase
                                       tracking-wider text-white
                                       shadow-[3px_3px_0_#18181b]
                                       transition
                                       hover:-translate-x-[1px]
                                       hover:-translate-y-[1px]
                                       hover:bg-red-700"
                            >
                                Inscription
                            </a>

                        @endif

                    @endauth

                </nav>

            @endif

        </div>

    </header>


    {{-- ============================================================
        HERO
    ============================================================ --}}
    <main class="relative overflow-hidden">

        {{-- Kanji décoratif --}}
        <div
            class="pointer-events-none absolute
                   -right-10 top-10 select-none
                   text-[14rem] font-black leading-none
                   text-red-600/[0.04]
                   sm:text-[22rem]
                   lg:right-10 lg:text-[30rem]"
        >
            漫
        </div>


        <div
            class="relative z-10 mx-auto grid min-h-[calc(100vh-74px)]
                   max-w-7xl items-center gap-12
                   px-4 py-16 sm:px-6
                   lg:grid-cols-2 lg:px-8"
        >

            {{-- ====================================================
                GAUCHE
            ===================================================== --}}
            <div>

                <div class="mb-6 flex items-center gap-3">

                    <span class="h-[3px] w-10 bg-red-600"></span>

                    <p
                        class="text-[10px] font-black uppercase
                               tracking-[0.4em] text-red-600"
                    >
                        私の漫画 • My Manga
                    </p>

                </div>


                <h1
                    class="max-w-3xl text-5xl font-black
                           leading-[0.95] tracking-[-0.055em]
                           text-zinc-950
                           sm:text-6xl lg:text-7xl"
                >
                    Ta collection
                    <br>

                    <span class="text-red-600">
                        manga.
                    </span>

                    <br>

                    Simplement.
                </h1>


                <p
                    class="mt-7 max-w-lg text-base
                           font-medium leading-relaxed
                           text-zinc-500 sm:text-lg"
                >
                    Garde une trace de tes licences et de tous les
                    tomes que tu possèdes, sans prise de tête.
                </p>


                {{-- Actions --}}
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">

                    @auth

                        <a
                            href="{{ route('collection.index') }}"
                            class="inline-flex items-center justify-center
                                   border-2 border-zinc-950
                                   bg-red-600 px-7 py-4
                                   text-sm font-black uppercase
                                   tracking-wider text-white
                                   shadow-[5px_5px_0_#18181b]
                                   transition
                                   hover:-translate-x-[2px]
                                   hover:-translate-y-[2px]
                                   hover:bg-red-700
                                   hover:shadow-[7px_7px_0_#18181b]"
                        >
                            Voir ma collection
                            <span class="ml-3">→</span>
                        </a>

                    @else

                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center
                                       border-2 border-zinc-950
                                       bg-red-600 px-7 py-4
                                       text-sm font-black uppercase
                                       tracking-wider text-white
                                       shadow-[5px_5px_0_#18181b]
                                       transition
                                       hover:-translate-x-[2px]
                                       hover:-translate-y-[2px]
                                       hover:bg-red-700
                                       hover:shadow-[7px_7px_0_#18181b]"
                            >
                                Commencer
                                <span class="ml-3">→</span>
                            </a>

                        @endif


                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center justify-center
                                   border-2 border-zinc-950
                                   bg-[#fffdf8] px-7 py-4
                                   text-sm font-black uppercase
                                   tracking-wider text-zinc-950
                                   transition hover:bg-zinc-950
                                   hover:text-white"
                        >
                            Se connecter
                        </a>

                    @endauth

                </div>


                {{-- Signature --}}
                <div
                    class="mt-12 flex items-center gap-3
                           text-[9px] font-black uppercase
                           tracking-[0.3em] text-zinc-400"
                >
                    <span class="h-px w-8 bg-zinc-300"></span>

                    漫画を集める

                    <span class="h-px w-8 bg-zinc-300"></span>
                </div>

            </div>


            {{-- ====================================================
                DROITE — FAUSSE COLLECTION
            ===================================================== --}}
            <div class="relative hidden lg:block">

                {{-- Bloc rouge derrière --}}
                <div
                    class="absolute -right-5 -top-5
                           h-full w-full bg-red-600"
                ></div>


                <div
                    class="relative border-2 border-zinc-950
                           bg-[#fffdf8]
                           shadow-[10px_10px_0_#18181b]"
                >

                    {{-- Haut --}}
                    <div
                        class="flex items-center justify-between
                               border-b-2 border-zinc-950 p-5"
                    >

                        <div>

                            <p
                                class="text-[9px] font-black uppercase
                                       tracking-[0.3em] text-red-600"
                            >
                                本棚 • Bibliothèque
                            </p>

                            <h2 class="mt-1 text-xl font-black">
                                Ma collection
                            </h2>

                        </div>


                        <div
                            class="flex h-12 w-12 items-center
                                   justify-center bg-zinc-950
                                   font-black text-white"
                        >
                            漫
                        </div>

                    </div>


                    {{-- Manga 1 --}}
                    <div class="border-b border-zinc-200 p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-lg font-black">
                                    One Piece
                                </p>

                                <p
                                    class="mt-1 text-[9px] font-bold
                                           uppercase tracking-widest
                                           text-zinc-400"
                                >
                                    Adventure • Action
                                </p>

                            </div>

                            <span
                                class="bg-red-600 px-2 py-1
                                       text-[9px] font-black
                                       uppercase text-white"
                            >
                                3 tomes
                            </span>

                        </div>


                        <div class="mt-4 flex gap-2">

                            @foreach ([1, 2, 3] as $numero)

                                <span
                                    class="flex h-9 min-w-9
                                           items-center justify-center
                                           bg-zinc-950 px-2
                                           text-xs font-black text-white"
                                >
                                    {{ $numero }}
                                </span>

                            @endforeach

                        </div>

                    </div>


                    {{-- Manga 2 --}}
                    <div class="border-b border-zinc-200 p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-lg font-black">
                                    Tokyo Ghoul
                                </p>

                                <p
                                    class="mt-1 text-[9px] font-bold
                                           uppercase tracking-widest
                                           text-zinc-400"
                                >
                                    Horreur • Surnaturel
                                </p>

                            </div>

                            <span
                                class="bg-zinc-950 px-2 py-1
                                       text-[9px] font-black
                                       uppercase text-white"
                            >
                                14 tomes
                            </span>

                        </div>


                        <div class="mt-4 flex flex-wrap gap-2">

                            @foreach ([1, 2, 3, 4, 5, 6, 7] as $numero)

                                <span
                                    class="flex h-9 min-w-9
                                           items-center justify-center
                                           bg-zinc-950 px-2
                                           text-xs font-black text-white"
                                >
                                    {{ $numero }}
                                </span>

                            @endforeach

                            <span
                                class="flex h-9 items-center
                                       justify-center border-2
                                       border-zinc-300 px-3
                                       text-xs font-black text-zinc-400"
                            >
                                +7
                            </span>

                        </div>

                    </div>


                    {{-- Manga 3 --}}
                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-lg font-black">
                                    Mha
                                </p>

                                <p
                                    class="mt-1 text-[9px] font-bold
                                           uppercase tracking-widest
                                           text-zinc-400"
                                >
                                    Action • Fantastique
                                </p>

                            </div>

                            <span
                                class="bg-red-600 px-2 py-1
                                       text-[9px] font-black
                                       uppercase text-white"
                            >
                                doublon
                            </span>

                        </div>


                        <div class="mt-4 flex gap-2">

                            <span
                                class="flex h-9 min-w-9 items-center
                                       justify-center bg-red-600
                                       text-xs font-black text-white"
                            >
                                1
                            </span>

                            <span
                                class="flex h-9 min-w-9 items-center
                                       justify-center bg-red-600
                                       text-xs font-black text-white"
                            >
                                1
                            </span>

                            @foreach ([2, 3, 4, 5] as $numero)

                                <span
                                    class="flex h-9 min-w-9 items-center
                                           justify-center bg-zinc-950
                                           text-xs font-black text-white"
                                >
                                    {{ $numero }}
                                </span>

                            @endforeach

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div
                        class="flex items-center justify-between
                               border-t-2 border-zinc-950
                               bg-[#f7f3eb] px-5 py-3"
                    >

                        <p
                            class="text-[9px] font-black uppercase
                                   tracking-[0.25em] text-zinc-400"
                        >
                            Manga Collection
                        </p>

                        <p class="font-black text-red-600">
                            漫画
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </main>

</body>
</html>