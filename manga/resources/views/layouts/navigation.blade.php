<nav x-data="{ open: false }" class="border-b border-zinc-200 bg-[#fffdf8]">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">

            {{-- GAUCHE --}}
            <div class="flex">

                {{-- Logo --}}
                <a
                    href="{{ route('collection.index') }}"
                    class="flex shrink-0 items-center gap-3"
                >
                    <div class="flex h-9 w-9 items-center justify-center bg-red-600 text-xs font-black text-white shadow-[2px_2px_0_#18181b]">
                        漫
                    </div>

                    <div class="hidden md:block">
                        <p class="text-xs font-black uppercase leading-none text-zinc-950">
                            Manga Collection
                        </p>

                        <p class="mt-1 text-[7px] font-bold uppercase tracking-[0.3em] text-zinc-400">
                            漫画コレクション
                        </p>
                    </div>
                </a>


                {{-- DESKTOP --}}
                <div class="hidden space-x-7 sm:-my-px sm:ms-10 sm:flex">

                    <a
                        href="{{ route('collection.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition
                        {{ request()->routeIs('collection.*')
                            ? 'border-red-600 text-zinc-900'
                            : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        Collection
                    </a>

                    <a
                        href="{{ route('tomes.create') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition
                        {{ request()->routeIs('tomes.*')
                            ? 'border-red-600 text-zinc-900'
                            : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        <span class="mr-1 font-black text-red-600">＋</span>
                        Tome
                    </a>

                    <a
                        href="{{ route('mangas.create') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition
                        {{ request()->routeIs('mangas.*')
                            ? 'border-red-600 text-zinc-900'
                            : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        <span class="mr-1 font-black text-red-600">＋</span>
                        Licence
                    </a>

                    <a
                        href="{{ route('objets.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition
                        {{ request()->routeIs('objets.*')
                            ? 'border-red-600 text-zinc-900'
                            : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700' }}"
                    >
                        <span class="mr-1 font-black text-red-600">欲</span>
                        Wishlist
                    </a>

                </div>
            </div>


            {{-- COMPTE DESKTOP --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-zinc-500 hover:text-zinc-800"
                        >
                            <div class="flex h-7 w-7 items-center justify-center bg-zinc-900 text-[10px] font-black uppercase text-white">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <span>
                                {{ Auth::user()->name }}
                            </span>

                            <svg
                                class="h-4 w-4 fill-current"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </x-slot>


                    <x-slot name="content">

                        <div class="border-b border-zinc-100 bg-[#f7f3eb] px-4 py-3">
                            <p class="text-[8px] font-black uppercase tracking-[0.25em] text-red-600">
                                アカウント • Compte
                            </p>

                            <p class="mt-1 truncate text-xs text-zinc-500">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                Déconnexion
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            {{-- HAMBURGER --}}
            <div class="-me-2 flex items-center sm:hidden">

                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center p-2 text-zinc-500 hover:text-red-600"
                >
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
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


    {{-- MOBILE --}}
    <div
        :class="{ 'block': open, 'hidden': !open }"
        class="hidden border-t border-zinc-100 bg-[#fffdf8] sm:hidden"
    >

        <div class="space-y-1 py-2">

            <a
                href="{{ route('collection.index') }}"
                class="block border-l-4 px-4 py-2 font-medium
                {{ request()->routeIs('collection.*')
                    ? 'border-red-600 bg-red-50 text-red-700'
                    : 'border-transparent text-zinc-600' }}"
            >
                Collection
            </a>

            <a
                href="{{ route('tomes.create') }}"
                class="block border-l-4 px-4 py-2 font-medium
                {{ request()->routeIs('tomes.*')
                    ? 'border-red-600 bg-red-50 text-red-700'
                    : 'border-transparent text-zinc-600' }}"
            >
                ＋ Ajouter un tome
            </a>

            <a
                href="{{ route('mangas.create') }}"
                class="block border-l-4 px-4 py-2 font-medium
                {{ request()->routeIs('mangas.*')
                    ? 'border-red-600 bg-red-50 text-red-700'
                    : 'border-transparent text-zinc-600' }}"
            >
                ＋ Nouvelle licence
            </a>

            <a
                href="{{ route('objets.index') }}"
                class="flex items-center justify-between border-l-4 px-4 py-2 font-medium
                {{ request()->routeIs('objets.*')
                    ? 'border-red-600 bg-red-50 text-red-700'
                    : 'border-transparent text-zinc-600' }}"
            >
                <span>Wishlist</span>

                <span class="text-xs font-black text-red-600">
                    欲しい物
                </span>
            </a>

        </div>


        {{-- COMPTE MOBILE --}}
        <div class="border-t border-zinc-200 bg-[#f7f3eb] px-4 py-4">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center bg-zinc-900 text-xs font-black uppercase text-white">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>

                <div class="min-w-0">
                    <p class="truncate font-medium text-zinc-800">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="truncate text-sm text-zinc-500">
                        {{ Auth::user()->email }}
                    </p>
                </div>

            </div>


            <div class="mt-4 space-y-2">

                <a
                    href="{{ route('profile.edit') }}"
                    class="block text-zinc-600"
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
                        class="text-red-600"
                    >
                        Déconnexion
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>