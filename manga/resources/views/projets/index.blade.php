<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-red-600">
                    計画 • Projects
                </p>

                <h2 class="mt-1 text-2xl font-black uppercase text-zinc-950 dark:text-zinc-100">
                    Mes projets
                </h2>
            </div>

            <a
                href="{{ route('projets.create') }}"
                class="border-2 border-zinc-950 bg-red-600 px-4 py-2
                       text-xs font-black uppercase tracking-wider text-white
                       shadow-[4px_4px_0_#18181b]
                       transition hover:translate-x-1 hover:translate-y-1 hover:shadow-none
                       dark:border-zinc-100 dark:shadow-[4px_4px_0_#f4f4f5]"
            >
                ＋ Nouveau projet
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 border-l-4 border-red-600 bg-white px-4 py-3
                            text-sm font-bold text-zinc-800
                            dark:bg-zinc-900 dark:text-zinc-100">
                    {{ session('success') }}
                </div>
            @endif

            @if ($projets->isEmpty())
                <div class="border-2 border-zinc-950 bg-[#fffdf8] p-10 text-center
                            shadow-[6px_6px_0_#18181b]
                            dark:border-zinc-700 dark:bg-zinc-900
                            dark:shadow-[6px_6px_0_#3f3f46]">

                    <div class="text-5xl font-black text-red-600">
                        計
                    </div>

                    <h3 class="mt-4 text-xl font-black uppercase text-zinc-950 dark:text-white">
                        Aucun projet
                    </h3>

                    <p class="mx-auto mt-2 max-w-lg text-sm text-zinc-500 dark:text-zinc-400">
                        Crée un projet avec un budget fixe, puis compare plusieurs possibilités.
                    </p>

                    <a
                        href="{{ route('projets.create') }}"
                        class="mt-6 inline-block bg-zinc-950 px-5 py-3
                               text-xs font-black uppercase tracking-wider text-white
                               transition hover:bg-red-600
                               dark:bg-zinc-100 dark:text-zinc-950
                               dark:hover:bg-red-600 dark:hover:text-white"
                    >
                        Créer mon premier projet
                    </a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($projets as $projet)
                        <article
                            class="flex flex-col border-2 border-zinc-950 bg-[#fffdf8] p-5
                                   shadow-[5px_5px_0_#18181b]
                                   transition hover:-translate-y-1
                                   dark:border-zinc-700 dark:bg-zinc-900
                                   dark:shadow-[5px_5px_0_#3f3f46]"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[9px] font-black uppercase tracking-[0.25em] text-red-600">
                                        PROJECT #{{ str_pad($projet->id, 3, '0', STR_PAD_LEFT) }}
                                    </p>

                                    <h3 class="mt-2 text-xl font-black text-zinc-950 dark:text-white">
                                        {{ $projet->nom }}
                                    </h3>
                                </div>

                                <div class="bg-zinc-950 px-3 py-2 text-right text-white dark:bg-zinc-100 dark:text-zinc-950">
                                    <p class="text-[8px] font-black uppercase tracking-widest opacity-60">
                                        Budget
                                    </p>

                                    <p class="text-lg font-black">
                                        {{ number_format((float) $projet->budget, 2, ',', ' ') }} €
                                    </p>
                                </div>
                            </div>

                            @if ($projet->description)
                                <p class="mt-4 line-clamp-3 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                    {{ $projet->description }}
                                </p>
                            @endif

                            <div class="mt-5 border-y border-zinc-200 py-3 dark:border-zinc-700">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-zinc-500 dark:text-zinc-400">
                                        Possibilités
                                    </span>

                                    <span class="font-black text-zinc-950 dark:text-white">
                                        {{ $projet->possibilites_count }}
                                    </span>
                                </div>

                                @if ($projet->date_debut || $projet->date_fin)
                                    <div class="mt-2 flex items-center justify-between gap-3 text-xs">
                                        <span class="font-bold text-zinc-500 dark:text-zinc-400">
                                            Dates
                                        </span>

                                        <span class="text-right font-black text-zinc-950 dark:text-white">
                                            {{ $projet->date_debut?->format('d/m/Y') ?? '—' }}
                                            →
                                            {{ $projet->date_fin?->format('d/m/Y') ?? '—' }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto pt-5">
                                <a
                                    href="{{ route('projets.show', $projet) }}"
                                    class="block border-2 border-zinc-950 px-4 py-3 text-center
                                           text-xs font-black uppercase tracking-wider
                                           text-zinc-950 transition
                                           hover:bg-zinc-950 hover:text-white
                                           dark:border-zinc-100 dark:text-zinc-100
                                           dark:hover:bg-zinc-100 dark:hover:text-zinc-950"
                                >
                                    Ouvrir le projet →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>