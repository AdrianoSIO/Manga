<nav
    x-data="{ open: false }"
    class="border-b border-zinc-200 bg-[#fffdf8]"
>
    {{-- ============================================================
        NAVIGATION PRINCIPALE
    ============================================================ --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 justify-between">

            {{-- ====================================================
                GAUCHE : LOGO + LIENS
            ===================================================== --}}
            <div class="flex">

                {{-- Logo --}}
                <div class="flex shrink-0 items-center">

                    <a
                        href="{{ route('collection.index') }}"
                        class="group flex items-center gap-3"
                    >
                        {{-- Petit logo japonais --}}
                        <div
                            class="flex h-9 w-9 items-center justify-center
                                   bg-red-600 text-xs font-black text-white
                                   shadow-[2px_2px_0_#18181b]
                                   transition
                                   group-hover:bg-red-700"
                        >
                            漫
                        </div>

                        {{-- Nom --}}
                        <div class="hidden md:block">

                            <p
                                class="text-xs font-black uppercase
                                       leading-none tracking-tight text-zinc-950"
                            >
                                Manga Collection
                            </p>

                            <p
                                class="mt-1 text-[7px] font-bold uppercase
                                       tracking-[0.3em] text-zinc-400"
                            >
                                漫画コレクション
                            </p>

                        </div>
                    </a>

                </div>


                {{-- =================================================
                    LIENS DESKTOP
                ================================================== --}}
                <div
                    class="hidden space-x-7
                           sm:-my-px sm:ms-10 sm:flex"
                >

                    {{-- Collection --}}
                    <a
                        href="{{ route('collection.index') }}"
                        class="inline-flex items-center
                               border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('collection.*')
                                    ? 'border-red-600 text-zinc-900'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        Collection
                    </a>


                    {{-- Ajouter tome --}}
                    <a
                        href="{{ route('tomes.create') }}"
                        class="inline-flex items-center
                               border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('tomes.*')
                                    ? 'border-red-600 text-zinc-900'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        <span class="mr-1 font-black text-red-600">
                            ＋
                        </span>

                        Tome
                    </a>


                    {{-- Nouvelle licence --}}
                    <a
                        href="{{ route('mangas.create') }}"
                        class="inline-flex items-center
                               border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('mangas.*')
                                    ? 'border-red-600 text-zinc-900'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        <span class="mr-1 font-black text-red-600">
                            ＋
                        </span>

                        Licence
                    </a>

                </div>

            </div>


            {{-- ====================================================
                DROITE : UTILISATEUR DESKTOP
            ===================================================== --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center gap-2
                                   rounded-md border border-transparent
                                   bg-[#fffdf8] px-3 py-2
                                   text-sm font-medium leading-4
                                   text-zinc-500
                                   transition duration-150 ease-in-out
                                   hover:text-zinc-700
                                   focus:outline-none"
                        >

                            {{-- Initiale utilisateur --}}
                            <div
                                class="flex h-7 w-7 items-center
                                       justify-center bg-zinc-900
                                       text-[10px] font-black
                                       uppercase text-white"
                            >
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>


                            {{-- Nom --}}
                            <div>
                                {{ Auth::user()->name }}
                            </div>


                            {{-- Flèche --}}
                            <div class="ms-1">

                                <svg
                                    class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0
                                           011.414 0L10
                                           10.586l3.293-3.293a1 1
                                           0 111.414 1.414l-4 4a1
                                           1 0 01-1.414 0l-4-4a1
                                           1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>

                            </div>

                        </button>

                    </x-slot>


                    {{-- =================================================
                        DROPDOWN
                    ================================================== --}}
                    <x-slot name="content">

                        {{-- Petit header japonais --}}
                        <div
                            class="border-b border-zinc-100
                                   bg-[#f7f3eb] px-4 py-3"
                        >

                            <p
                                class="text-[8px] font-black uppercase
                                       tracking-[0.25em] text-red-600"
                            >
                                アカウント • Compte
                            </p>

                            <p
                                class="mt-1 truncate text-xs
                                       text-zinc-500"
                            >
                                {{ Auth::user()->email }}
                            </p>

                        </div>


                        {{-- Profil --}}
                        <x-dropdown-link :href="route('profile.edit')">

                            <span class="flex items-center gap-2">

                                <span
                                    class="text-[10px]
                                           font-black text-red-600"
                                >
                                    人
                                </span>

                                {{ __('Profil') }}

                            </span>

                        </x-dropdown-link>


                        {{-- Déconnexion --}}
                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >

                                <span class="flex items-center gap-2">

                                    <span
                                        class="text-[10px]
                                               font-black text-red-600"
                                    >
                                        →
                                    </span>

                                    {{ __('Déconnexion') }}

                                </span>

                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            {{-- ====================================================
                HAMBURGER
            ===================================================== --}}
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    type="button"
                    @click="open = ! open"
                    class="inline-flex items-center justify-center
                           rounded-md p-2
                           text-zinc-400 transition
                           hover:bg-[#f7f3eb]
                           hover:text-red-600
                           focus:bg-[#f7f3eb]
                           focus:text-red-600
                           focus:outline-none"
                >

                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >

                        {{-- Hamburger --}}
                        <path
                            :class="{
                                'hidden': open,
                                'inline-flex': !open
                            }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />


                        {{-- Croix --}}
                        <path
                            :class="{
                                'hidden': !open,
                                'inline-flex': open
                            }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>

                </button>

            </div>

        </div>

    </div>


    {{-- ============================================================
        MENU MOBILE
    ============================================================ --}}
    <div
        :class="{
            'block': open,
            'hidden': !open
        }"
        class="hidden border-t border-zinc-100
               bg-[#fffdf8] sm:hidden"
    >

        {{-- ========================================================
            LIENS MOBILE
        ========================================================= --}}
        <div class="space-y-1 pb-3 pt-2">

            {{-- Collection --}}
            <a
                href="{{ route('collection.index') }}"
                class="flex items-center justify-between
                       border-l-4 py-2 pe-4 ps-3
                       text-base font-medium transition
                       {{ request()->routeIs('collection.*')
                            ? 'border-red-600 bg-red-50 text-red-700'
                            : 'border-transparent text-zinc-600 hover:border-zinc-300 hover:bg-[#f7f3eb] hover:text-zinc-800' }}"
            >
                <span>
                    Collection
                </span>

                <span
                    class="text-[9px] font-black
                           tracking-widest text-zinc-400"
                >
                    漫画
                </span>
            </a>


            {{-- Tome --}}
            <a
                href="{{ route('tomes.create') }}"
                class="flex items-center justify-between
                       border-l-4 py-2 pe-4 ps-3
                       text-base font-medium transition
                       {{ request()->routeIs('tomes.*')
                            ? 'border-red-600 bg-red-50 text-red-700'
                            : 'border-transparent text-zinc-600 hover:border-zinc-300 hover:bg-[#f7f3eb] hover:text-zinc-800' }}"
            >
                <span>
                    Ajouter un tome
                </span>

                <span class="font-black text-red-600">
                    ＋
                </span>
            </a>


            {{-- Licence --}}
            <a
                href="{{ route('mangas.create') }}"
                class="flex items-center justify-between
                       border-l-4 py-2 pe-4 ps-3
                       text-base font-medium transition
                       {{ request()->routeIs('mangas.*')
                            ? 'border-red-600 bg-red-50 text-red-700'
                            : 'border-transparent text-zinc-600 hover:border-zinc-300 hover:bg-[#f7f3eb] hover:text-zinc-800' }}"
            >
                <span>
                    Nouvelle licence
                </span>

                <span class="font-black text-red-600">
                    ＋
                </span>
            </a>

        </div>


        {{-- ========================================================
            COMPTE MOBILE
        ========================================================= --}}
        <div
            class="border-t border-zinc-200
                   bg-[#f7f3eb] pb-3 pt-4"
        >

            {{-- Utilisateur --}}
            <div class="flex items-center gap-3 px-4">

                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           bg-zinc-900
                           text-xs font-black uppercase
                           text-white"
                >
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>


                <div class="min-w-0">

                    <div
                        class="truncate text-base
                               font-medium text-zinc-800"
                    >
                        {{ Auth::user()->name }}
                    </div>

                    <div
                        class="truncate text-sm
                               font-medium text-zinc-500"
                    >
                        {{ Auth::user()->email }}
                    </div>

                </div>

            </div>


            {{-- Actions compte --}}
            <div class="mt-3 space-y-1">

                <a
                    href="{{ route('profile.edit') }}"
                    class="block border-l-4 border-transparent
                           py-2 pe-4 ps-3
                           text-base font-medium text-zinc-600
                           transition
                           hover:border-zinc-300
                           hover:bg-[#fffdf8]
                           hover:text-zinc-800"
                >
                    Profil
                </a>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="block w-full border-l-4
                               border-transparent
                               py-2 pe-4 ps-3 text-left
                               text-base font-medium text-red-600
                               transition
                               hover:border-red-600
                               hover:bg-red-50
                               hover:text-red-700"
                    >
                        Déconnexion
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>