<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <a
                    href="{{ route('projets.index') }}"
                    class="text-[10px] font-black uppercase tracking-[0.25em]
                           text-zinc-400 transition hover:text-red-600"
                >
                    ← Projets
                </a>

                <p class="mt-3 text-[10px] font-black uppercase tracking-[0.3em] text-red-600">
                    計画 • Project
                </p>

                <h2 class="mt-1 text-2xl font-black text-zinc-950 dark:text-zinc-100">
                    {{ $projet->nom }}
                </h2>
            </div>

            <div
                class="border-2 border-zinc-950 bg-zinc-950 px-5 py-3
                       text-white
                       dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-950"
            >
                <p class="text-[8px] font-black uppercase tracking-[0.25em] opacity-60">
                    Budget global
                </p>

                <p class="mt-1 text-2xl font-black">
                    {{ number_format((float) $projet->budget, 2, ',', ' ') }} €
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =====================================================
                MESSAGES
            ====================================================== --}}

            @if (session('success'))
                <div
                    class="mb-6 border-l-4 border-red-600 bg-white px-4 py-3
                           text-sm font-bold text-zinc-800
                           dark:bg-zinc-900 dark:text-zinc-100"
                >
                    {{ session('success') }}
                </div>
            @endif

            {{-- =====================================================
                INFORMATIONS DU PROJET
            ====================================================== --}}

            <section
                class="mb-8 border-2 border-zinc-950 bg-[#fffdf8] p-5
                       dark:border-zinc-700 dark:bg-zinc-900"
            >
                <div class="grid gap-5 sm:grid-cols-3">

                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-zinc-400">
                            Début
                        </p>

                        <p class="mt-1 font-black text-zinc-950 dark:text-white">
                            {{ $projet->date_debut?->format('d/m/Y') ?? 'Non défini' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-zinc-400">
                            Fin
                        </p>

                        <p class="mt-1 font-black text-zinc-950 dark:text-white">
                            {{ $projet->date_fin?->format('d/m/Y') ?? 'Non définie' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-zinc-400">
                            Possibilités
                        </p>

                        <p class="mt-1 font-black text-zinc-950 dark:text-white">
                            {{ $projet->possibilites->count() }}
                        </p>
                    </div>

                </div>

                @if ($projet->description)
                    <div class="mt-5 border-t border-zinc-200 pt-5 dark:border-zinc-700">
                        <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                            {{ $projet->description }}
                        </p>
                    </div>
                @endif
            </section>

            {{-- =====================================================
                TITRE POSSIBILITÉS
            ====================================================== --}}

            <div
                class="mb-5 flex flex-col gap-4
                       sm:flex-row sm:items-end sm:justify-between"
            >
                <div>
                    <p class="text-[9px] font-black uppercase tracking-[0.25em] text-red-600">
                        比較 • Comparison
                    </p>

                    <h3 class="mt-1 text-xl font-black uppercase text-zinc-950 dark:text-white">
                        Possibilités
                    </h3>
                </div>

                <button
                    type="button"
                    onclick="
                        document
                            .getElementById('form-possibilite')
                            .classList.toggle('hidden')
                    "
                    class="border-2 border-zinc-950 bg-red-600 px-4 py-2
                           text-xs font-black uppercase tracking-wider text-white
                           shadow-[3px_3px_0_#18181b]
                           transition
                           hover:translate-x-[3px]
                           hover:translate-y-[3px]
                           hover:shadow-none
                           dark:border-zinc-100
                           dark:shadow-[3px_3px_0_#f4f4f5]"
                >
                    ＋ Ajouter une possibilité
                </button>
            </div>

            {{-- =====================================================
                FORMULAIRE AJOUT POSSIBILITÉ
            ====================================================== --}}

            <div
                id="form-possibilite"
                class="{{ $errors->any() ? '' : 'hidden' }}
                       mb-8 border-2 border-zinc-950
                       bg-[#fffdf8] p-5
                       shadow-[5px_5px_0_#18181b]
                       dark:border-zinc-700 dark:bg-zinc-900
                       dark:shadow-[5px_5px_0_#3f3f46]"
            >
                <div class="mb-5 border-b-2 border-zinc-950 pb-4 dark:border-zinc-700">
                    <p class="text-[9px] font-black uppercase tracking-[0.25em] text-red-600">
                        新しい可能性 • New possibility
                    </p>

                    <h4 class="mt-1 text-lg font-black text-zinc-950 dark:text-white">
                        Nouvelle possibilité
                    </h4>
                </div>

                <form
                    method="POST"
                    action="{{ route('projets.possibilites.store', $projet) }}"
                >
                    @csrf

                    <div>
                        <label
                            for="possibilite_nom"
                            class="text-xs font-black uppercase tracking-wider
                                   text-zinc-700 dark:text-zinc-300"
                        >
                            Nom *
                        </label>

                        <input
                            id="possibilite_nom"
                            name="nom"
                            type="text"
                            required
                            value="{{ old('nom') }}"
                            placeholder="Tokyo"
                            class="mt-2 w-full border-2 border-zinc-300
                                   bg-white px-4 py-3 text-zinc-950
                                   focus:border-red-600 focus:ring-red-600
                                   dark:border-zinc-700 dark:bg-zinc-950
                                   dark:text-white"
                        >

                        @error('nom')
                            <p class="mt-2 text-xs font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-5">
                        <label
                            for="possibilite_description"
                            class="text-xs font-black uppercase tracking-wider
                                   text-zinc-700 dark:text-zinc-300"
                        >
                            Description
                        </label>

                        <textarea
                            id="possibilite_description"
                            name="description"
                            rows="3"
                            placeholder="Voyage au Japon, hôtel à Shinjuku..."
                            class="mt-2 w-full border-2 border-zinc-300
                                   bg-white px-4 py-3 text-zinc-950
                                   focus:border-red-600 focus:ring-red-600
                                   dark:border-zinc-700 dark:bg-zinc-950
                                   dark:text-white"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-2 text-xs font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-5 flex justify-end">
                        <button
                            type="submit"
                            class="bg-zinc-950 px-5 py-3
                                   text-xs font-black uppercase tracking-wider
                                   text-white transition hover:bg-red-600
                                   dark:bg-zinc-100 dark:text-zinc-950
                                   dark:hover:bg-red-600 dark:hover:text-white"
                        >
                            Ajouter →
                        </button>
                    </div>
                </form>
            </div>

            {{-- =====================================================
                AUCUNE POSSIBILITÉ
            ====================================================== --}}

            @if ($projet->possibilites->isEmpty())

                <div
                    class="border-2 border-dashed border-zinc-300 p-10 text-center
                           dark:border-zinc-700"
                >
                    <p class="text-4xl font-black text-zinc-300 dark:text-zinc-700">
                        ?
                    </p>

                    <p class="mt-3 font-black uppercase text-zinc-950 dark:text-white">
                        Aucune possibilité
                    </p>

                    <p class="mx-auto mt-2 max-w-lg text-sm text-zinc-500 dark:text-zinc-400">
                        Ajoute plusieurs scénarios pour les comparer avec le même budget.
                    </p>

                    <p class="mt-3 text-xs font-bold text-zinc-400">
                        Exemple : Tokyo • New York • Séoul
                    </p>
                </div>

            @else

                {{-- =================================================
                    GRILLE DES POSSIBILITÉS
                ================================================== --}}

                <div class="grid gap-6 lg:grid-cols-2">

                    @foreach ($projet->possibilites as $possibilite)

                        @php
                            $budget = $possibilite->budget;

                            $totalDepenses =
                                (float) ($budget?->total_depenses ?? 0);

                            $reste =
                                (float) ($budget?->reste ?? $projet->budget);

                            $pourcentage =
                                (float) ($budget?->pourcentage_budget ?? 0);

                            $horsBudget =
                                (bool) ($budget?->hors_budget ?? false);
                        @endphp

                        <article
                            class="overflow-hidden border-2 border-zinc-950
                                   bg-[#fffdf8]
                                   shadow-[5px_5px_0_#18181b]
                                   dark:border-zinc-700 dark:bg-zinc-900
                                   dark:shadow-[5px_5px_0_#3f3f46]"
                        >

                            {{-- HEADER --}}
                            <header
                                class="border-b-2 border-zinc-950 p-5
                                       dark:border-zinc-700"
                            >
                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">
                                        <p
                                            class="text-[9px] font-black uppercase
                                                   tracking-widest text-red-600"
                                        >
                                            Possibilité
                                            #{{ str_pad($possibilite->id, 2, '0', STR_PAD_LEFT) }}
                                        </p>

                                        <h4
                                            class="mt-1 break-words text-xl font-black
                                                   text-zinc-950 dark:text-white"
                                        >
                                            {{ $possibilite->nom }}
                                        </h4>

                                        @if ($possibilite->description)
                                            <p
                                                class="mt-2 text-sm leading-6
                                                       text-zinc-500 dark:text-zinc-400"
                                            >
                                                {{ $possibilite->description }}
                                            </p>
                                        @endif
                                    </div>

                                    @if ($possibilite->statut === 'choisie')
                                        <span
                                            class="shrink-0 bg-red-600 px-2 py-1
                                                   text-[9px] font-black uppercase
                                                   tracking-wider text-white"
                                        >
                                            Choisie
                                        </span>
                                    @elseif ($possibilite->statut === 'favori')
                                        <span
                                            class="shrink-0 bg-zinc-950 px-2 py-1
                                                   text-[9px] font-black uppercase
                                                   tracking-wider text-white
                                                   dark:bg-zinc-100 dark:text-zinc-950"
                                        >
                                            Favori
                                        </span>
                                    @elseif ($possibilite->statut === 'ecartee')
                                        <span
                                            class="shrink-0 border border-zinc-300 px-2 py-1
                                                   text-[9px] font-black uppercase
                                                   tracking-wider text-zinc-400
                                                   dark:border-zinc-700"
                                        >
                                            Écartée
                                        </span>
                                    @else
                                        <span
                                            class="shrink-0 bg-zinc-200 px-2 py-1
                                                   text-[9px] font-black uppercase
                                                   tracking-wider text-zinc-700
                                                   dark:bg-zinc-800 dark:text-zinc-300"
                                        >
                                            À étudier
                                        </span>
                                    @endif

                                </div>
                            </header>

                            {{-- BUDGET --}}
                            <div
                                class="grid grid-cols-3 border-b
                                       border-zinc-200 dark:border-zinc-700"
                            >
                                <div class="p-4">
                                    <p
                                        class="text-[8px] font-black uppercase
                                               tracking-widest text-zinc-400"
                                    >
                                        Dépenses
                                    </p>

                                    <p class="mt-1 font-black text-zinc-950 dark:text-white">
                                        {{ number_format($totalDepenses, 2, ',', ' ') }} €
                                    </p>
                                </div>

                                <div
                                    class="border-x border-zinc-200 p-4
                                           dark:border-zinc-700"
                                >
                                    <p
                                        class="text-[8px] font-black uppercase
                                               tracking-widest text-zinc-400"
                                    >
                                        Reste
                                    </p>

                                    <p
                                        class="mt-1 font-black
                                               {{ $horsBudget
                                                    ? 'text-red-600'
                                                    : 'text-zinc-950 dark:text-white' }}"
                                    >
                                        {{ number_format($reste, 2, ',', ' ') }} €
                                    </p>
                                </div>

                                <div class="p-4">
                                    <p
                                        class="text-[8px] font-black uppercase
                                               tracking-widest text-zinc-400"
                                    >
                                        Budget
                                    </p>

                                    <p
                                        class="mt-1 font-black
                                               {{ $horsBudget
                                                    ? 'text-red-600'
                                                    : 'text-zinc-950 dark:text-white' }}"
                                    >
                                        {{ number_format($pourcentage, 1, ',', ' ') }} %
                                    </p>
                                </div>
                            </div>

                            {{-- BARRE BUDGET --}}
                            <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-700">
                                <div
                                    class="h-2 overflow-hidden border border-zinc-300
                                           bg-zinc-100 dark:border-zinc-700
                                           dark:bg-zinc-950"
                                >
                                    <div
                                        class="{{ $horsBudget ? 'bg-red-600' : 'bg-zinc-950 dark:bg-zinc-100' }}
                                               h-full"
                                        style="width: {{ min(max($pourcentage, 0), 100) }}%"
                                    ></div>
                                </div>

                                @if ($horsBudget)
                                    <p
                                        class="mt-2 text-[10px] font-black uppercase
                                               tracking-wider text-red-600"
                                    >
                                        Budget dépassé
                                    </p>
                                @endif
                            </div>

                            {{-- CATÉGORIES --}}
                            <div class="space-y-4 p-5">

                                @forelse ($possibilite->categories as $categorie)

                                    <div class="border border-zinc-200 dark:border-zinc-700">

                                        <div class="bg-zinc-100 px-4 py-2 dark:bg-zinc-800">
                                            <p
                                                class="text-xs font-black uppercase
                                                       tracking-wider text-zinc-950
                                                       dark:text-white"
                                            >
                                                {{ $categorie->nom }}
                                            </p>
                                        </div>

                                        <div class="divide-y divide-zinc-200 dark:divide-zinc-700">

                                            @forelse ($categorie->elements as $element)

                                                <div
                                                    class="flex items-center
                                                           justify-between gap-4 px-4 py-3"
                                                >
                                                    <div class="min-w-0">

                                                        <p
                                                            class="truncate text-sm font-bold
                                                                   {{ $element->selectionne
                                                                        ? 'text-red-600'
                                                                        : 'text-zinc-700 dark:text-zinc-300' }}"
                                                        >
                                                            {{ $element->selectionne ? '●' : '○' }}
                                                            {{ $element->nom }}
                                                        </p>

                                                        @if ($element->quantite > 1)
                                                            <p class="mt-1 text-[10px] text-zinc-400">
                                                                Quantité × {{ $element->quantite }}
                                                            </p>
                                                        @endif

                                                    </div>

                                                    <p
                                                        class="shrink-0 text-sm font-black
                                                               text-zinc-950 dark:text-white"
                                                    >
                                                        {{ number_format(
                                                            (float) $element->prix * $element->quantite,
                                                            2,
                                                            ',',
                                                            ' '
                                                        ) }} €
                                                    </p>
                                                </div>

                                            @empty

                                                <p class="px-4 py-3 text-xs text-zinc-400">
                                                    Aucun élément.
                                                </p>

                                            @endforelse

                                        </div>
                                    </div>

                                @empty

                                    <div
                                        class="border border-dashed border-zinc-300
                                               px-4 py-6 text-center
                                               dark:border-zinc-700"
                                    >
                                        <p class="text-xs font-bold text-zinc-400">
                                            Aucune catégorie pour le moment.
                                        </p>
                                    </div>

                                @endforelse

                            </div>

                            {{-- GESTION POSSIBILITÉ --}}
                            <div
                                class="border-t-2 border-zinc-950 p-5
                                       dark:border-zinc-700"
                            >
                                <p
                                    class="mb-3 text-[9px] font-black uppercase
                                           tracking-[0.2em] text-zinc-400"
                                >
                                    Gestion
                                </p>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'projets.possibilites.update',
                                        [$projet, $possibilite]
                                    ) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="hidden"
                                        name="nom"
                                        value="{{ $possibilite->nom }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="description"
                                        value="{{ $possibilite->description }}"
                                    >

                                    <div class="flex flex-col gap-3 sm:flex-row">

                                        <select
                                            name="statut"
                                            class="min-w-0 flex-1 border-2 border-zinc-300
                                                   bg-white px-3 py-2 text-xs font-bold
                                                   text-zinc-950
                                                   focus:border-red-600 focus:ring-red-600
                                                   dark:border-zinc-700 dark:bg-zinc-950
                                                   dark:text-white"
                                        >
                                            <option
                                                value="a_etudier"
                                                @selected($possibilite->statut === 'a_etudier')
                                            >
                                                À étudier
                                            </option>

                                            <option
                                                value="favori"
                                                @selected($possibilite->statut === 'favori')
                                            >
                                                Favori
                                            </option>

                                            <option
                                                value="choisie"
                                                @selected($possibilite->statut === 'choisie')
                                            >
                                                Choisie
                                            </option>

                                            <option
                                                value="ecartee"
                                                @selected($possibilite->statut === 'ecartee')
                                            >
                                                Écartée
                                            </option>
                                        </select>

                                        <button
                                            type="submit"
                                            class="bg-zinc-950 px-4 py-2
                                                   text-xs font-black uppercase
                                                   tracking-wider text-white
                                                   transition hover:bg-red-600
                                                   dark:bg-zinc-100
                                                   dark:text-zinc-950
                                                   dark:hover:bg-red-600
                                                   dark:hover:text-white"
                                        >
                                            Modifier
                                        </button>
                                    </div>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'projets.possibilites.destroy',
                                        [$projet, $possibilite]
                                    ) }}"
                                    class="mt-4"
                                    onsubmit="return confirm(
                                        'Supprimer cette possibilité et tout son contenu ?'
                                    )"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-[10px] font-black uppercase
                                               tracking-wider text-zinc-400
                                               transition hover:text-red-600"
                                    >
                                        Supprimer la possibilité
                                    </button>
                                </form>
                            </div>

                        </article>

                    @endforeach

                </div>

            @endif

            {{-- =====================================================
                SUPPRESSION PROJET
            ====================================================== --}}

            <div
                class="mt-10 border-t-2 border-zinc-950 pt-6
                       dark:border-zinc-700"
            >
                <form
                    method="POST"
                    action="{{ route('projets.destroy', $projet) }}"
                    onsubmit="return confirm(
                        'Supprimer définitivement ce projet et toutes ses possibilités ?'
                    )"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="text-xs font-black uppercase tracking-wider
                               text-zinc-400 transition hover:text-red-600"
                    >
                        Supprimer le projet
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>