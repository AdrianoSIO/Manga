<x-app-layout>

    {{-- =========================================================
        TITRE DE L'ONGLET
    ========================================================== --}}
    <x-slot name="title">
        Ma collection
    </x-slot>


    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-red-600 sm:text-sm">
                    漫画コレクション
                </p>

                <h2 class="mt-1 text-xl font-black text-gray-900 sm:text-2xl">
                    Ma collection
                </h2>
            </div>


            {{-- Actions --}}
            <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">

                {{-- Nouvelle licence --}}
                <a
                    href="{{ route('mangas.create') }}"
                    class="flex w-full items-center justify-center rounded-lg
                           border border-gray-300 bg-white px-5 py-3
                           text-sm font-bold text-gray-700 transition
                           hover:border-red-300 hover:bg-red-50 hover:text-red-600
                           sm:w-auto sm:py-2.5"
                >
                    <span class="mr-2 text-red-600">＋</span>
                    Nouvelle licence
                </a>


                {{-- Ajouter un tome --}}
                <a
                    href="{{ route('tomes.create') }}"
                    class="flex w-full items-center justify-center rounded-lg
                           bg-red-600 px-5 py-3
                           text-sm font-bold text-white transition
                           hover:bg-red-700
                           sm:w-auto sm:py-2.5"
                >
                    <span class="mr-2">＋</span>
                    Ajouter un tome
                </a>

            </div>

        </div>

    </x-slot>


    {{-- =========================================================
        CONTENU
    ========================================================== --}}
    <div class="py-6 sm:py-10">

        <div class="mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">


            {{-- =================================================
                MESSAGE DE SUCCÈS
            ================================================== --}}
            @if (session('success'))

                <div
                    class="mb-5 rounded-xl border border-green-200
                           bg-green-50 p-4 text-sm font-medium text-green-800"
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- =================================================
                STATISTIQUES
            ================================================== --}}
            <div class="mb-6 grid grid-cols-2 gap-3 sm:mb-8 sm:gap-4">

                {{-- Licences --}}
                <div
                    class="rounded-xl border border-gray-200
                           bg-white p-4 shadow-sm sm:p-6"
                >

                    <p
                        class="text-[11px] font-bold uppercase
                               tracking-wider text-gray-500 sm:text-sm"
                    >
                        Licences
                    </p>

                    <p class="mt-2 text-3xl font-black text-gray-900 sm:text-4xl">
                        {{ $totalLicences }}
                    </p>

                </div>


                {{-- Tomes --}}
                <div
                    class="rounded-xl border border-gray-200
                           bg-white p-4 shadow-sm sm:p-6"
                >

                    <p
                        class="text-[11px] font-bold uppercase
                               tracking-wider text-gray-500 sm:text-sm"
                    >
                        Tomes

                        <span class="hidden sm:inline">
                            physiques
                        </span>
                    </p>

                    <p class="mt-2 text-3xl font-black text-red-600 sm:text-4xl">
                        {{ $totalExemplaires }}
                    </p>

                </div>

            </div>


            {{-- =================================================
                RECHERCHE + FILTRES
            ================================================== --}}
            <section class="mb-8">

                {{-- Recherche --}}
                <div class="relative">

                    <div
                        class="pointer-events-none absolute inset-y-0
                               left-0 flex items-center pl-4"
                    >

                        <svg
                            class="h-5 w-5 text-gray-400"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>

                    </div>


                    <input
                        id="manga-search"
                        type="search"
                        placeholder="Rechercher un manga..."
                        autocomplete="off"
                        class="w-full rounded-xl border border-gray-200
                               bg-white py-3 pl-12 pr-4 text-sm
                               text-gray-900 shadow-sm outline-none
                               transition placeholder:text-gray-400
                               focus:border-red-500 focus:ring-2
                               focus:ring-red-100"
                    >

                </div>


                {{-- Création de la liste des genres --}}
                @php
                    $genres = $mangas
                        ->flatMap(fn ($manga) => $manga->genres)
                        ->unique('id')
                        ->sortBy('nom');
                @endphp


                {{-- Filtres genres --}}
                <div
                    id="genre-filters"
                    class="mt-4 flex gap-2 overflow-x-auto pb-2"
                >

                    {{-- Tous --}}
                    <button
                        type="button"
                        data-genre="all"
                        class="genre-filter shrink-0 rounded-full
                               bg-gray-900 px-4 py-2 text-xs
                               font-bold text-white transition"
                    >
                        Tous
                    </button>


                    {{-- Genres --}}
                    @foreach ($genres as $genre)

                        <button
                            type="button"
                            data-genre="{{ strtolower($genre->nom) }}"
                            class="genre-filter shrink-0 rounded-full
                                   border border-gray-200 bg-white
                                   px-4 py-2 text-xs font-bold
                                   text-gray-600 transition
                                   hover:border-red-300 hover:text-red-600"
                        >
                            {{ $genre->nom }}
                        </button>

                    @endforeach

                </div>


                {{-- Infos filtres --}}
                <div class="mt-2 flex items-center justify-between">

                    <p class="text-xs text-gray-400">
                        <span id="visible-count">
                            {{ $mangas->count() }}
                        </span>

                        résultat(s)
                    </p>


                    <button
                        id="reset-filters"
                        type="button"
                        class="hidden text-xs font-bold
                               text-red-600 hover:text-red-800"
                    >
                        Réinitialiser
                    </button>

                </div>

            </section>


            {{-- =================================================
                TITRE DE LA COLLECTION
            ================================================== --}}
            <div class="mb-4 flex items-end justify-between gap-4">

                <div>

                    <p
                        class="text-xs font-bold uppercase
                               tracking-[0.2em] text-red-600"
                    >
                        本棚
                    </p>

                    <h2 class="text-lg font-black text-gray-900 sm:text-xl">
                        Mes mangas
                    </h2>

                </div>


                <span class="text-xs font-medium text-gray-400 sm:text-sm">

                    {{ $totalLicences }}

                    {{ $totalLicences > 1 ? 'licences' : 'licence' }}

                </span>

            </div>


            {{-- =================================================
                GRILLE DES MANGAS
            ================================================== --}}
            <div
                id="manga-grid"
                class="grid grid-cols-1 gap-4
                       sm:grid-cols-2 sm:gap-5
                       lg:grid-cols-3"
            >

                @forelse ($mangas as $manga)

                    <article
                        class="manga-card group overflow-hidden
                               rounded-xl border border-gray-200
                               bg-white shadow-sm transition
                               hover:-translate-y-1
                               hover:border-red-200
                               hover:shadow-lg"

                        data-title="{{ strtolower($manga->titre) }}"

                        data-genres="{{ $manga->genres
                            ->pluck('nom')
                            ->map(fn ($genre) => strtolower($genre))
                            ->implode('|')
                        }}"
                    >

                        {{-- Barre rouge --}}
                        <div class="h-1.5 bg-red-600"></div>


                        <div class="p-4 sm:p-6">

                            {{-- =================================
                                TITRE DU MANGA
                            ================================== --}}
                            <div class="flex items-start justify-between gap-3">

                                <h3
                                    class="min-w-0 break-words text-lg font-black
                                           leading-tight text-gray-900 sm:text-xl"
                                >

                                    <a
                                        href="{{ route('collection.show', $manga) }}"
                                        class="transition group-hover:text-red-600"
                                    >
                                        {{ $manga->titre }}
                                    </a>

                                </h3>


                                <a
                                    href="{{ route('tomes.create', ['manga' => $manga->id]) }}"
                                    title="Ajouter un tome de {{ $manga->titre }}"
                                    class="flex h-9 w-9 shrink-0 items-center
                                           justify-center rounded-lg
                                           border border-gray-200 bg-gray-50
                                           text-lg font-black text-gray-500
                                           transition
                                           hover:border-red-600
                                           hover:bg-red-600
                                           hover:text-white"
                                >
                                    ＋
                                </a>

                            </div>


                            {{-- =================================
                                GENRES
                            ================================== --}}
                            @if ($manga->genres->isNotEmpty())

                                <div class="mt-3 flex flex-wrap gap-1.5 sm:gap-2">

                                    @foreach ($manga->genres as $genre)

                                        <span
                                            class="rounded-full bg-gray-100
                                                   px-2.5 py-1 text-[11px]
                                                   font-semibold text-gray-600
                                                   sm:px-3 sm:text-xs"
                                        >
                                            {{ $genre->nom }}
                                        </span>

                                    @endforeach

                                </div>

                            @else

                                <p class="mt-3 text-xs text-gray-400">
                                    Aucun genre renseigné
                                </p>

                            @endif


                            {{-- =================================
                                NOMBRE D'EXEMPLAIRES
                            ================================== --}}
                            <p
                                class="mt-4 text-xs text-gray-500
                                       sm:mt-5 sm:text-sm"
                            >

                                <strong class="text-gray-900">
                                    {{ $manga->tomes->count() }}
                                </strong>

                                {{ $manga->tomes->count() > 1
                                    ? 'exemplaires'
                                    : 'exemplaire'
                                }}

                            </p>


                            {{-- =================================
                                TOMES
                            ================================== --}}
                            <div class="mt-3 flex flex-wrap gap-1.5 sm:gap-2">

                                @foreach ($manga->tomes as $tome)

                                    @php
                                        $duplicate = $manga
                                            ->tomes
                                            ->where('numero', $tome->numero)
                                            ->count() > 1;
                                    @endphp


                                    <span
                                        class="
                                            flex h-8 min-w-8
                                            items-center justify-center
                                            rounded-md px-2
                                            text-xs font-black text-white

                                            sm:h-9 sm:min-w-9 sm:text-sm

                                            {{ $duplicate
                                                ? 'bg-red-600'
                                                : 'bg-gray-900'
                                            }}
                                        "
                                        title="Tome {{ $tome->numero }}{{ $duplicate ? ' — plusieurs exemplaires' : '' }}"
                                    >
                                        {{ $tome->numero }}
                                    </span>

                                @endforeach

                            </div>


                            {{-- =================================
                                LÉGENDE DOUBLONS
                            ================================== --}}
                            @if (
                                $manga->tomes
                                    ->groupBy('numero')
                                    ->contains(fn ($tomes) => $tomes->count() > 1)
                            )

                                <div class="mt-3 flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full bg-red-600"></span>

                                    <span class="text-[11px] font-medium text-gray-400">
                                        Plusieurs exemplaires
                                    </span>

                                </div>

                            @endif


                            {{-- =================================
                                FOOTER
                            ================================== --}}
                            <div
                                class="mt-5 border-t border-gray-100
                                       pt-4 sm:mt-6"
                            >

                                <a
                                    href="{{ route('collection.show', $manga) }}"
                                    class="flex items-center justify-between
                                           text-sm font-bold text-red-600
                                           transition hover:text-red-800"
                                >

                                    <span>
                                        Voir la collection
                                    </span>

                                    <span aria-hidden="true">
                                        →
                                    </span>

                                </a>

                            </div>

                        </div>

                    </article>


                @empty

                    {{-- =========================================
                        COLLECTION VIDE
                    ========================================== --}}
                    <div
                        class="col-span-full rounded-xl
                               border-2 border-dashed border-gray-300
                               bg-white p-8 text-center sm:p-12"
                    >

                        <div class="text-4xl font-black text-red-600">
                            漫画
                        </div>

                        <h3 class="mt-4 text-lg font-bold text-gray-900 sm:text-xl">
                            Collection vide
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                            Commence par créer une licence.
                            Tu pourras ensuite ajouter les tomes que tu possèdes.
                        </p>


                        <div
                            class="mt-6 flex flex-col justify-center gap-2
                                   sm:flex-row"
                        >

                            <a
                                href="{{ route('mangas.create') }}"
                                class="inline-flex w-full items-center
                                       justify-center rounded-lg
                                       bg-red-600 px-5 py-3
                                       text-sm font-bold text-white
                                       transition hover:bg-red-700
                                       sm:w-auto"
                            >
                                ＋ Ajouter ma première licence
                            </a>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                AUCUN RÉSULTAT DE RECHERCHE
            ================================================== --}}
            <div
                id="no-results"
                class="mt-4 hidden rounded-xl
                       border-2 border-dashed border-gray-300
                       bg-white p-8 text-center sm:p-12"
            >

                <div class="text-4xl font-black text-red-600">
                    無
                </div>

                <h3 class="mt-4 text-lg font-black text-gray-900 sm:text-xl">
                    Aucun manga trouvé
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Essaie une autre recherche ou sélectionne un autre genre.
                </p>

                <button
                    id="no-results-reset"
                    type="button"
                    class="mt-5 rounded-lg bg-gray-900
                           px-5 py-2.5 text-sm font-bold
                           text-white transition hover:bg-red-600"
                >
                    Réinitialiser
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
        RECHERCHE / FILTRAGE JAVASCRIPT
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const searchInput =
                document.getElementById('manga-search');

            const cards =
                [...document.querySelectorAll('.manga-card')];

            const genreButtons =
                [...document.querySelectorAll('.genre-filter')];

            const visibleCount =
                document.getElementById('visible-count');

            const noResults =
                document.getElementById('no-results');

            const resetButton =
                document.getElementById('reset-filters');

            const noResultsReset =
                document.getElementById('no-results-reset');


            let activeGenre = 'all';


            /*
            |--------------------------------------------------------------------------
            | Normalisation
            |--------------------------------------------------------------------------
            |
            | Permet par exemple de rechercher :
            |
            |   attaque
            |
            | et de trouver :
            |
            |   L’attaque des titans
            |
            */

            function normalize(value) {

                return String(value ?? '')
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .trim();

            }


            /*
            |--------------------------------------------------------------------------
            | Filtrage
            |--------------------------------------------------------------------------
            */

            function filterMangas() {

                const search =
                    normalize(searchInput.value);

                let count = 0;


                cards.forEach(card => {

                    const title =
                        normalize(card.dataset.title);


                    const genres =
                        (card.dataset.genres || '')
                            .split('|')
                            .filter(Boolean)
                            .map(normalize);


                    const matchesSearch =
                        title.includes(search);


                    const matchesGenre =
                        activeGenre === 'all'
                        || genres.includes(normalize(activeGenre));


                    const visible =
                        matchesSearch && matchesGenre;


                    card.classList.toggle(
                        'hidden',
                        !visible
                    );


                    if (visible) {
                        count++;
                    }

                });


                /*
                 * Mise à jour compteur
                 */
                visibleCount.textContent = count;


                /*
                 * Aucun résultat
                 */
                noResults.classList.toggle(
                    'hidden',
                    count !== 0 || cards.length === 0
                );


                /*
                 * Bouton reset
                 */
                const filtersActive =
                    search !== ''
                    || activeGenre !== 'all';


                resetButton.classList.toggle(
                    'hidden',
                    !filtersActive
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Recherche instantanée
            |--------------------------------------------------------------------------
            */

            searchInput.addEventListener(
                'input',
                filterMangas
            );


            /*
            |--------------------------------------------------------------------------
            | Filtres genres
            |--------------------------------------------------------------------------
            */

            genreButtons.forEach(button => {

                button.addEventListener('click', () => {

                    activeGenre =
                        button.dataset.genre;


                    genreButtons.forEach(item => {

                        const active =
                            item === button;


                        item.classList.toggle(
                            'bg-gray-900',
                            active
                        );

                        item.classList.toggle(
                            'text-white',
                            active
                        );


                        item.classList.toggle(
                            'border-gray-200',
                            !active
                        );

                        item.classList.toggle(
                            'bg-white',
                            !active
                        );

                        item.classList.toggle(
                            'text-gray-600',
                            !active
                        );

                    });


                    filterMangas();

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Reset
            |--------------------------------------------------------------------------
            */

            function resetFilters() {

                searchInput.value = '';

                activeGenre = 'all';


                genreButtons.forEach(button => {

                    const active =
                        button.dataset.genre === 'all';


                    button.classList.toggle(
                        'bg-gray-900',
                        active
                    );

                    button.classList.toggle(
                        'text-white',
                        active
                    );


                    button.classList.toggle(
                        'border-gray-200',
                        !active
                    );

                    button.classList.toggle(
                        'bg-white',
                        !active
                    );

                    button.classList.toggle(
                        'text-gray-600',
                        !active
                    );

                });


                filterMangas();

                searchInput.focus();

            }


            resetButton.addEventListener(
                'click',
                resetFilters
            );


            noResultsReset.addEventListener(
                'click',
                resetFilters
            );


            /*
            |--------------------------------------------------------------------------
            | État initial
            |--------------------------------------------------------------------------
            */

            filterMangas();

        });
    </script>

</x-app-layout>