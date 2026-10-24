<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-red-600">
                新規計画 • New project
            </p>

            <h2 class="mt-1 text-2xl font-black uppercase text-zinc-950 dark:text-zinc-100">
                Nouveau projet
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div
                    class="mb-6 border-l-4 border-red-600 bg-white px-4 py-3
                           text-sm font-bold text-zinc-800
                           dark:bg-zinc-900 dark:text-zinc-100"
                >
                    {{ session('success') }}
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('projets.store') }}"
                class="border-2 border-zinc-950 bg-[#fffdf8] p-6
                       shadow-[6px_6px_0_#18181b]
                       dark:border-zinc-700 dark:bg-zinc-900
                       dark:shadow-[6px_6px_0_#3f3f46]"
            >
                @csrf

                <div class="border-b-2 border-zinc-950 pb-4 dark:border-zinc-700">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-red-600">
                        01 — Informations
                    </p>

                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                        Le budget sera partagé par toutes les possibilités du projet.
                    </p>
                </div>

                {{-- Nom --}}

                <div class="mt-6">
                    <label
                        for="nom"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-700 dark:text-zinc-300"
                    >
                        Nom du projet *
                    </label>

                    <input
                        id="nom"
                        name="nom"
                        type="text"
                        value="{{ old('nom') }}"
                        required
                        placeholder="Vacances hiver 2026"
                        class="mt-2 w-full border-2 border-zinc-300 bg-white px-4 py-3
                               text-zinc-950 focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >

                    @error('nom')
                        <p class="mt-2 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Type --}}

                <div class="mt-6">
                    <div class="flex items-end justify-between gap-4">
                        <label
                            for="type"
                            class="text-xs font-black uppercase tracking-wider
                                   text-zinc-700 dark:text-zinc-300"
                        >
                            Type de projet
                        </label>

                        <button
                            type="button"
                            onclick="
                                document
                                    .getElementById('form-nouveau-type')
                                    .classList.toggle('hidden')
                            "
                            class="text-[10px] font-black uppercase tracking-wider
                                   text-red-600 transition hover:text-red-700"
                        >
                            ＋ Nouveau type
                        </button>
                    </div>

                    <select
                        id="type"
                        name="type"
                        class="mt-2 w-full border-2 border-zinc-300 bg-white px-4 py-3
                               text-zinc-950 focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >
                        <option value="">
                            Non défini
                        </option>

                        @foreach ($types as $type)
                            <option
                                value="{{ $type->nom }}"
                                @selected(
                                    old('type', session('nouveau_type')) === $type->nom
                                )
                            >
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>

                    @error('type')
                        <p class="mt-2 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Budget --}}

                <div class="mt-6">
                    <label
                        for="budget"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-700 dark:text-zinc-300"
                    >
                        Budget *
                    </label>

                    <div class="relative mt-2">
                        <input
                            id="budget"
                            name="budget"
                            type="number"
                            min="0"
                            step="0.01"
                            value="{{ old('budget') }}"
                            required
                            placeholder="2000"
                            class="w-full border-2 border-zinc-300 bg-white px-4 py-3 pr-12
                                   text-zinc-950 focus:border-red-600 focus:ring-red-600
                                   dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                        >

                        <span
                            class="absolute right-4 top-1/2 -translate-y-1/2
                                   font-black text-zinc-400"
                        >
                            €
                        </span>
                    </div>

                    @error('budget')
                        <p class="mt-2 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Dates --}}

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label
                            for="date_debut"
                            class="text-xs font-black uppercase tracking-wider
                                   text-zinc-700 dark:text-zinc-300"
                        >
                            Date de début
                        </label>

                        <input
                            id="date_debut"
                            name="date_debut"
                            type="date"
                            value="{{ old('date_debut') }}"
                            class="mt-2 w-full border-2 border-zinc-300 bg-white px-4 py-3
                                   text-zinc-950 focus:border-red-600 focus:ring-red-600
                                   dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                        >

                        @error('date_debut')
                            <p class="mt-2 text-xs font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="date_fin"
                            class="text-xs font-black uppercase tracking-wider
                                   text-zinc-700 dark:text-zinc-300"
                        >
                            Date de fin
                        </label>

                        <input
                            id="date_fin"
                            name="date_fin"
                            type="date"
                            value="{{ old('date_fin') }}"
                            class="mt-2 w-full border-2 border-zinc-300 bg-white px-4 py-3
                                   text-zinc-950 focus:border-red-600 focus:ring-red-600
                                   dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                        >

                        @error('date_fin')
                            <p class="mt-2 text-xs font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}

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
                        placeholder="Objectif du projet, contraintes, idées..."
                        class="mt-2 w-full border-2 border-zinc-300 bg-white px-4 py-3
                               text-zinc-950 focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
                    <a
                        href="{{ route('projets.index') }}"
                        class="px-4 py-3 text-center text-xs font-black uppercase
                               tracking-wider text-zinc-500 transition hover:text-zinc-950
                               dark:text-zinc-400 dark:hover:text-white"
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
                        Créer le projet →
                    </button>
                </div>
            </form>

            {{-- =====================================================
                GESTION DES TYPES
            ====================================================== --}}

            <section
                id="form-nouveau-type"
                class="hidden mt-8 border-2 border-zinc-950 bg-[#fffdf8] p-6
                       shadow-[5px_5px_0_#18181b]
                       dark:border-zinc-700 dark:bg-zinc-900
                       dark:shadow-[5px_5px_0_#3f3f46]"
            >
                <div class="border-b-2 border-zinc-950 pb-4 dark:border-zinc-700">
                    <p class="text-[9px] font-black uppercase tracking-[0.25em] text-red-600">
                        種類 • Types
                    </p>

                    <h3 class="mt-1 text-lg font-black uppercase text-zinc-950 dark:text-white">
                        Types de projet
                    </h3>
                </div>

                <form
                    method="POST"
                    action="{{ route('projets.types.store') }}"
                    class="mt-5 flex flex-col gap-3 sm:flex-row"
                >
                    @csrf

                    <input
                        type="text"
                        name="nom"
                        maxlength="100"
                        required
                        placeholder="Voyage, Voiture, Informatique..."
                        class="min-w-0 flex-1 border-2 border-zinc-300 bg-white
                               px-4 py-3 text-sm text-zinc-950
                               focus:border-red-600 focus:ring-red-600
                               dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                    >

                    <button
                        type="submit"
                        class="bg-zinc-950 px-5 py-3
                               text-xs font-black uppercase tracking-wider text-white
                               transition hover:bg-red-600
                               dark:bg-zinc-100 dark:text-zinc-950
                               dark:hover:bg-red-600 dark:hover:text-white"
                    >
                        Ajouter
                    </button>
                </form>

                @error('nom')
                    <p class="mt-2 text-xs font-bold text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                @if ($types->isNotEmpty())
                    <div class="mt-6 border-t border-zinc-200 pt-5 dark:border-zinc-700">
                        <p
                            class="mb-3 text-[9px] font-black uppercase
                                   tracking-widest text-zinc-400"
                        >
                            Types enregistrés
                        </p>

                        <div class="flex flex-wrap gap-2">
                            @foreach ($types as $type)
                                <div
                                    class="flex items-center border-2 border-zinc-300
                                           bg-white dark:border-zinc-700 dark:bg-zinc-950"
                                >
                                    <span
                                        class="px-3 py-2 text-xs font-black
                                               text-zinc-700 dark:text-zinc-300"
                                    >
                                        {{ $type->nom }}
                                    </span>

                                    <form
                                        method="POST"
                                        action="{{ route('projets.types.destroy', $type) }}"
                                        onsubmit="return confirm('Supprimer ce type de la liste ?')"
                                        class="border-l-2 border-zinc-300 dark:border-zinc-700"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Supprimer {{ $type->nom }}"
                                            class="px-3 py-2 text-xs font-black text-zinc-400
                                                   transition hover:bg-red-600 hover:text-white"
                                        >
                                            ×
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <p class="mt-4 text-[10px] leading-5 text-zinc-400">
                            Supprimer un type ici le retire uniquement de la liste.
                            Les projets qui utilisent déjà ce type ne sont pas modifiés.
                        </p>
                    </div>
                @endif
            </section>

        </div>
    </div>
</x-app-layout>