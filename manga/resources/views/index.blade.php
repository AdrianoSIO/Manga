<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="text-xl font-semibold text-gray-800">
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

                <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-800">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Statistiques --}}
            <div class="mb-8 grid gap-6 md:grid-cols-2">

                <div class="rounded-xl bg-white p-6 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Licences
                    </p>

                    <p class="mt-2 text-4xl font-bold text-gray-900">
                        {{ $totalLicences }}
                    </p>

                </div>


                <div class="rounded-xl bg-white p-6 shadow-sm">

                    <p class="text-sm text-gray-500">
                        Tomes physiques
                    </p>

                    <p class="mt-2 text-4xl font-bold text-gray-900">
                        {{ $totalExemplaires }}
                    </p>

                </div>

            </div>


            {{-- Liste mangas --}}
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($mangas as $manga)

                    <div
                        class="rounded-xl bg-white p-6 shadow-sm transition hover:shadow-md"
                    >

                        <div class="mb-4">

                            <h3 class="text-xl font-bold text-gray-900">

                                <a
                                    href="{{ route('collection.show', $manga) }}"
                                    class="hover:text-indigo-600"
                                >
                                    {{ $manga->titre }}
                                </a>

                            </h3>


                            {{-- Genres --}}
                            <div class="mt-2 flex flex-wrap gap-2">

                                @foreach ($manga->genres as $genre)

                                    <span
                                        class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-600"
                                    >
                                        {{ $genre->nom }}
                                    </span>

                                @endforeach

                            </div>

                        </div>


                        <p class="mb-3 text-sm text-gray-500">

                            {{ $manga->tomes->count() }}

                            {{ $manga->tomes->count() > 1 ? 'exemplaires' : 'exemplaire' }}

                        </p>


                        {{-- Numéros --}}
                        <div class="flex flex-wrap gap-2">

                            @foreach ($manga->tomes as $tome)

                                <span
                                    class="rounded-lg bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700"
                                >
                                    {{ $tome->numero }}
                                </span>

                            @endforeach

                        </div>


                        <div class="mt-5">

                            <a
                                href="{{ route('collection.show', $manga) }}"
                                class="text-sm font-semibold text-indigo-600 hover:text-indigo-800"
                            >
                                Voir le manga →
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full rounded-xl bg-white p-10 text-center shadow-sm">

                        <p class="text-gray-500">
                            Aucun manga dans ta collection.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>