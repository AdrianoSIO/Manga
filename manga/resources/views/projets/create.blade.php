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

                <div class="mt-6">
                    <label
                        for="nom"
                        class="text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"
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

                <div class="mt-6">
                    <label
                        for="budget"
                        class="text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"
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

                        <span class="absolute right-4 top-1/2 -translate-y-1/2 font-black text-zinc-400">
                            €
                        </span>
                    </div>

                    @error('budget')
                        <p class="mt-2 text-xs font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label
                            for="date_debut"
                            class="text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"
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
                            class="text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"
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

                <div class="mt-6">
                    <label
                        for="description"
                        class="text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"
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
                               transition hover:translate-x-1 hover:translate-y-1 hover:shadow-none
                               dark:border-zinc-100 dark:shadow-[4px_4px_0_#f4f4f5]"
                    >
                        Créer le projet →
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>