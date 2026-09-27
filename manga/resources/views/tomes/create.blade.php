<x-app-layout>

    <x-slot name="title">
        Ajouter un tome
    </x-slot>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-red-600">
                    新しい巻
                </p>

                <h1 class="mt-1 text-xl font-black text-gray-900 sm:text-2xl">
                    Ajouter un tome
                </h1>
            </div>

            <a
                href="{{ route('mangas.create') }}"
                class="flex items-center justify-center rounded-lg
                       border border-gray-300 bg-white px-4 py-2.5
                       text-sm font-bold text-gray-700 transition
                       hover:border-red-300 hover:bg-red-50 hover:text-red-600"
            >
                ＋ Nouvelle licence
            </a>

        </div>

    </x-slot>


    <div class="py-6 sm:py-10">

        <div class="mx-auto max-w-2xl px-3 sm:px-6">

            {{-- Succès --}}
            @if (session('success'))

                <div class="mb-5 rounded-xl border border-green-200
                            bg-green-50 p-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Erreurs --}}
            @if ($errors->any())

                <div class="mb-5 rounded-xl border border-red-200
                            bg-red-50 p-4">

                    <p class="font-bold text-red-800">
                        Vérifie le formulaire
                    </p>

                    <ul class="mt-2 list-inside list-disc text-sm text-red-700">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('tomes.store') }}"
                method="POST"
                class="overflow-hidden rounded-xl
                       border border-gray-200 bg-white shadow-sm"
            >

                @csrf

                <div class="h-1.5 bg-red-600"></div>


                <div class="space-y-7 p-5 sm:p-8">

                    {{-- =========================================
                        LICENCE
                    ========================================== --}}
                    <div>

                        <label
                            for="manga_id"
                            class="mb-2 block text-sm font-bold text-gray-900"
                        >
                            Licence
                        </label>


                        @if ($mangas->isEmpty())

                            <div class="rounded-xl border-2 border-dashed
                                        border-gray-300 bg-gray-50 p-6 text-center">

                                <p class="font-bold text-gray-900">
                                    Aucune licence disponible
                                </p>

                                <p class="mt-2 text-sm text-gray-500">
                                    Tu dois créer une licence avant de pouvoir
                                    ajouter un tome.
                                </p>

                                <a
                                    href="{{ route('mangas.create') }}"
                                    class="mt-5 inline-flex items-center
                                           justify-center rounded-lg
                                           bg-red-600 px-5 py-3
                                           text-sm font-bold text-white
                                           transition hover:bg-red-700"
                                >
                                    ＋ Créer une licence
                                </a>

                            </div>

                        @else

                            <select
                                id="manga_id"
                                name="manga_id"
                                required
                                class="w-full rounded-xl border-gray-300
                                       focus:border-red-500 focus:ring-red-500"
                            >

                                <option value="">
                                    Sélectionner une licence
                                </option>

                                @foreach ($mangas as $manga)

                                    <option
                                        value="{{ $manga->id }}"
                                        @selected(
                                            old('manga_id', request('manga'))
                                            == $manga->id
                                        )
                                    >
                                        {{ $manga->titre }}
                                    </option>

                                @endforeach

                            </select>


                            @error('manga_id')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror


                            <div class="mt-3">

                                <a
                                    href="{{ route('mangas.create') }}"
                                    class="text-xs font-bold text-red-600
                                           hover:text-red-800"
                                >
                                    Licence absente ? Crée-la d'abord →
                                </a>

                            </div>

                        @endif

                    </div>


                    {{-- =========================================
                        NUMÉRO DU TOME
                    ========================================== --}}
                    @if ($mangas->isNotEmpty())

                        <div>

                            <label
                                for="numero"
                                class="mb-2 block text-sm font-bold text-gray-900"
                            >
                                Numéro du tome
                            </label>

                            <input
                                id="numero"
                                name="numero"
                                type="number"
                                min="0"
                                inputmode="numeric"
                                required
                                value="{{ old('numero') }}"
                                placeholder="Ex : 12"
                                class="w-full rounded-xl border-gray-300
                                       focus:border-red-500 focus:ring-red-500"
                            >

                            @error('numero')
                                <p class="mt-2 text-sm font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror


                            <div class="mt-3 rounded-lg bg-gray-50 p-3">

                                <p class="text-xs leading-relaxed text-gray-500">
                                    Les genres sont liés à la licence.
                                    Tu n'as donc pas besoin de les sélectionner
                                    à nouveau.
                                </p>

                                <p class="mt-1 text-xs leading-relaxed text-gray-500">
                                    Plusieurs exemplaires du même tome sont autorisés.
                                </p>

                            </div>

                        </div>


                        {{-- =========================================
                            ACTIONS
                        ========================================== --}}
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
                                Ajouter le tome
                            </button>

                        </div>

                    @endif

                </div>

            </form>

        </div>

    </div>

</x-app-layout>