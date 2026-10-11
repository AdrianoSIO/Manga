<nav
    x-data="{ open: false }"
    class="border-b border-zinc-200 bg-[#fffdf8] transition-colors duration-200
           dark:border-zinc-800 dark:bg-zinc-950"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 justify-between">

            {{-- =====================================================
                GAUCHE : LOGO + NAVIGATION
            ====================================================== --}}
            <div class="flex">

                {{-- LOGO --}}
                <a
                    href="{{ route('collection.index') }}"
                    class="flex shrink-0 items-center gap-3"
                >
                    <div
                        class="flex h-9 w-9 items-center justify-center
                               bg-red-600 text-xs font-black text-white
                               shadow-[2px_2px_0_#18181b]
                               dark:shadow-[2px_2px_0_#f4f4f5]"
                    >
                        漫
                    </div>

                    <div class="hidden md:block">

                        <p
                            class="text-xs font-black uppercase leading-none
                                   text-zinc-950 dark:text-zinc-100"
                        >
                            Manga Collection
                        </p>

                        <p
                            class="mt-1 text-[7px] font-bold uppercase
                                   tracking-[0.3em] text-zinc-400
                                   dark:text-zinc-500"
                        >
                            漫画コレクション
                        </p>

                    </div>
                </a>


                {{-- =================================================
                    NAVIGATION DESKTOP
                ================================================== --}}
                <div class="hidden space-x-7 sm:-my-px sm:ms-10 sm:flex">

                    {{-- COLLECTION --}}
                    <a
                        href="{{ route('collection.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('collection.*')
                                    ? 'border-red-600 text-zinc-900 dark:text-white'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:border-zinc-600 dark:hover:text-zinc-100' }}"
                    >
                        Collection
                    </a>


                    {{-- TOMES --}}
                    <a
                        href="{{ route('tomes.create') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('tomes.*')
                                    ? 'border-red-600 text-zinc-900 dark:text-white'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:border-zinc-600 dark:hover:text-zinc-100' }}"
                    >
                        <span class="mr-1 font-black text-red-600">
                            ＋
                        </span>

                        Tome
                    </a>


                    {{-- LICENCE --}}
                    <a
                        href="{{ route('mangas.create') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('mangas.*')
                                    ? 'border-red-600 text-zinc-900 dark:text-white'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:border-zinc-600 dark:hover:text-zinc-100' }}"
                    >
                        <span class="mr-1 font-black text-red-600">
                            ＋
                        </span>

                        Licence
                    </a>


                    {{-- WISHLIST --}}
                    <a
                        href="{{ route('objets.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1
                               text-sm font-medium transition
                               {{ request()->routeIs('objets.*')
                                    ? 'border-red-600 text-zinc-900 dark:text-white'
                                    : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:border-zinc-600 dark:hover:text-zinc-100' }}"
                    >
                        <span class="mr-1 font-black text-red-600">
                            欲
                        </span>

                        Wishlist
                    </a>

                </div>
            </div>


            {{-- =====================================================
                DROITE DESKTOP
            ====================================================== --}}
            <div class="hidden items-center sm:flex sm:ms-6">

                {{-- THÈME --}}
                <button
                    type="button"
                    id="theme-toggle"
                    class="mr-3 flex h-9 w-9 items-center justify-center
                           border border-zinc-300 bg-white text-lg
                           transition
                           hover:border-red-600
                           dark:border-zinc-700 dark:bg-zinc-900
                           dark:hover:border-red-600"
                    title="Changer le thème"
                >
                    <span id="theme-icon">
                        ⚙️
                    </span>
                </button>


                {{-- COMPTE --}}
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">

                        <button
                            type="button"
                            class="inline-flex items-center gap-2
                                   rounded-md px-3 py-2
                                   text-sm font-medium
                                   text-zinc-500 transition
                                   hover:text-zinc-800
                                   dark:text-zinc-400
                                   dark:hover:text-white"
                        >

                            {{-- INITIALE --}}
                            <div
                                class="flex h-7 w-7 items-center justify-center
                                       bg-zinc-900 text-[10px]
                                       font-black uppercase text-white
                                       dark:bg-zinc-100 dark:text-zinc-950"
                            >
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>

                            {{-- NOM --}}
                            <span>
                                {{ Auth::user()->name }}
                            </span>

                            {{-- FLÈCHE --}}
                            <svg
                                class="h-4 w-4 fill-current"
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

                        </button>

                    </x-slot>


                    <x-slot name="content">

                        {{-- HEADER COMPTE --}}
                        <div
                            class="border-b border-zinc-100
                                   bg-[#f7f3eb] px-4 py-3
                                   dark:border-zinc-700
                                   dark:bg-zinc-900"
                        >
                            <p
                                class="text-[8px] font-black uppercase
                                       tracking-[0.25em] text-red-600"
                            >
                                アカウント • Compte
                            </p>

                            <p
                                class="mt-1 truncate text-xs
                                       text-zinc-500 dark:text-zinc-400"
                            >
                                {{ Auth::user()->email }}
                            </p>
                        </div>


                        {{-- PROFIL --}}
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>


                        {{-- LOGOUT --}}
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
                                Déconnexion
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            {{-- =====================================================
                MOBILE : THÈME + HAMBURGER
            ====================================================== --}}
            <div class="flex items-center gap-2 sm:hidden">

                {{-- THÈME MOBILE --}}
                <button
                    type="button"
                    id="theme-toggle-mobile"
                    class="flex h-9 w-9 items-center justify-center
                           border border-zinc-300 bg-white text-lg
                           transition
                           hover:border-red-600
                           dark:border-zinc-700 dark:bg-zinc-900"
                    title="Changer le thème"
                >
                    <span id="theme-icon-mobile">
                        ⚙️
                    </span>
                </button>


                {{-- HAMBURGER --}}
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center
                           p-2 text-zinc-500 transition
                           hover:text-red-600
                           dark:text-zinc-400
                           dark:hover:text-red-500"
                >

                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >

                        {{-- OUVRIR --}}
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

                        {{-- FERMER --}}
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


    {{-- =============================================================
        MENU MOBILE
    ============================================================== --}}
    <div
        :class="{
            'block': open,
            'hidden': !open
        }"
        class="hidden border-t border-zinc-100
               bg-[#fffdf8]
               dark:border-zinc-800 dark:bg-zinc-950
               sm:hidden"
    >

        <div class="space-y-1 py-2">

            {{-- COLLECTION --}}
            <a
                href="{{ route('collection.index') }}"
                class="block border-l-4 px-4 py-2 font-medium transition
                       {{ request()->routeIs('collection.*')
                            ? 'border-red-600 bg-red-50 text-red-700 dark:bg-red-950/30 dark:text-red-400'
                            : 'border-transparent text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-900' }}"
            >
                Collection
            </a>


            {{-- TOMES --}}
            <a
                href="{{ route('tomes.create') }}"
                class="block border-l-4 px-4 py-2 font-medium transition
                       {{ request()->routeIs('tomes.*')
                            ? 'border-red-600 bg-red-50 text-red-700 dark:bg-red-950/30 dark:text-red-400'
                            : 'border-transparent text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-900' }}"
            >
                ＋ Ajouter un tome
            </a>


            {{-- LICENCE --}}
            <a
                href="{{ route('mangas.create') }}"
                class="block border-l-4 px-4 py-2 font-medium transition
                       {{ request()->routeIs('mangas.*')
                            ? 'border-red-600 bg-red-50 text-red-700 dark:bg-red-950/30 dark:text-red-400'
                            : 'border-transparent text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-900' }}"
            >
                ＋ Nouvelle licence
            </a>


            {{-- WISHLIST --}}
            <a
                href="{{ route('objets.index') }}"
                class="flex items-center justify-between
                       border-l-4 px-4 py-2 font-medium transition
                       {{ request()->routeIs('objets.*')
                            ? 'border-red-600 bg-red-50 text-red-700 dark:bg-red-950/30 dark:text-red-400'
                            : 'border-transparent text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-900' }}"
            >
                <span>
                    Wishlist
                </span>

                <span class="text-xs font-black text-red-600">
                    欲しい物
                </span>
            </a>

        </div>


        {{-- =========================================================
            COMPTE MOBILE
        ========================================================== --}}
        <div
            class="border-t border-zinc-200
                   bg-[#f7f3eb] px-4 py-4
                   dark:border-zinc-800 dark:bg-zinc-900"
        >

            <div class="flex items-center gap-3">

                {{-- INITIALE --}}
                <div
                    class="flex h-9 w-9 items-center justify-center
                           bg-zinc-900 text-xs font-black
                           uppercase text-white
                           dark:bg-zinc-100 dark:text-zinc-950"
                >
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>


                {{-- USER --}}
                <div class="min-w-0">

                    <p
                        class="truncate font-medium
                               text-zinc-800 dark:text-zinc-100"
                    >
                        {{ Auth::user()->name }}
                    </p>

                    <p
                        class="truncate text-sm
                               text-zinc-500 dark:text-zinc-400"
                    >
                        {{ Auth::user()->email }}
                    </p>

                </div>

            </div>


            {{-- ACTIONS --}}
            <div class="mt-4 space-y-2">

                <a
                    href="{{ route('profile.edit') }}"
                    class="block text-zinc-600 transition
                           hover:text-zinc-900
                           dark:text-zinc-400
                           dark:hover:text-white"
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
                        class="text-red-600 transition
                               hover:text-red-700
                               dark:text-red-500
                               dark:hover:text-red-400"
                    >
                        Déconnexion
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>


{{-- =============================================================
    GESTION DU THÈME
================================================================ --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const desktopButton =
            document.getElementById('theme-toggle');

        const mobileButton =
            document.getElementById('theme-toggle-mobile');

        const desktopIcon =
            document.getElementById('theme-icon');

        const mobileIcon =
            document.getElementById('theme-icon-mobile');

        const media = window.matchMedia(
            '(prefers-color-scheme: dark)'
        );

        const themes = [
            'auto',
            'light',
            'dark'
        ];

        let theme =
            localStorage.getItem('theme') || 'auto';


        function applyTheme() {

            const dark =
                theme === 'dark'
                ||
                (
                    theme === 'auto'
                    && media.matches
                );

            document.documentElement.classList.toggle(
                'dark',
                dark
            );


            let icon = '⚙️';
            let title = 'Thème automatique';

            if (theme === 'light') {
                icon = '☀️';
                title = 'Thème clair';
            }

            if (theme === 'dark') {
                icon = '🌙';
                title = 'Thème sombre';
            }


            if (desktopIcon) {
                desktopIcon.textContent = icon;
            }

            if (mobileIcon) {
                mobileIcon.textContent = icon;
            }

            if (desktopButton) {
                desktopButton.title = title;
            }

            if (mobileButton) {
                mobileButton.title = title;
            }
        }


        function nextTheme() {

            const index =
                themes.indexOf(theme);

            theme =
                themes[
                    (index + 1) % themes.length
                ];

            localStorage.setItem(
                'theme',
                theme
            );

            applyTheme();
        }


        desktopButton?.addEventListener(
            'click',
            nextTheme
        );

        mobileButton?.addEventListener(
            'click',
            nextTheme
        );


        media.addEventListener(
            'change',
            () => {
                if (theme === 'auto') {
                    applyTheme();
                }
            }
        );


        applyTheme();

    });
</script>