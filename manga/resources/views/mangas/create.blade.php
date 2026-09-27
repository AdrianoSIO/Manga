<x-app-layout>

    <x-slot name="title">
        Nouvelle licence
    </x-slot>

    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.25em] text-red-600">
                新しい漫画
            </p>

            <h1 class="mt-1 text-xl font-black text-gray-900 sm:text-2xl">
                Ajouter une licence
            </h1>
        </div>
    </x-slot>

    <div class="py-6 sm:py-10">

        <div class="mx-auto max-w-2xl px-3 sm:px-6">

            {{-- ============================================
                LICENCES SIMILAIRES
            ============================================= --}}
            @if (session('similar_mangas'))

                <div class="mb-6 overflow-hidden rounded-xl
                            border border-orange-300 bg-orange-50">

                    <div class="border-b border-orange-200 p-4 sm:p-5">

                        <p class="text-xs font-black uppercase
                                  tracking-[0.2em] text-orange-600">
                            ⚠ Licence similaire détectée
                        </p>

                        <h2 class="mt-2 font-black text-gray-900">
                            Cette licence existe peut-être déjà
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Des titres proches ont été trouvés.
                            Vérifie avant de créer un doublon.
                        </p>

                    </div>

                    <div class="divide-y divide-orange-200">

                        @foreach (session('similar_mangas') as $similar)

                            <div class="flex items-center justify-between
                                        gap-4 p-4">

                                <div class="min-w-0">

                                    <p class="truncate font-bold text-gray-900">
                                        {{ $similar->titre }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Similarité :
                                        {{ $similar->similarity }} %
                                    </p>

                                </div>

                                <a
                                    href="{{ route('collection.show', $similar) }}"
                                    class="shrink-0 rounded-lg border
                                           border-orange-300 bg-white
                                           px-3 py-2 text-xs font-bold
                                           text-orange-700 transition
                                           hover:bg-orange-100"
                                >
                                    Voir
                                </a>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- ============================================
                ERREURS
            ============================================= --}}
            @if ($errors->any())

                <div class="mb-5 rounded-xl border border-red-200
                            bg-red-50 p-4">

                    <p class="font-bold text-red-800">
                        Vérifie le formulaire
                    </p>

                    <ul class="mt-2 list-inside list-disc
                               text-sm text-red-700">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- ============================================
                FORMULAIRE
            ============================================= --}}
            <form
                action="{{ route('mangas.store') }}"
                method="POST"
                class="overflow-hidden rounded-xl
                       border border-gray-200 bg-white shadow-sm"
            >

                @csrf

                {{-- Autorisation de créer malgré la similarité --}}
                @if (session('similar_mangas'))
                    <input
                        type="hidden"
                        name="confirm_similar"
                        value="1"
                    >
                @endif

                <div class="h-1.5 bg-red-600"></div>


                <div class="space-y-8 p-5 sm:p-8">

                    {{-- ========================================
                        TITRE
                    ========================================= --}}
                    <div>

                        <label
                            for="titre"
                            class="mb-2 block text-sm font-bold text-gray-900"
                        >
                            Nom de la licence
                        </label>

                        <input
                            id="titre"
                            name="titre"
                            type="text"
                            required
                            maxlength="255"
                            autocomplete="off"
                            value="{{ old('titre') }}"
                            placeholder="Ex : One Piece"
                            class="w-full rounded-xl border-gray-300
                                   focus:border-red-500
                                   focus:ring-red-500"
                        >

                        @error('titre')
                            <p class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p class="mt-2 text-xs leading-relaxed text-gray-500">
                            Le nom sera enregistré exactement comme tu
                            l'écris. Une vérification sera effectuée pour
                            détecter les licences ayant un nom similaire.
                        </p>

                    </div>


                    {{-- ========================================
                        GENRES
                    ========================================= --}}
                    <div>

                        <div class="mb-4">

                            <p class="text-sm font-bold text-gray-900">
                                Genres
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Sélectionne tous les genres correspondant
                                au manga.
                            </p>

                        </div>


                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">

                            @foreach ($genres as $genre)

                                <label class="cursor-pointer">

                                    <input
                                        type="checkbox"
                                        name="genres[]"
                                        value="{{ $genre->id }}"
                                        class="peer sr-only"
                                        @checked(
                                            in_array(
                                                $genre->id,
                                                old('genres', [])
                                            )
                                        )
                                    >

                                    <div
                                        class="flex min-h-12 items-center
                                               justify-center rounded-xl
                                               border border-gray-200
                                               bg-white px-3 py-2
                                               text-center text-xs font-bold
                                               text-gray-600 transition

                                               hover:border-red-300

                                               peer-checked:border-red-600
                                               peer-checked:bg-red-600
                                               peer-checked:text-white"
                                    >
                                        {{ $genre->nom }}
                                    </div>

                                </label>

                            @endforeach

                        </div>

                        @error('genres')
                            <p class="mt-3 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- ========================================
                        ACTIONS
                    ========================================= --}}
                    <div
                        class="flex flex-col-reverse gap-3
                               border-t border-gray-100 pt-6
                               sm:flex-row sm:justify-end"
                    >

                        <a
                            href="{{ route('collection.index') }}"
                            class="flex w-full items-center justify-center
                                   rounded-lg px-5 py-3
                                   text-sm font-bold text-gray-500
                                   transition hover:bg-gray-100
                                   sm:w-auto"
                        >
                            Annuler
                        </a>


                        <button
                            type="submit"
                            class="w-full rounded-lg bg-red-600
                                   px-6 py-3 text-sm font-bold
                                   text-white transition
                                   hover:bg-red-700 sm:w-auto"
                        >

                            @if (session('similar_mangas'))
                                Créer quand même
                            @else
                                Créer la licence
                            @endif

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>