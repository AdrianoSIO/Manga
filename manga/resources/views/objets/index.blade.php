<x-app-layout>

    <x-slot name="title">

        Wishlist

    </x-slot>



    <div

        class="min-h-screen bg-[#f7f3eb] text-zinc-900 dark:text-zinc-100 transition-colors dark:bg-[#111113] dark:text-zinc-100"

        style="

            background-image:

                linear-gradient(rgba(24,24,27,.035) 1px, transparent 1px),

                linear-gradient(90deg, rgba(24,24,27,.035) 1px, transparent 1px);

            background-size: 28px 28px;

        "

    >

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">



            {{-- HEADER --}}

            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">



                <div>

                    <div class="mb-2 flex items-center gap-3">

                        <span class="bg-red-600 px-2 py-1 text-xs font-black uppercase tracking-[0.2em] text-white">

                            欲しい物

                        </span>



                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">

                            Wishlist

                        </span>

                    </div>



                    <h1 class="text-3xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">

                        Objets recherchés

                    </h1>



                    <p class="mt-2 max-w-2xl text-sm text-zinc-600 dark:text-zinc-400 dark:text-zinc-500">

                        Figurines, résines, collectors et autres objets que tu veux suivre.

                    </p>

                </div>



                <a

                    href="{{ route('objets.create') }}"

                    class="inline-flex items-center justify-center border-2 border-zinc-900 dark:border-zinc-600 bg-red-600 px-5 py-3 text-sm font-black uppercase tracking-wider text-white shadow-[4px_4px_0_#18181b] dark:shadow-[4px_4px_0_#52525b] transition hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0_#18181b] dark:shadow-[6px_6px_0_#52525b]"

                >

                    + Ajouter un objet

                </a>

            </div>





            {{-- MESSAGE SUCCESS --}}

            @if (session('success'))

                <div class="mb-6 border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 font-bold text-zinc-900 dark:text-zinc-100 shadow-[3px_3px_0_#18181b] dark:shadow-[3px_3px_0_#52525b]">

                    {{ session('success') }}

                </div>

            @endif





            {{-- STATS --}}

            @php

                $total = $objets->count();

                $disponibles = $objets->where('disponible', true)

                    ->where('achete', false)

                    ->count();



                $achetes = $objets->where('achete', true)->count();



                $prioritaires = $objets

                    ->whereIn('importance', ['SSS', 'SS', 'S'])

                    ->where('achete', false)

                    ->count();

            @endphp



            <div class="mb-8 grid grid-cols-2 gap-3 lg:grid-cols-4">



                <div class="border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] p-4">

                    <p class="text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">

                        Objets

                    </p>

                    <p class="mt-1 text-2xl font-black">

                        {{ $total }}

                    </p>

                </div>



                <div class="border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] p-4">

                    <p class="text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">

                        Disponibles

                    </p>

                    <p class="mt-1 text-2xl font-black">

                        {{ $disponibles }}

                    </p>

                </div>



                <div class="border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] p-4">

                    <p class="text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">

                        Priorité S+

                    </p>

                    <p class="mt-1 text-2xl font-black">

                        {{ $prioritaires }}

                    </p>

                </div>



                <div class="border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] p-4">

                    <p class="text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">

                        Achetés

                    </p>

                    <p class="mt-1 text-2xl font-black">

                        {{ $achetes }}

                    </p>

                </div>



            </div>





            {{-- FILTRES --}}

            @if ($objets->isNotEmpty())

                <div class="mb-7 border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] p-4">



                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">



                        {{-- Recherche --}}

                        <div class="w-full lg:max-w-sm">

                            <input

                                id="wishlist-search"

                                type="search"

                                placeholder="Rechercher un objet..."

                                class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100 focus:border-red-600 focus:ring-red-600"

                            >

                        </div>



                        {{-- Rangs --}}

                        <div class="flex gap-2 overflow-x-auto pb-1 lg:pb-0">



                            <button

                                type="button"

                                data-rank="all"

                                class="rank-filter shrink-0 border-2 border-zinc-900 dark:border-zinc-600 bg-zinc-900 px-3 py-2 text-xs font-black text-white"

                            >

                                TOUS

                            </button>



                            @foreach (['SSS', 'SS', 'S', 'A', 'B', 'C', 'D'] as $rank)

                                <button

                                    type="button"

                                    data-rank="{{ $rank }}"

                                    class="rank-filter shrink-0 border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 text-xs font-black text-zinc-900 dark:text-zinc-100 hover:bg-zinc-100 dark:bg-zinc-800"

                                >

                                    {{ $rank }}

                                </button>

                            @endforeach



                        </div>



                    </div>



                    {{-- États --}}

                    <div class="mt-4 flex flex-wrap gap-2">



                        <button

                            type="button"

                            data-status="all"

                            class="status-filter border-2 border-zinc-900 dark:border-zinc-600 bg-zinc-900 px-3 py-2 text-xs font-bold uppercase text-white"

                        >

                            Tous

                        </button>



                        <button

                            type="button"

                            data-status="available"

                            class="status-filter border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 text-xs font-bold uppercase"

                        >

                            Disponible

                        </button>



                        <button

                            type="button"

                            data-status="unavailable"

                            class="status-filter border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 text-xs font-bold uppercase"

                        >

                            Indisponible

                        </button>



                        <button

                            type="button"

                            data-status="bought"

                            class="status-filter border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-3 py-2 text-xs font-bold uppercase"

                        >

                            Acheté

                        </button>



                    </div>

                </div>

            @endif





            {{-- LISTE --}}

            @if ($objets->isEmpty())



                <div class="border-2 border-dashed border-zinc-400 dark:border-zinc-700 bg-[#fffdf8] dark:bg-[#18181b] px-6 py-16 text-center">



                    <div class="text-6xl font-black text-zinc-200">

                        欲

                    </div>



                    <h2 class="mt-4 text-xl font-black text-zinc-900 dark:text-zinc-100">

                        Ta wishlist est vide

                    </h2>



                    <p class="mx-auto mt-2 max-w-md text-sm text-zinc-600 dark:text-zinc-400 dark:text-zinc-500">

                        Ajoute une résine, une figurine, un collector ou n'importe quel objet que tu veux surveiller.

                    </p>



                    <a

                        href="{{ route('objets.create') }}"

                        class="mt-6 inline-flex border-2 border-zinc-900 dark:border-zinc-600 bg-red-600 px-5 py-3 text-sm font-black uppercase text-white shadow-[4px_4px_0_#18181b] dark:shadow-[4px_4px_0_#52525b]"

                    >

                        Ajouter mon premier objet

                    </a>



                </div>



            @else



                <div

                    id="wishlist-grid"

                    class="grid gap-5 md:grid-cols-2 xl:grid-cols-3"

                >



                    @foreach ($objets as $objet)



                        @php

                            $rankStyles = [

                                'SSS' => 'bg-red-600 text-white',

                                'SS'  => 'bg-red-500 text-white',

                                'S'   => 'bg-zinc-900 text-white',

                                'A'   => 'bg-zinc-800 text-white',

                                'B'   => 'bg-zinc-200 text-zinc-900 dark:text-zinc-100',

                                'C'   => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100',

                                'D'   => 'bg-white dark:bg-zinc-900 text-zinc-500 dark:text-zinc-400',

                            ];



                            $rankClass = $rankStyles[$objet->importance]

                                ?? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100';

                        @endphp



                        <article

                            class="wishlist-item flex flex-col border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] shadow-[5px_5px_0_#18181b] dark:shadow-[5px_5px_0_#52525b]"

                            data-rank="{{ $objet->importance }}"

                            data-status="{{ $objet->achete ? 'bought' : ($objet->disponible ? 'available' : 'unavailable') }}"

                            data-name="{{ strtolower($objet->nom . ' ' . ($objet->categorie ?? '')) }}"

                        >



                            {{-- Haut carte --}}

                            <div class="flex items-start justify-between border-b-2 border-zinc-900 dark:border-zinc-600">



                                <div class="p-4">



                                    @if ($objet->categorie)

                                        <p class="mb-1 text-[11px] font-black uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">

                                            {{ $objet->categorie }}

                                        </p>

                                    @endif



                                    <h2 class="text-xl font-black leading-tight text-zinc-900 dark:text-zinc-100">

                                        {{ $objet->nom }}

                                    </h2>



                                </div>



                                <div class="flex min-h-20 min-w-20 items-center justify-center border-l-2 border-zinc-900 dark:border-zinc-600 {{ $rankClass }}">

                                    <span class="text-2xl font-black">

                                        {{ $objet->importance }}

                                    </span>

                                </div>



                            </div>





                            {{-- Corps --}}

                            <div class="flex flex-1 flex-col p-4">



                                {{-- Prix --}}

                                <div class="mb-4 flex items-end justify-between gap-4">



                                    <div>

                                        <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">

                                            Prix actuel

                                        </p>



                                        <p class="text-2xl font-black text-zinc-900 dark:text-zinc-100">

                                            @if ($objet->prix !== null)

                                                {{ number_format((float) $objet->prix, 2, ',', ' ') }} €

                                            @else

                                                —

                                            @endif

                                        </p>

                                    </div>



                                    @if ($objet->prix_cible !== null)

                                        <div class="text-right">

                                            <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400 dark:text-zinc-500">

                                                Prix cible

                                            </p>



                                            <p class="font-black text-red-600">

                                                {{ number_format((float) $objet->prix_cible, 2, ',', ' ') }} €

                                            </p>

                                        </div>

                                    @endif



                                </div>





                                {{-- État --}}

                                <div class="mb-4">



                                    @if ($objet->achete)



                                        <span class="inline-flex border-2 border-zinc-900 dark:border-zinc-600 bg-zinc-900 px-2 py-1 text-xs font-black uppercase text-white">

                                            ✓ Acheté

                                        </span>



                                    @elseif ($objet->disponible)



                                        <span class="inline-flex border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-2 py-1 text-xs font-black uppercase text-zinc-900 dark:text-zinc-100">

                                            ● Disponible

                                        </span>



                                    @else



                                        <span class="inline-flex border-2 border-zinc-400 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 text-xs font-black uppercase text-zinc-500 dark:text-zinc-400">

                                            Indisponible

                                        </span>



                                    @endif



                                </div>





                                {{-- Description --}}

                                @if ($objet->description)

                                    <p class="mb-5 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400 dark:text-zinc-500">

                                        {{ $objet->description }}

                                    </p>

                                @endif





                                {{-- Date --}}

                                <div class="mt-auto border-t border-zinc-200 dark:border-zinc-800 pt-3 text-xs font-semibold text-zinc-400 dark:text-zinc-500">

                                    Ajouté le

                                    {{ $objet->date_ajout->format('d/m/Y') }}



                                    @if ($objet->achete && $objet->date_achat)

                                        · Acheté le

                                        {{ $objet->date_achat->format('d/m/Y') }}

                                    @endif

                                </div>



                            </div>





                            {{-- Actions --}}

                            <div class="grid grid-cols-2 border-t-2 border-zinc-900 dark:border-zinc-600">



                                @if ($objet->url)

                                    <a

                                        href="{{ $objet->url }}"

                                        target="_blank"

                                        rel="noopener noreferrer"

                                        class="flex items-center justify-center border-r-2 border-zinc-900 dark:border-zinc-600 px-3 py-3 text-xs font-black uppercase tracking-wide hover:bg-red-600 hover:text-white"

                                    >

                                        Voir le produit ↗

                                    </a>

                                @else

                                    <div class="border-r-2 border-zinc-900 dark:border-zinc-600"></div>

                                @endif



                                <a

                                    href="{{ route('objets.edit', $objet) }}"

                                    class="flex items-center justify-center px-3 py-3 text-xs font-black uppercase tracking-wide hover:bg-zinc-900 hover:text-white"

                                >

                                    Modifier

                                </a>



                            </div>



                        </article>



                    @endforeach



                </div>





                {{-- Aucun résultat --}}

                <div

                    id="wishlist-empty-search"

                    class="hidden border-2 border-dashed border-zinc-400 dark:border-zinc-700 bg-[#fffdf8] dark:bg-[#18181b] p-10 text-center"

                >

                    <p class="font-black text-zinc-900 dark:text-zinc-100">

                        Aucun objet trouvé.

                    </p>

                </div>



            @endif



        </div>

    </div>





    {{-- Recherche + filtres --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {



            const search = document.getElementById('wishlist-search');

            const items = document.querySelectorAll('.wishlist-item');

            const empty = document.getElementById('wishlist-empty-search');



            let selectedRank = 'all';

            let selectedStatus = 'all';





            function normalize(value) {

                return value

                    .toLowerCase()

                    .normalize('NFD')

                    .replace(/[\u0300-\u036f]/g, '');

            }





            function refresh() {



                const query = normalize(search?.value || '');

                let visible = 0;



                items.forEach(item => {



                    const name = normalize(item.dataset.name || '');

                    const rank = item.dataset.rank;

                    const status = item.dataset.status;



                    const matchesSearch =

                        !query || name.includes(query);



                    const matchesRank =

                        selectedRank === 'all'

                        || rank === selectedRank;



                    const matchesStatus =

                        selectedStatus === 'all'

                        || status === selectedStatus;



                    const show =

                        matchesSearch

                        && matchesRank

                        && matchesStatus;



                    item.classList.toggle('hidden', !show);



                    if (show) {

                        visible++;

                    }

                });



                if (empty) {

                    empty.classList.toggle('hidden', visible !== 0);

                }

            }





            search?.addEventListener('input', refresh);





            document.querySelectorAll('.rank-filter').forEach(button => {



                button.addEventListener('click', function () {



                    selectedRank = this.dataset.rank;



                    document

                        .querySelectorAll('.rank-filter')

                        .forEach(btn => {

                            btn.classList.remove(

                                'bg-zinc-900',

                                'text-white'

                            );



                            btn.classList.add(

                                'bg-white dark:bg-zinc-900',

                                'text-zinc-900 dark:text-zinc-100'

                            );

                        });



                    this.classList.remove(

                        'bg-white dark:bg-zinc-900',

                        'text-zinc-900 dark:text-zinc-100'

                    );



                    this.classList.add(

                        'bg-zinc-900',

                        'text-white'

                    );



                    refresh();

                });



            });





            document.querySelectorAll('.status-filter').forEach(button => {



                button.addEventListener('click', function () {



                    selectedStatus = this.dataset.status;



                    document

                        .querySelectorAll('.status-filter')

                        .forEach(btn => {

                            btn.classList.remove(

                                'bg-zinc-900',

                                'text-white'

                            );



                            btn.classList.add('bg-white');

                        });



                    this.classList.remove('bg-white');



                    this.classList.add(

                        'bg-zinc-900',

                        'text-white'

                    );



                    refresh();

                });



            });



        });

    </script>



</x-app-layout>