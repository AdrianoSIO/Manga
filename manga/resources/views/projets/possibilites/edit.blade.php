<x-app-layout>
    <x-slot name="header">
        <div>
            <a
                href="{{ route('projets.show', $projet) }}"
                class="text-[10px] font-black uppercase tracking-[0.25em]
                       text-zinc-400 transition hover:text-red-600"
            >
                ← {{ $projet->nom }}
            </a>

            <p class="mt-3 text-[10px] font-black uppercase tracking-[0.3em] text-red-600">
                可能性 • Possibility
            </p>

            <h2 class="mt-1 text-2xl font-black text-zinc-950 dark:text-zinc-100">
                Modifier {{ $possibilite->nom }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <form
                method="POST"
                action="{{ route(
                    'projets.possibilites.update',
                    [$projet, $possibilite]
                ) }}"
                class="border-2 border-zinc-950 bg-[#fffdf8] p-6
                       shadow-[6px_6px_0_#18181b]
                       dark:border-zinc-700 dark:bg-zinc-900
                       dark:shadow-[6px_6px_0_#3f3f46]"
            >
                @csrf
                @method('PATCH')

                <div>
                    <label
                        for="nom"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-700 dark:text-zinc-300"
                    >
                        Nom *
                    </label>

                    <input
                        id="nom"
                        name="nom"
                        type="text"
                        required
                        value="{{ old('nom', $possibilite->nom) }}"
                        class="mt-2 w-full border-2 border-zinc-300 bg-white
                               px-4 py-3 text-zinc-950
                               focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >
                </div>

                <div class="mt-6">
                    <label
                        for="statut"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-700 dark:text-zinc-300"
                    >
                        Statut
                    </label>

                    <select
                        id="statut"
                        name="statut"
                        class="mt-2 w-full border-2 border-zinc-300 bg-white
                               px-4 py-3 text-zinc-950
                               focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >
                        <option
                            value="a_etudier"
                            @selected(
                                old('statut', $possibilite->statut)
                                === 'a_etudier'
                            )
                        >
                            À étudier
                        </option>

                        <option
                            value="favori"
                            @selected(
                                old('statut', $possibilite->statut)
                                === 'favori'
                            )
                        >
                            Favori
                        </option>

                        <option
                            value="choisie"
                            @selected(
                                old('statut', $possibilite->statut)
                                === 'choisie'
                            )
                        >
                            Choisie
                        </option>

                        <option
                            value="ecartee"
                            @selected(
                                old('statut', $possibilite->statut)
                                === 'ecartee'
                            )
                        >
                            Écartée
                        </option>
                    </select>
                </div>

                <div class="mt-6">
                    <label
                        for="description"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-700 dark:text-zinc-300"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="mt-2 w-full border-2 border-zinc-300 bg-white
                               px-4 py-3 text-zinc-950
                               focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >{{ old('description', $possibilite->description) }}</textarea>
                </div>

                <div class="mt-8 flex items-center justify-between gap-4">
                    <a
                        href="{{ route('projets.show', $projet) }}"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-400 hover:text-zinc-950
                               dark:hover:text-white"
                    >
                        ← Annuler
                    </a>

                    <button
                        type="submit"
                        class="border-2 border-zinc-950 bg-red-600 px-6 py-3
                               text-xs font-black uppercase tracking-wider text-white
                               shadow-[4px_4px_0_#18181b]
                               transition
                               hover:translate-x-1 hover:translate-y-1 hover:shadow-none
                               dark:border-zinc-100
                               dark:shadow-[4px_4px_0_#f4f4f5]"
                    >
                        Enregistrer →
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>