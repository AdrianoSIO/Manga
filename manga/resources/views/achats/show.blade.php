<x-app-layout>
    <x-slot name="title">{{ $manga->titre }}</x-slot>

    <div class="min-h-screen bg-[#f7f3eb] text-zinc-900 dark:bg-[#111113] dark:text-zinc-100">
        <div class="mx-auto max-w-5xl px-4 py-8">

            <a
                href="{{ route('achats.index') }}"
                class="text-sm font-bold text-zinc-500 hover:text-red-600"
            >
                ← Liste d'achats
            </a>

            <div class="my-8">
                <span class="bg-red-600 px-2 py-1 text-xs font-black text-white">
                    購入リスト
                </span>

                <h1 class="mt-3 text-3xl font-black sm:text-4xl">
                    {{ $manga->titre }}
                </h1>

                <a
                    href="{{ route('achats.create', ['manga' => $manga->id]) }}"
                    class="mt-4 inline-flex border-2 border-zinc-900 bg-red-600 px-4 py-2 text-xs font-black uppercase text-white dark:border-zinc-600"
                >
                    + Ajouter un tome
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 border-2 border-zinc-900 bg-white p-4 font-bold dark:border-zinc-600 dark:bg-[#18181b]">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @foreach ($tomes as $tome)
                    <section class="border-2 border-zinc-900 bg-[#fffdf8] shadow-[5px_5px_0_#18181b] dark:border-zinc-600 dark:bg-[#18181b] dark:shadow-[5px_5px_0_#52525b]">

                        <div class="flex items-center justify-between border-b-2 border-zinc-900 p-5 dark:border-zinc-600">
                            <div>
                                <p class="text-xs font-black uppercase text-zinc-400">
                                    Tome recherché
                                </p>

                                <h2 class="text-2xl font-black">
                                    Tome {{ $tome->numero }}
                                </h2>
                            </div>

                            <div class="flex gap-2">
                                <form
                                    method="POST"
                                    action="{{ route('achats.acheter', $tome) }}"
                                    onsubmit="return confirm('Ajouter ce tome à ta collection ?')"
                                >
                                    @csrf

                                    <button class="bg-red-600 px-4 py-2 text-xs font-black uppercase text-white">
                                        ✓ Acheté
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('achats.destroy', $tome) }}"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Retirer ce tome ?')"
                                        class="border-2 border-zinc-900 px-3 py-2 text-xs font-black dark:border-zinc-600"
                                    >
                                        ×
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="mb-3 text-xs font-black uppercase tracking-widest text-zinc-500">
                                Offres
                            </h3>

                            @forelse ($tome->offres->sortBy('prix') as $offre)
                                <div class="mb-2 flex flex-col gap-3 border-2 border-zinc-200 p-3 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700">

                                    <div>
                                        <p class="font-black">
                                            {{ $offre->boutique }}
                                        </p>

                                        <p class="text-sm">
                                            @if ($offre->prix !== null)
                                                <span class="font-black text-red-600">
                                                    {{ number_format((float) $offre->prix, 2, ',', ' ') }} €
                                                </span>
                                            @else
                                                Prix inconnu
                                            @endif

                                            ·

                                            @if ($offre->disponible)
                                                <span class="font-bold text-green-600">
                                                    Disponible
                                                </span>
                                            @else
                                                <span class="font-bold text-zinc-400">
                                                    Rupture
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="flex gap-2">
                                        <a
                                            href="{{ $offre->url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="bg-zinc-900 px-4 py-2 text-xs font-black uppercase text-white dark:bg-white dark:text-zinc-900"
                                        >
                                            Boutique ↗
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('achats.offres.destroy', $offre) }}"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Supprimer cette offre ?')"
                                                class="border-2 border-red-600 px-3 py-2 text-xs font-black text-red-600"
                                            >
                                                ×
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="mb-5 text-sm text-zinc-500">
                                    Aucune boutique ajoutée pour ce tome.
                                </p>
                            @endforelse

                            <form
                                method="POST"
                                action="{{ route('achats.offres.store', $tome) }}"
                                class="mt-5 grid gap-3 border-t border-zinc-200 pt-5 dark:border-zinc-700 sm:grid-cols-2"
                            >
                                @csrf

                                <input
                                    name="boutique"
                                    required
                                    placeholder="Boutique"
                                    class="border-2 border-zinc-900 bg-white dark:border-zinc-600 dark:bg-zinc-900"
                                >

                                <input
                                    name="prix"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    placeholder="Prix"
                                    class="border-2 border-zinc-900 bg-white dark:border-zinc-600 dark:bg-zinc-900"
                                >

                                <input
                                    name="url"
                                    type="url"
                                    required
                                    placeholder="https://..."
                                    class="border-2 border-zinc-900 bg-white dark:border-zinc-600 dark:bg-zinc-900 sm:col-span-2"
                                >

                                <label class="flex items-center gap-2 font-bold">
                                    <input
                                        type="checkbox"
                                        name="disponible"
                                        value="1"
                                        checked
                                        class="text-red-600"
                                    >
                                    Disponible
                                </label>

                                <button
                                    class="border-2 border-zinc-900 bg-white px-4 py-2 text-xs font-black uppercase dark:border-zinc-600 dark:bg-zinc-900"
                                >
                                    + Ajouter l'offre
                                </button>
                            </form>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>