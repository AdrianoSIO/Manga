<x-app-layout>

    <x-slot name="title">
        Ajouter un tome
    </x-slot>

    <x-slot name="header">

        <div>
            <a
                href="{{ route('collection.index') }}"
                class="text-sm font-semibold text-gray-500 transition hover:text-red-600"
            >
                ← Retour à la collection
            </a>

            <p class="mt-3 text-xs font-bold uppercase tracking-[0.25em] text-red-600">
                新しい漫画
            </p>

            <h2 class="mt-1 text-xl font-black text-gray-900 sm:text-2xl">
                Ajouter un tome
            </h2>
        </div>

    </x-slot>


    <div class="py-6 sm:py-10">

        <div class="mx-auto max-w-2xl px-3 sm:px-6">

            {{-- Erreurs --}}
            @if ($errors->any())

                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4">

                    <p class="font-bold text-red-800">
                        Une erreur est survenue
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-700">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="h-1.5 bg-red-600"></div>

                <form
                    action="{{ route('tomes.store') }}"
                    method="POST"
                    class="p-5 sm:p-8"
                >

                    @csrf


                    {{-- Manga --}}
                    <div>

                        <label
                            for="manga-search-select"
                            class="mb-2 block text-sm font-bold text-gray-900"
                        >
                            Manga
                        </label>

                        <p class="mb-3 text-xs text-gray-500">
                            Recherche la licence à laquelle appartient ton tome.
                        </p>


                        {{-- Recherche --}}
                        <div class="relative">

                            <div
                                class="pointer-events-none absolute inset-y-0 left-0
                                       flex items-center pl-4"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </div>

                            <input
                                id="manga-search-select"
                                type="search"
                                placeholder="Ex : Tokyo ghoul..."
                                autocomplete="off"
                                class="w-full rounded-xl border border-gray-300
                                       py-3 pl-12 pr-4 text-sm
                                       focus:border-red-500 focus:ring-red-500"
                            >

                        </div>


                        {{-- Champ réellement envoyé --}}
                        <input
                            id="manga_id"
                            type="hidden"
                            name="manga_id"
                            value="{{ old('manga_id', request('manga')) }}"
                        >


                        {{-- Liste --}}
                        <div
                            id="manga-results"
                            class="mt-3 max-h-72 overflow-y-auto
                                   rounded-xl border border-gray-200"
                        >

                            @foreach ($mangas as $manga)

                                <button
                                    type="button"
                                    data-id="{{ $manga->id }}"
                                    data-title="{{ $manga->titre }}"
                                    class="manga-option flex w-full items-center
                                           justify-between border-b border-gray-100
                                           px-4 py-3 text-left text-sm
                                           transition last:border-b-0
                                           hover:bg-red-50"
                                >

                                    <span class="font-semibold text-gray-800">
                                        {{ $manga->titre }}
                                    </span>

                                    <span class="hidden text-xs font-bold text-red-600">
                                        ✓
                                    </span>

                                </button>

                            @endforeach

                        </div>


                        {{-- Manga sélectionné --}}
                        <div
                            id="selected-manga"
                            class="mt-3 hidden rounded-lg bg-gray-900
                                   px-4 py-3 text-sm text-white"
                        >
                            <span class="text-gray-400">
                                Sélection :
                            </span>

                            <strong id="selected-manga-title"></strong>
                        </div>

                    </div>


                    {{-- Numéro --}}
                    <div class="mt-7">

                        <label
                            for="numero"
                            class="mb-2 block text-sm font-bold text-gray-900"
                        >
                            Numéro du tome
                        </label>

                        <p class="mb-3 text-xs text-gray-500">
                            Les doublons sont autorisés.
                        </p>

                        <input
                            id="numero"
                            type="number"
                            name="numero"
                            min="0"
                            inputmode="numeric"
                            value="{{ old('numero') }}"
                            placeholder="Ex : 12"
                            required
                            class="w-full rounded-xl border border-gray-300
                                   px-4 py-3 text-base
                                   focus:border-red-500 focus:ring-red-500"
                        >

                    </div>


                    {{-- Actions --}}
                    <div
                        class="mt-8 flex flex-col-reverse gap-3
                               border-t border-gray-100 pt-6
                               sm:flex-row sm:justify-end"
                    >

                        <a
                            href="{{ route('collection.index') }}"
                            class="flex w-full items-center justify-center
                                   rounded-lg px-5 py-3 text-sm font-bold
                                   text-gray-500 transition hover:bg-gray-100
                                   sm:w-auto"
                        >
                            Annuler
                        </a>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-red-600
                                   px-6 py-3 text-sm font-bold text-white
                                   transition hover:bg-red-700
                                   sm:w-auto"
                        >
                            Ajouter à ma collection
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const search = document.getElementById('manga-search-select');
            const mangaId = document.getElementById('manga_id');

            const options = [
                ...document.querySelectorAll('.manga-option')
            ];

            const selectedBox =
                document.getElementById('selected-manga');

            const selectedTitle =
                document.getElementById('selected-manga-title');


            function normalize(value) {
                return String(value ?? '')
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '');
            }


            function selectManga(option) {

                mangaId.value = option.dataset.id;

                selectedTitle.textContent =
                    option.dataset.title;

                selectedBox.classList.remove('hidden');


                options.forEach(item => {

                    const selected =
                        item.dataset.id === option.dataset.id;

                    item.classList.toggle(
                        'bg-red-50',
                        selected
                    );

                    const check =
                        item.querySelector('span:last-child');

                    check.classList.toggle(
                        'hidden',
                        !selected
                    );

                });

            }


            search.addEventListener('input', () => {

                const value =
                    normalize(search.value);


                options.forEach(option => {

                    const title =
                        normalize(option.dataset.title);

                    option.classList.toggle(
                        'hidden',
                        !title.includes(value)
                    );

                });

            });


            options.forEach(option => {

                option.addEventListener('click', () => {
                    selectManga(option);
                });

            });


            /*
             * Préselection lorsque l'on vient
             * d'une fiche manga :
             *
             * /tomes/create?manga=12
             */
            if (mangaId.value) {

                const option = options.find(
                    item => item.dataset.id === mangaId.value
                );

                if (option) {
                    selectManga(option);
                    search.value = option.dataset.title;
                }

            }

        });
    </script>

</x-app-layout>