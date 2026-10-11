<x-app-layout>
    <x-slot name="title">Achats manga</x-slot>

    <div class="min-h-screen bg-[#f7f3eb] text-zinc-900 dark:bg-[#111113] dark:text-zinc-100">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-2 flex items-center gap-3">
                        <span class="bg-red-600 px-2 py-1 text-xs font-black text-white">
                            購入リスト
                        </span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">
                            Liste d'achats
                        </span>
                    </div>

                    <h1 class="text-3xl font-black sm:text-4xl">
                        Mangas recherchés
                    </h1>

                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                        Les tomes que tu veux ajouter à ta collection.
                    </p>
                </div>

                <a
                    href="{{ route('achats.create') }}"
                    class="border-2 border-zinc-900 bg-red-600 px-5 py-3 text-center text-sm font-black uppercase text-white dark:border-zinc-600"
                >
                    + Ajouter un tome
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 border-2 border-zinc-900 bg-white p-4 font-bold dark:border-zinc-600 dark:bg-[#18181b]">
                    {{ session('success') }}
                </div>
            @endif

            @if ($mangas->isEmpty())
                <div class="border-2 border-dashed border-zinc-400 bg-[#fffdf8] p-12 text-center dark:border-zinc-700 dark:bg-[#18181b]">
                    <div class="text-6xl font-black text-zinc-200 dark:text-zinc-700">
                        買
                    </div>

                    <h2 class="mt-4 text-xl font-black">
                        Rien à acheter
                    </h2>

                    <p class="mt-2 text-sm text-zinc-500">
                        Ajoute les prochains mangas que tu recherches.
                    </p>
                </div>
            @else
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($mangas as $groupe)
                        @php
                            $manga = $groupe['manga'];
                            $tomes = $groupe['tomes'];

                            $offresDisponibles = $tomes
                                ->flatMap->offres
                                ->where('disponible', true);

                            $prixMin = $offresDisponibles
                                ->whereNotNull('prix')
                                ->min('prix');
                        @endphp

                        <a
                            href="{{ route('achats.show', $manga) }}"
                            class="group flex flex-col border-2 border-zinc-900 bg-[#fffdf8] shadow-[5px_5px_0_#18181b] transition hover:-translate-x-0.5 hover:-translate-y-0.5 dark:border-zinc-600 dark:bg-[#18181b] dark:shadow-[5px_5px_0_#52525b]"
                        >
                            <div class="border-b-2 border-zinc-900 p-5 dark:border-zinc-600">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-red-600">
                                    Licence recherchée
                                </p>

                                <h2 class="mt-2 text-xl font-black">
                                    {{ $manga->titre }}
                                </h2>

                                <div class="mt-3 flex flex-wrap gap-1">
                                    @foreach ($manga->genres as $genre)
                                        <span class="bg-red-100 px-2 py-1 text-[10px] font-black uppercase text-red-700 dark:bg-red-950/40 dark:text-red-300">
                                            {{ $genre->nom }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex-1 p-5">
                                <p class="text-sm font-bold">
                                    {{ $tomes->count() }}
                                    {{ $tomes->count() > 1 ? 'tomes recherchés' : 'tome recherché' }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach ($tomes as $tome)
                                        <span class="border border-zinc-300 px-2 py-1 text-xs font-black dark:border-zinc-700">
                                            T{{ $tome->numero }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="mt-5">
                                    @if ($prixMin !== null)
                                        <p class="text-xs font-bold uppercase text-zinc-400">
                                            Meilleure offre
                                        </p>

                                        <p class="text-2xl font-black text-red-600">
                                            {{ number_format((float) $prixMin, 2, ',', ' ') }} €
                                        </p>
                                    @else
                                        <p class="text-sm font-bold text-zinc-500">
                                            Aucune offre disponible
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t-2 border-zinc-900 p-4 text-right text-xs font-black uppercase dark:border-zinc-600">
                                Voir les offres →
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>