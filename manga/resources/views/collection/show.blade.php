<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">

            <div>
                <a
                    href="{{ route('collection.index') }}"
                    class="text-sm font-semibold text-gray-500 transition hover:text-red-600"
                >
                    ← Retour à la collection
                </a>

                <p class="mt-4 text-xs font-bold uppercase tracking-[0.3em] text-red-600">
                    漫画 • Manga
                </p>

                <h2 class="mt-1 text-2xl font-black text-gray-900">
                    {{ $manga->titre }}
                </h2>
            </div>

            <a
                href="{{ route('tomes.create', ['manga' => $manga->id]) }}"
                class="rounded-lg bg-red-600 px-5 py-2.5 font-bold text-white transition hover:bg-red-700"
            >
                + Ajouter un tome
            </a>

        </div>
    </x-slot>


    <div class="py-10">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Message succès --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Informations manga --}}
            <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="h-2 bg-red-600"></div>

                <div class="p-6">

                    <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-center">

                        <div>

                            <p class="text-sm font-bold uppercase tracking-wider text-gray-400">
                                Licence
                            </p>

                            <h1 class="mt-1 text-3xl font-black text-gray-900">
                                {{ $manga->titre }}
                            </h1>

                        </div>


                        <div class="rounded-xl bg-gray-900 px-6 py-4 text-white">

                            <div class="text-3xl font-black">
                                {{ $tomes->count() }}
                            </div>

                            <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                                {{ $tomes->count() > 1 ? 'Exemplaires' : 'Exemplaire' }}
                            </div>

                        </div>

                    </div>


                    {{-- Genres --}}
                    <div class="mt-6 border-t border-gray-100 pt-6">

                        <p class="mb-3 text-sm font-bold text-gray-700">
                            Genres
                        </p>

                        <div class="flex flex-wrap gap-2">

                            @forelse ($manga->genres as $genre)

                                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-700">
                                    {{ $genre->nom }}
                                </span>

                            @empty

                                <span class="text-sm text-gray-400">
                                    Aucun genre
                                </span>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>


            {{-- Tomes --}}
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.25em] text-red-600">
                                所有巻
                            </p>

                            <h2 class="mt-1 text-xl font-black text-gray-900">
                                Mes tomes
                            </h2>
                        </div>

                        <span class="text-sm text-gray-400">
                            {{ $tomes->count() }} au total
                        </span>

                    </div>

                </div>


                <div class="divide-y divide-gray-100">

                    @forelse ($tomes as $tome)

                        <div class="flex items-center justify-between gap-4 p-5 transition hover:bg-gray-50">

                            <div class="flex items-center gap-4">

                                {{-- Numéro --}}
                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-900 font-black text-white">
                                    {{ $tome->numero }}
                                </div>


                                <div>

                                    <p class="font-bold text-gray-900">
                                        Tome {{ $tome->numero }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Exemplaire #{{ $tome->id }}
                                    </p>

                                </div>

                            </div>


                            {{-- Suppression --}}
                            <form
                                action="{{ route('tomes.destroy', $tome) }}"
                                method="POST"
                                onsubmit="return confirm('Supprimer cet exemplaire de ta collection ?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-600 transition hover:border-red-600 hover:bg-red-600 hover:text-white"
                                >
                                    Supprimer
                                </button>

                            </form>

                        </div>

                    @empty

                        <div class="p-12 text-center">

                            <div class="text-4xl font-black text-red-600">
                                空
                            </div>

                            <h3 class="mt-3 font-bold text-gray-900">
                                Aucun tome
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Tu ne possèdes encore aucun tome de cette licence.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</x-app-layout>