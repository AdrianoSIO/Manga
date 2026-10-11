<x-app-layout>

    <x-slot name="title">

        Ajouter un objet

    </x-slot>



    <div

        class="wishlist-create-page min-h-screen bg-[#f7f3eb] text-zinc-900 dark:text-zinc-100 transition-colors dark:bg-[#111113] dark:text-zinc-100"

        style="

            background-image:

                linear-gradient(rgba(24,24,27,.035) 1px, transparent 1px),

                linear-gradient(90deg, rgba(24,24,27,.035) 1px, transparent 1px);

            background-size: 28px 28px;

        "

    >

        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">



            {{-- RETOUR --}}

            <a

                href="{{ route('objets.index') }}"

                class="mb-6 inline-flex items-center gap-2 text-sm font-bold text-zinc-500 dark:text-zinc-400 dark:text-zinc-500 transition hover:text-red-600"

            >

                ← Retour à la wishlist

            </a>





            {{-- HEADER --}}

            <div class="mb-8">



                <div class="mb-3 flex items-center gap-3">

                    <span class="bg-red-600 px-2 py-1 text-xs font-black uppercase tracking-[0.2em] text-white">

                        欲しい物

                    </span>



                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                        Nouvel objet

                    </span>

                </div>



                <h1 class="text-3xl font-black tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-4xl">

                    Ajouter un objet

                </h1>



                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400 dark:text-zinc-500">

                    Ajoute un objet à suivre dans ta wishlist.

                </p>



            </div>





            {{-- ERREURS --}}

            @if ($errors->any())

                <div class="mb-6 border-2 border-red-600 bg-red-50 p-4 dark:bg-red-950/30 shadow-[4px_4px_0_#18181b] dark:shadow-[4px_4px_0_#52525b]">



                    <p class="mb-2 font-black text-red-700 dark:text-red-300">

                        Vérifie les informations :

                    </p>



                    <ul class="list-inside list-disc space-y-1 text-sm font-medium text-red-700 dark:text-red-300">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>



                </div>

            @endif





            {{-- FORMULAIRE --}}

            <form

                method="POST"

                action="{{ route('objets.store') }}"

                class="border-2 border-zinc-900 dark:border-zinc-600 bg-[#fffdf8] dark:bg-[#18181b] shadow-[6px_6px_0_#18181b] dark:shadow-[6px_6px_0_#52525b]"

            >

                @csrf





                {{-- 01 IDENTITÉ --}}

                <section class="border-b-2 border-zinc-900 dark:border-zinc-600 p-5 sm:p-7">



                    <div class="mb-5 flex items-center gap-3">



                        <span class="flex h-8 w-8 items-center justify-center bg-zinc-900 text-xs font-black text-white">

                            01

                        </span>



                        <div>

                            <h2 class="font-black text-zinc-900 dark:text-zinc-100">

                                Objet

                            </h2>



                            <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                基本情報 · Informations principales

                            </p>

                        </div>



                    </div>





                    <div class="grid gap-5 sm:grid-cols-2">



                        {{-- NOM --}}

                        <div class="sm:col-span-2">



                            <label

                                for="nom"

                                class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"

                            >

                                Nom de l'objet *

                            </label>



                            <input

                                id="nom"

                                name="nom"

                                type="text"

                                value="{{ old('nom') }}"

                                required

                                autofocus

                                placeholder="Ex : Résine Goku SSJ3"

                                class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 text-sm font-semibold text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:text-zinc-500 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500"

                            >



                        </div>





                        {{-- CATÉGORIE --}}

                        <div>



                            <label

                                for="categorie"

                                class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"

                            >

                                Catégorie

                            </label>



                            <input

                                id="categorie"

                                name="categorie"

                                type="text"

                                value="{{ old('categorie') }}"

                                placeholder="Résine, Figurine, Collector..."

                                class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 text-sm font-semibold text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:text-zinc-500 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500"

                            >



                        </div>





                        {{-- URL --}}

                        <div>



                            <label

                                for="url"

                                class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"

                            >

                                Lien du produit

                            </label>



                            <input

                                id="url"

                                name="url"

                                type="url"

                                value="{{ old('url') }}"

                                placeholder="https://..."

                                class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 text-sm font-semibold text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:text-zinc-500 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500"

                            >



                        </div>



                    </div>



                </section>





                {{-- 02 PRIX --}}

                <section class="border-b-2 border-zinc-900 dark:border-zinc-600 p-5 sm:p-7">



                    <div class="mb-5 flex items-center gap-3">



                        <span class="flex h-8 w-8 items-center justify-center bg-zinc-900 text-xs font-black text-white">

                            02

                        </span>



                        <div>

                            <h2 class="font-black text-zinc-900 dark:text-zinc-100">

                                Prix

                            </h2>



                            <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                価格 · Suivi du prix

                            </p>

                        </div>



                    </div>





                    <div class="grid gap-5 sm:grid-cols-2">



                        {{-- PRIX ACTUEL --}}

                        <div>



                            <label

                                for="prix"

                                class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"

                            >

                                Prix actuel

                            </label>



                            <div class="relative">



                                <input

                                    id="prix"

                                    name="prix"

                                    type="number"

                                    step="0.01"

                                    min="0"

                                    value="{{ old('prix') }}"

                                    placeholder="349.90"

                                    class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 pr-12 text-sm font-black text-zinc-900 dark:text-zinc-100 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500"

                                >



                                <span class="absolute right-4 top-1/2 -translate-y-1/2 font-black text-zinc-400 dark:text-zinc-500">

                                    €

                                </span>



                            </div>



                        </div>





                        {{-- PRIX CIBLE --}}

                        <div>



                            <label

                                for="prix_cible"

                                class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"

                            >

                                Prix cible

                            </label>



                            <div class="relative">



                                <input

                                    id="prix_cible"

                                    name="prix_cible"

                                    type="number"

                                    step="0.01"

                                    min="0"

                                    value="{{ old('prix_cible') }}"

                                    placeholder="280.00"

                                    class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 pr-12 text-sm font-black text-zinc-900 dark:text-zinc-100 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500"

                                >



                                <span class="absolute right-4 top-1/2 -translate-y-1/2 font-black text-red-600">

                                    €

                                </span>



                            </div>



                            <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                Le prix auquel tu aimerais acheter l'objet.

                            </p>



                        </div>



                    </div>



                </section>





                {{-- 03 IMPORTANCE --}}

                <section class="border-b-2 border-zinc-900 dark:border-zinc-600 p-5 sm:p-7">



                    <div class="mb-5 flex items-center gap-3">



                        <span class="flex h-8 w-8 items-center justify-center bg-zinc-900 text-xs font-black text-white">

                            03

                        </span>



                        <div>

                            <h2 class="font-black text-zinc-900 dark:text-zinc-100">

                                Priorité

                            </h2>



                            <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                優先度 · Niveau d'importance

                            </p>

                        </div>



                    </div>





                    <div class="grid grid-cols-4 gap-2 sm:grid-cols-7">



                        @foreach (['SSS', 'SS', 'S', 'A', 'B', 'C', 'D'] as $rank)



                            <label class="cursor-pointer">



                                <input

                                    type="radio"

                                    name="importance"

                                    value="{{ $rank }}"

                                    class="peer sr-only"

                                    {{ old(*'importance',* *'C')* *===* $rank ? *'checked'* : *''* }}

                                >



                                <div class="flex h-14 items-center justify-center border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-lg font-black text-zinc-900 dark:text-zinc-100 transition hover:bg-zinc-100 dark:hover:bg-zinc-800 dark:bg-zinc-800 peer-checked:bg-red-600 peer-checked:text-white dark:peer-checked:bg-red-600 dark:peer-checked:text-white">

                                    {{ $rank }}

                                </div>



                            </label>



                        @endforeach



                    </div>





                    <div class="mt-3 flex justify-between text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">



                        <span>

                            Priorité maximale

                        </span>



                        <span>

                            Faible priorité

                        </span>



                    </div>



                </section>





                {{-- 04 ÉTAT --}}

                <section class="border-b-2 border-zinc-900 dark:border-zinc-600 p-5 sm:p-7">



                    <div class="mb-5 flex items-center gap-3">



                        <span class="flex h-8 w-8 items-center justify-center bg-zinc-900 text-xs font-black text-white">

                            04

                        </span>



                        <div>

                            <h2 class="font-black text-zinc-900 dark:text-zinc-100">

                                État

                            </h2>



                            <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                状態 · Disponibilité

                            </p>

                        </div>



                    </div>





                    <div class="grid gap-3 sm:grid-cols-2">



                        {{-- DISPONIBLE --}}

                        <label class="flex cursor-pointer items-center gap-3 border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 p-4">



                            <input

                                type="checkbox"

                                name="disponible"

                                value="1"

                                {{ old(*'disponible',* *'1')* ? *'checked'* : *''* }}

                                class="h-5 w-5 border-2 border-zinc-900 dark:border-zinc-600 text-red-600 focus:ring-red-600"

                            >



                            <div>

                                <p class="font-black text-zinc-900 dark:text-zinc-100">

                                    Disponible

                                </p>



                                <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                    L'objet est actuellement en vente.

                                </p>

                            </div>



                        </label>





                        {{-- ACHETÉ --}}

                        <label class="flex cursor-pointer items-center gap-3 border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 p-4">



                            <input

                                id="achete"

                                type="checkbox"

                                name="achete"

                                value="1"

                                {{ old(*'achete')* ? *'checked'* : *''* }}

                                class="h-5 w-5 border-2 border-zinc-900 dark:border-zinc-600 text-red-600 focus:ring-red-600"

                            >



                            <div>

                                <p class="font-black text-zinc-900 dark:text-zinc-100">

                                    Déjà acheté

                                </p>



                                <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                    Marquer l'objet comme acquis.

                                </p>

                            </div>



                        </label>



                    </div>





                    {{-- DATE ACHAT --}}

                    <div

                        id="date-achat-container"

                        class="{{ old('achete') ? '' : 'hidden' }} mt-5"

                    >



                        <label

                            for="date_achat"

                            class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300"

                        >

                            Date d'achat

                        </label>



                        <input

                            id="date_achat"

                            name="date_achat"

                            type="date"

                            value="{{ old('date_achat') }}"

                            class="w-full border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 text-sm font-semibold focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500 sm:max-w-xs"

                        >



                    </div>



                </section>





                {{-- 05 NOTES --}}

                <section class="p-5 sm:p-7">



                    <div class="mb-5 flex items-center gap-3">



                        <span class="flex h-8 w-8 items-center justify-center bg-zinc-900 text-xs font-black text-white">

                            05

                        </span>



                        <div>

                            <h2 class="font-black text-zinc-900 dark:text-zinc-100">

                                Notes

                            </h2>



                            <p class="text-xs text-zinc-500 dark:text-zinc-400 dark:text-zinc-500">

                                メモ · Informations supplémentaires

                            </p>

                        </div>



                    </div>





                    <textarea

                        id="description"

                        name="description"

                        rows="5"

                        placeholder="Édition limitée, surveiller le stock, vendeur préféré..."

                        class="w-full resize-y border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:text-zinc-500 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-500 dark:focus:ring-red-500"

                    >{{ old('description') }}</textarea>



                </section>





                {{-- ACTIONS --}}

                <div class="flex flex-col-reverse gap-3 border-t-2 border-zinc-900 dark:border-zinc-600 bg-[#f7f3eb] p-5 sm:flex-row sm:justify-end">



                    <a

                        href="{{ route('objets.index') }}"

                        class="inline-flex items-center justify-center border-2 border-zinc-900 dark:border-zinc-600 bg-white dark:bg-zinc-900 px-5 py-3 text-sm font-black uppercase tracking-wide text-zinc-900 dark:text-zinc-100 transition hover:bg-zinc-100 dark:hover:bg-zinc-800 dark:bg-zinc-800"

                    >

                        Annuler

                    </a>



                    <button

                        type="submit"

                        class="inline-flex items-center justify-center border-2 border-zinc-900 dark:border-zinc-600 bg-red-600 px-6 py-3 text-sm font-black uppercase tracking-wide text-white shadow-[4px_4px_0_#18181b] dark:shadow-[4px_4px_0_#52525b] transition hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[6px_6px_0_#18181b] dark:shadow-[6px_6px_0_#52525b]"

                    >

                        Ajouter à la wishlist

                    </button>



                </div>



            </form>



        </div>

    </div>





    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const achete = document.getElementById('achete');

            const dateContainer = document.getElementById('date-achat-container');



            achete?.addEventListener('change', function () {

                dateContainer.classList.toggle('hidden', !this.checked);

            });

        });

    </script>



</x-app-layout>