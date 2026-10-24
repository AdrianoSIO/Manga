<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

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

                <div class="mt-1 flex flex-wrap items-center gap-3">
                    <h2 class="text-2xl font-black text-zinc-950 dark:text-zinc-100">
                        {{ $projet->nom }}
                    </h2>

                    @if ($projet->type)
                        <span
                            class="border border-zinc-300 px-2 py-1
                                text-[9px] font-black uppercase tracking-widest
                                text-zinc-500
                                dark:border-zinc-700 dark:text-zinc-400"
                        >
                            {{ $projet->type }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <a
                    href="{{ route('projets.edit', $projet) }}"
                    class="border-2 border-zinc-950 px-4 py-3
                        text-center text-xs font-black uppercase tracking-wider
                        text-zinc-950 transition
                        hover:bg-zinc-950 hover:text-white
                        dark:border-zinc-100 dark:text-white
                        dark:hover:bg-zinc-100 dark:hover:text-zinc-950"
                >
                    ✎ Modifier le projet
                </a>

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

            @if ($errors->any())
                <div
                    class="mb-6 border-l-4 border-red-600 bg-red-50 px-4 py-3
                        text-sm text-red-700
                        dark:bg-red-950/30 dark:text-red-300"
                >
                    <p class="font-black uppercase">
                        Une erreur est survenue
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- =====================================================
            INFORMATIONS PROJET
            ====================================================== --}}

            <section
                class="mb-8 border-2 border-zinc-950 bg-[#fffdf8] p-5
                    dark:border-zinc-700 dark:bg-zinc-900"
            >
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-zinc-400">
                            Type
                        </p>

                        <p class="mt-1 font-black text-zinc-950 dark:text-white">
                            {{ $projet->type ?: 'Non défini' }}
                        </p>
                    </div>

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
            POSSIBILITÉS
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
            AJOUT POSSIBILITÉ
            ====================================================== --}}

            <div
                id="form-possibilite"
                class="hidden mb-8 border-2 border-zinc-950
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
                        placeholder="Tokyo, PC AMD, Appartement A..."
                        class="mt-2 w-full border-2 border-zinc-300
                            bg-white px-4 py-3 text-zinc-950
                            focus:border-red-600 focus:ring-red-600
                            dark:border-zinc-700 dark:bg-zinc-950
                            dark:text-white"
                        >
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
                            placeholder="Quelques détails sur cette possibilité..."
                            class="mt-2 w-full border-2 border-zinc-300
                                bg-white px-4 py-3 text-zinc-950
                                focus:border-red-600 focus:ring-red-600
                                dark:border-zinc-700 dark:bg-zinc-950
                                dark:text-white"
                            ></textarea>
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
        LISTE POSSIBILITÉS
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
            </div>

        @else

            <div class="grid gap-6 xl:grid-cols-2">

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

                        {{-- =====================================
                        HEADER POSSIBILITÉ
                        ====================================== --}}

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

                        {{-- =====================================
                        BUDGET
                        ====================================== --}}

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

                        <div
                            class="border-b border-zinc-200 px-5 py-4
                                dark:border-zinc-700"
                        >
                            <div
                                class="h-2 overflow-hidden border border-zinc-300
                                    bg-zinc-100
                                    dark:border-zinc-700 dark:bg-zinc-950"
                            >
                                <div
                                    class="{{ $horsBudget
                                        ? 'bg-red-600'
                                        : 'bg-zinc-950 dark:bg-zinc-100' }} h-full"
                                    style="width: {{ min(max($pourcentage, 0), 100) }}%"
                                    ></div>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between gap-3">
                                    <p class="text-[9px] font-bold text-zinc-400">
                                    {{ number_format($totalDepenses, 2, ',', ' ') }}
                                    /
                                    {{ number_format((float) $projet->budget, 2, ',', ' ') }}
                                    €
                                    </p>

                                    @if ($horsBudget)
                                    <p
                                    class="text-[9px] font-black uppercase
                                        tracking-wider text-red-600"
                                >
                                    Budget dépassé
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- =====================================
                    CATÉGORIES
                    ====================================== --}}

                    <div class="space-y-5 p-5">

                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p
                                    class="text-[9px] font-black uppercase
                                        tracking-[0.2em] text-zinc-400"
                                >
                                    Catégories
                                </p>

                                <p class="mt-1 text-xs text-zinc-400">
                                    {{ $possibilite->categories->count() }}
                                    catégorie{{ $possibilite->categories->count() > 1 ? 's' : '' }}
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="
                                document
                                .getElementById('categorie-form-{{ $possibilite->id }}')
                                .classList.toggle('hidden')
                                "
                                class="text-[10px] font-black uppercase
                                    tracking-wider text-red-600
                                    transition hover:text-red-700"
                            >
                                ＋ Catégorie
                            </button>
                        </div>

                        {{-- AJOUT CATÉGORIE --}}

                        <div
                            id="categorie-form-{{ $possibilite->id }}"
                            class="hidden border-2 border-dashed
                                border-zinc-300 p-4
                                dark:border-zinc-700"
                        >
                            <form
                                method="POST"
                                action="{{ route(
                                'projets.categories.store',
                                [$projet, $possibilite]
                                ) }}"
                                class="flex flex-col gap-3 sm:flex-row"
                            >
                                @csrf

                                <input
                                type="text"
                                name="nom"
                                required
                                placeholder="Vol, Hôtel, Transport, GPU..."
                                class="min-w-0 flex-1 border-2 border-zinc-300
                                    bg-white px-3 py-2 text-sm text-zinc-950
                                    focus:border-red-600 focus:ring-red-600
                                    dark:border-zinc-700 dark:bg-zinc-950
                                    dark:text-white"
                                >

                                <button
                                    type="submit"
                                    class="bg-zinc-950 px-4 py-2
                                        text-xs font-black uppercase
                                        tracking-wider text-white
                                        transition hover:bg-red-600
                                        dark:bg-zinc-100 dark:text-zinc-950
                                        dark:hover:bg-red-600
                                        dark:hover:text-white"
                                >
                                    Ajouter
                                </button>
                            </form>
                        </div>

                        {{-- LISTE CATÉGORIES --}}

                        @forelse ($possibilite->categories as $categorie)

                            <section
                                class="border-2 border-zinc-200
                                    dark:border-zinc-700"
                            >

                                {{-- HEADER CATÉGORIE --}}

                                <div
                                    class="flex items-center justify-between
                                        gap-4 bg-zinc-100 px-4 py-3
                                        dark:bg-zinc-800"
                                >
                                    <div>
                                        <p
                                            class="text-xs font-black uppercase
                                                tracking-wider text-zinc-950
                                                dark:text-white"
                                        >
                                            {{ $categorie->nom }}
                                        </p>

                                        <p
                                            class="mt-1 text-[9px] font-bold
                                                text-zinc-400"
                                        >
                                            {{ $categorie->elements->count() }}
                                            élément{{ $categorie->elements->count() > 1 ? 's' : '' }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-3">

                                        <button
                                            type="button"
                                            onclick="
                                            document
                                            .getElementById('element-form-{{ $categorie->id }}')
                                            .classList.toggle('hidden')
                                            "
                                            class="text-[9px] font-black uppercase
                                                tracking-wider text-red-600
                                                hover:text-red-700"
                                        >
                                            ＋ Élément
                                        </button>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                            'projets.categories.destroy',
                                            [
                                            $projet,
                                            $possibilite,
                                            $categorie
                                            ]
                                            ) }}"
                                            onsubmit="return confirm(
                                            'Supprimer cette catégorie et tous ses éléments ?'
                                            )"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-[9px] font-black
                                                    text-zinc-400
                                                    transition hover:text-red-600"
                                                title="Supprimer la catégorie"
                                            >
                                                ×
                                            </button>
                                        </form>

                                    </div>
                                </div>

                                {{-- =================================
                                AJOUT ÉLÉMENT
                                ================================== --}}

                                <div
                                    id="element-form-{{ $categorie->id }}"
                                    class="hidden border-b-2 border-zinc-200
                                        bg-zinc-50 p-4
                                        dark:border-zinc-700
                                        dark:bg-zinc-950/40"
                                >
                                    <form
                                        method="POST"
                                        action="{{ route(
                                        'projets.elements.store',
                                        [
                                        $projet,
                                        $possibilite,
                                        $categorie
                                        ]
                                        ) }}"
                                        class="space-y-3"
                                    >
                                        @csrf

                                        <div
                                            class="grid gap-3
                                                sm:grid-cols-2"
                                        >
                                            <div>
                                                <label
                                                    class="text-[9px] font-black
                                                        uppercase tracking-wider
                                                        text-zinc-400"
                                                >
                                                    Nom *
                                                </label>

                                                <input
                                                type="text"
                                                name="nom"
                                                required
                                                placeholder="Lufthansa"
                                                class="mt-1 w-full border-2
                                                    border-zinc-300 bg-white
                                                    px-3 py-2 text-sm
                                                    text-zinc-950
                                                    focus:border-red-600
                                                    focus:ring-red-600
                                                    dark:border-zinc-700
                                                    dark:bg-zinc-950
                                                    dark:text-white"
                                                >
                                            </div>

                                            <div>
                                                <label
                                                    class="text-[9px] font-black
                                                        uppercase tracking-wider
                                                        text-zinc-400"
                                                >
                                                    Prix *
                                                </label>

                                                <div class="relative mt-1">
                                                    <input
                                                    type="number"
                                                    name="prix"
                                                    min="0"
                                                    step="0.01"
                                                    required
                                                    placeholder="780"
                                                    class="w-full border-2
                                                        border-zinc-300 bg-white
                                                        px-3 py-2 pr-9 text-sm
                                                        text-zinc-950
                                                        focus:border-red-600
                                                        focus:ring-red-600
                                                        dark:border-zinc-700
                                                        dark:bg-zinc-950
                                                        dark:text-white"
                                                    >

                                                    <span
                                                        class="absolute right-3 top-1/2
                                                            -translate-y-1/2
                                                            text-xs font-black
                                                            text-zinc-400"
                                                    >
                                                        €
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="grid gap-3
                                                sm:grid-cols-[120px_1fr]"
                                        >
                                            <div>
                                                <label
                                                    class="text-[9px] font-black
                                                        uppercase tracking-wider
                                                        text-zinc-400"
                                                >
                                                    Quantité
                                                </label>

                                                <input
                                                type="number"
                                                name="quantite"
                                                min="1"
                                                value="1"
                                                required
                                                class="mt-1 w-full border-2
                                                    border-zinc-300 bg-white
                                                    px-3 py-2 text-sm
                                                    text-zinc-950
                                                    focus:border-red-600
                                                    focus:ring-red-600
                                                    dark:border-zinc-700
                                                    dark:bg-zinc-950
                                                    dark:text-white"
                                                >
                                            </div>

                                            <div>
                                                <label
                                                    class="text-[9px] font-black
                                                        uppercase tracking-wider
                                                        text-zinc-400"
                                                >
                                                    Lien
                                                </label>

                                                <input
                                                type="url"
                                                name="url"
                                                placeholder="https://..."
                                                class="mt-1 w-full border-2
                                                    border-zinc-300 bg-white
                                                    px-3 py-2 text-sm
                                                    text-zinc-950
                                                    focus:border-red-600
                                                    focus:ring-red-600
                                                    dark:border-zinc-700
                                                    dark:bg-zinc-950
                                                    dark:text-white"
                                                >
                                            </div>
                                        </div>

                                        <div>
                                            <label
                                                class="text-[9px] font-black
                                                    uppercase tracking-wider
                                                    text-zinc-400"
                                            >
                                                Notes
                                            </label>

                                            <textarea
                                                name="description"
                                                rows="2"
                                                placeholder="Bagage inclus, départ CDG..."
                                                class="mt-1 w-full border-2
                                                    border-zinc-300 bg-white
                                                    px-3 py-2 text-sm
                                                    text-zinc-950
                                                    focus:border-red-600
                                                    focus:ring-red-600
                                                    dark:border-zinc-700
                                                    dark:bg-zinc-950
                                                    dark:text-white"
                                                ></textarea>
                                                </div>

                                                <div class="flex justify-end">
                                                <button
                                                type="submit"
                                                class="bg-zinc-950 px-4 py-2
                                                    text-[10px] font-black
                                                    uppercase tracking-wider
                                                    text-white transition
                                                    hover:bg-red-600
                                                    dark:bg-zinc-100
                                                    dark:text-zinc-950
                                                    dark:hover:bg-red-600
                                                    dark:hover:text-white"
                                            >
                                                Ajouter l'élément →
                                            </button>
                                    </div>
                                </form>
                            </div>

                            {{-- =================================
                            ÉLÉMENTS
                            ================================== --}}

                            <div
                                class="divide-y divide-zinc-200
                                    dark:divide-zinc-700"
                            >

                                @forelse ($categorie->elements as $element)

                                    <div class="p-4">

                                        <div
                                            class="flex flex-col gap-3
                                                sm:flex-row
                                                sm:items-center
                                                sm:justify-between"
                                        >

                                            {{-- GAUCHE --}}
                                            <div
                                                class="flex min-w-0
                                                    items-start gap-3"
                                            >

                                                {{-- SÉLECTION --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route(
                                                    'projets.elements.toggle',
                                                    [
                                                    $projet,
                                                    $possibilite,
                                                    $categorie,
                                                    $element
                                                    ]
                                                    ) }}"
                                                    class="shrink-0"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        title="{{ $element->selectionne
                                                        ? 'Désélectionner'
                                                        : 'Sélectionner' }}"
                                                        class="{{ $element->selectionne
                                                            ? 'border-red-600 bg-red-600 text-white'
                                                            : 'border-zinc-300 bg-white text-zinc-400 dark:border-zinc-600 dark:bg-zinc-950' }}
                                                            flex h-8 w-8
                                                            items-center justify-center
                                                            border-2 text-sm font-black
                                                            transition
                                                            hover:border-red-600
                                                            hover:text-red-600"
                                                    >
                                                        {{ $element->selectionne ? '✓' : '○' }}
                                                    </button>
                                                </form>

                                                {{-- INFOS --}}
                                                <div class="min-w-0">
                                                    <p
                                                        class="break-words text-sm font-black
                                                            {{ $element->selectionne
                                                            ? 'text-red-600'
                                                            : 'text-zinc-950 dark:text-white' }}"
                                                    >
                                                        {{ $element->nom }}
                                                    </p>

                                                    @if ($element->description)
                                                        <p
                                                            class="mt-1 text-xs leading-5
                                                                text-zinc-500
                                                                dark:text-zinc-400"
                                                        >
                                                            {{ $element->description }}
                                                        </p>
                                                    @endif

                                                    <div
                                                        class="mt-2 flex flex-wrap
                                                            items-center gap-3"
                                                    >
                                                        @if ($element->quantite > 1)
                                                            <span
                                                                class="text-[9px] font-black
                                                                    uppercase tracking-wider
                                                                    text-zinc-400"
                                                            >
                                                                Qté × {{ $element->quantite }}
                                                            </span>
                                                        @endif

                                                        @if ($element->url)
                                                            <a
                                                                href="{{ $element->url }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                class="text-[9px] font-black
                                                                    uppercase tracking-wider
                                                                    text-zinc-400
                                                                    transition
                                                                    hover:text-red-600"
                                                            >
                                                                Ouvrir ↗
                                                            </a>
                                                        @endif

                                                        @if ($element->selectionne)
                                                            <span
                                                                class="text-[9px] font-black
                                                                    uppercase tracking-wider
                                                                    text-red-600"
                                                            >
                                                                Inclus au budget
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- DROITE --}}
                                            <div
                                                class="flex shrink-0
                                                    items-center justify-between
                                                    gap-4 sm:justify-end"
                                            >
                                                <div class="text-right">
                                                    <p
                                                        class="text-sm font-black
                                                            text-zinc-950
                                                            dark:text-white"
                                                    >
                                                        {{ number_format(
                                                        (float) $element->prix
                                                        * $element->quantite,
                                                        2,
                                                        ',',
                                                        ' '
                                                        ) }} €
                                                    </p>

                                                    @if ($element->quantite > 1)
                                                        <p
                                                            class="text-[9px]
                                                                text-zinc-400"
                                                        >
                                                            {{ number_format(
                                                            (float) $element->prix,
                                                            2,
                                                            ',',
                                                            ' '
                                                            ) }} € / unité
                                                        </p>
                                                    @endif
                                                </div>

                                                <form
                                                    method="POST"
                                                    action="{{ route(
                                                    'projets.elements.destroy',
                                                    [
                                                    $projet,
                                                    $possibilite,
                                                    $categorie,
                                                    $element
                                                    ]
                                                    ) }}"
                                                    onsubmit="return confirm(
                                                    'Supprimer cet élément ?'
                                                    )"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        title="Supprimer"
                                                        class="text-lg font-black
                                                            text-zinc-300
                                                            transition
                                                            hover:text-red-600
                                                            dark:text-zinc-600"
                                                    >
                                                        ×
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                @empty

                                    <div class="px-4 py-6 text-center">
                                        <p
                                            class="text-xs font-bold
                                                text-zinc-400"
                                        >
                                            Aucun élément.
                                        </p>

                                        <button
                                            type="button"
                                            onclick="
                                            document
                                            .getElementById('element-form-{{ $categorie->id }}')
                                            .classList.remove('hidden')
                                            "
                                            class="mt-2 text-[10px]
                                                font-black uppercase
                                                tracking-wider text-red-600"
                                        >
                                            ＋ Ajouter le premier
                                        </button>
                                    </div>

                                @endforelse

                            </div>
                        </section>

                    @empty

                        <div
                            class="border border-dashed border-zinc-300
                                px-4 py-8 text-center
                                dark:border-zinc-700"
                        >
                            <p class="text-xs font-bold text-zinc-400">
                                Aucune catégorie.
                            </p>

                            <button
                                type="button"
                                onclick="
                                document
                                .getElementById('categorie-form-{{ $possibilite->id }}')
                                .classList.remove('hidden')
                                "
                                class="mt-2 text-[10px] font-black uppercase
                                    tracking-wider text-red-600"
                            >
                                ＋ Ajouter la première catégorie
                            </button>
                        </div>

                    @endforelse

                </div>

                {{-- =====================================
                GESTION POSSIBILITÉ
                ====================================== --}}

                <div
                    class="border-t-2 border-zinc-950 p-5
                        dark:border-zinc-700"
                >
                    <div
                        class="flex flex-col gap-3
                            sm:flex-row sm:items-center
                            sm:justify-between"
                    >
                        <a
                            href="{{ route(
                            'projets.possibilites.edit',
                            [$projet, $possibilite]
                            ) }}"
                            class="border-2 border-zinc-950
                                px-4 py-2 text-center
                                text-xs font-black uppercase
                                tracking-wider text-zinc-950
                                transition
                                hover:bg-zinc-950 hover:text-white
                                dark:border-zinc-100
                                dark:text-white
                                dark:hover:bg-zinc-100
                                dark:hover:text-zinc-950"
                        >
                            ✎ Modifier
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                            'projets.possibilites.destroy',
                            [$projet, $possibilite]
                            ) }}"
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
    <div
        class="flex flex-col gap-4
            sm:flex-row sm:items-center sm:justify-between"
    >
        <div>
            <p
                class="text-[9px] font-black uppercase
                    tracking-[0.2em] text-zinc-400"
            >
                Zone danger
            </p>

            <p class="mt-1 text-xs text-zinc-400">
                Supprimer le projet efface aussi ses possibilités,
                catégories et éléments.
            </p>
        </div>

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
</div>
</x-app-layout>
