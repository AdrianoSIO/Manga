<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="text-xl font-semibold text-gray-800 dark:text-zinc-100">
                Ma collection
            </h2>

            <a
                href="{{ route('tomes.create') }}"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
            >
                + Ajouter un tome
            </a>

        </div>
    </x-slot>


    <div class="py-12">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- Message succès --}}
            @if (session('success'))

                <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-800 dark:bg-green-950/40 dark:text-green-300">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Statistiques --}}
            <div class="mb-8 grid gap-6 md:grid-cols-2">

                <div class="rounded-xl bg-white p-6 shadow-sm dark:bg-[#18181b]">

                    <p class="text-sm text-gray-500 dark:text-zinc-400">
                        Licences
                    </p>

                    <p class="mt-2 text-4xl font-bold text-gray-900 dark:text-zinc-100">
                        {{ $totalLicences }}
                    </p>

                </div>


                <div class="rounded-xl bg-white p-6 shadow-sm dark:bg-[#18181b]">

                    <p class="text-sm text-gray-500 dark:text-zinc-400">
                        Tomes physiques
                    </p>

                    <p class="mt-2 text-4xl font-bold text-gray-900 dark:text-zinc-100">
                        {{ $totalExemplaires }}
                    </p>

                </div>

            </div>


            {{-- Filtres état --}}
            <div class="mb-6 flex flex-wrap gap-2">

                <button
                    type="button"
                    data-status-filter="all"
                    class="status-filter rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white"
                >
                    Toutes
                </button>

                <button
                    type="button"
                    data-status-filter="encours"
                    class="status-filter rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-700 dark:border-zinc-700 dark:bg-[#18181b] dark:text-zinc-300"
                >
                    ◌ En cours
                </button>

                <button
                    type="button"
                    data-status-filter="terminee"
                    class="status-filter rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-700 dark:border-zinc-700 dark:bg-[#18181b] dark:text-zinc-300"
                >
                    ✓ Terminées
                </button>

            </div>


            {{-- Liste mangas --}}
            <div
                id="manga-grid"
                class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >

                @forelse ($mangas as $manga)

                    <div
                        class="manga-card rounded-xl bg-white p-6 shadow-sm transition hover:shadow-md dark:bg-[#18181b]"
                        data-status="{{ $manga->collection_terminee ? 'terminee' : 'encours' }}"
                    >

                        <div class="mb-4">

                            <div class="flex items-start justify-between gap-3">

                                <h3 class="text-xl font-bold text-gray-900 dark:text-zinc-100">

                                    <a
                                        href="{{ route('collection.show', $manga) }}"
                                        class="hover:text-red-600"
                                    >
                                        {{ $manga->titre }}
                                    </a>

                                </h3>


                                {{-- État --}}
                                @if ($manga->collection_terminee)

                                    <span class="shrink-0 rounded-full bg-green-100 px-2 py-1 text-xs font-bold text-green-700 dark:bg-green-950/50 dark:text-green-300">
                                        ✓ Terminée
                                    </span>

                                @else

                                    <span class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-xs font-bold text-gray-600 dark:bg-zinc-800 dark:text-zinc-300">
                                        ◌ En cours
                                    </span>

                                @endif

                            </div>


                            {{-- Genres --}}
                            <div class="mt-2 flex flex-wrap gap-2">

                                @foreach ($manga->genres as $genre)

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ $genre->nom }}
                                    </span>

                                @endforeach

                            </div>

                        </div>


                        <p class="mb-3 text-sm text-gray-500 dark:text-zinc-400">

                            {{ $manga->tomes->count() }}

                            {{ $manga->tomes->count() > 1
                                ? 'exemplaires'
                                : 'exemplaire'
                            }}

                        </p>


                        {{-- Numéros --}}
                        <div class="flex flex-wrap gap-2">

                            @foreach ($manga->tomes as $tome)

                                <span class="rounded-lg bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700 dark:bg-zinc-800 dark:text-zinc-200">
                                    {{ $tome->numero }}
                                </span>

                            @endforeach

                        </div>


                        {{-- Changer l'état --}}
                        <div class="mt-5">

                            <form
                                method="POST"
                                action="{{ route('collection.toggle-terminee', $manga) }}"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="text-xs font-bold
                                    {{ $manga->collection_terminee
                                        ? 'text-green-600 hover:text-green-800'
                                        : 'text-gray-500 hover:text-red-600'
                                    }}"
                                >
                                    @if ($manga->collection_terminee)
                                        ✓ Collection terminée
                                    @else
                                        ◌ Marquer comme terminée
                                    @endif
                                </button>

                            </form>

                        </div>


                        <div class="mt-4">

                            <a
                                href="{{ route('collection.show', $manga) }}"
                                class="text-sm font-semibold text-red-600 hover:text-red-800"
                            >
                                Voir le manga →
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full rounded-xl bg-white p-10 text-center shadow-sm dark:bg-[#18181b]">

                        <p class="text-gray-500 dark:text-zinc-400">
                            Aucun manga dans ta collection.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Aucun résultat du filtre --}}
            <div
                id="no-status-results"
                class="mt-6 hidden rounded-xl border-2 border-dashed border-gray-300 p-10 text-center dark:border-zinc-700"
            >
                <p class="font-bold text-gray-500 dark:text-zinc-400">
                    Aucune licence dans cette catégorie.
                </p>
            </div>

        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const buttons = document.querySelectorAll('.status-filter');
            const cards = document.querySelectorAll('.manga-card');
            const noResults = document.getElementById('no-status-results');

            buttons.forEach(button => {

                button.addEventListener('click', () => {

                    const status = button.dataset.statusFilter;
                    let visible = 0;

                    cards.forEach(card => {

                        const show =
                            status === 'all' ||
                            card.dataset.status === status;

                        card.classList.toggle('hidden', !show);

                        if (show) {
                            visible++;
                        }

                    });

                    noResults.classList.toggle(
                        'hidden',
                        visible !== 0
                    );

                    buttons.forEach(item => {

                        const active = item === button;

                        item.classList.toggle(
                            'bg-red-600',
                            active
                        );

                        item.classList.toggle(
                            'text-white',
                            active
                        );

                        item.classList.toggle(
                            'bg-white',
                            !active
                        );

                        item.classList.toggle(
                            'text-gray-700',
                            !active
                        );

                    });

                });

            });

        });
    </script>

</x-app-layout>