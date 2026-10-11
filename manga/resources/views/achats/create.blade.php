<x-app-layout>
    <x-slot name="title">Ajouter un manga recherché</x-slot>

    <div class="min-h-screen bg-[#f7f3eb] dark:bg-[#111113]">
        <div class="mx-auto max-w-2xl px-4 py-8">

            <a
                href="{{ route('achats.index') }}"
                class="text-sm font-bold text-zinc-500 hover:text-red-600"
            >
                ← Retour aux achats
            </a>

            <div class="mt-6 mb-8">
                <span class="bg-red-600 px-2 py-1 text-xs font-black text-white">
                    購入
                </span>

                <h1 class="mt-3 text-3xl font-black text-zinc-900 dark:text-zinc-100">
                    Ajouter un tome recherché
                </h1>
            </div>

            @if ($errors->any())
                <div class="mb-5 border-2 border-red-600 bg-red-50 p-4 text-red-700 dark:bg-red-950/30 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('achats.store') }}"
                class="border-2 border-zinc-900 bg-[#fffdf8] p-6 shadow-[6px_6px_0_#18181b] dark:border-zinc-600 dark:bg-[#18181b] dark:shadow-[6px_6px_0_#52525b]"
            >
                @csrf

                <label class="mb-2 block text-xs font-black uppercase text-zinc-700 dark:text-zinc-300">
                    Licence
                </label>

                <select
                    name="manga_id"
                    required
                    class="mb-6 w-full border-2 border-zinc-900 bg-white px-4 py-3 dark:border-zinc-600 dark:bg-zinc-900 dark:text-white"
                >
                    <option value="">Choisir une licence</option>

                    @foreach ($mangas as $manga)
                        <option
                            value="{{ $manga->id }}"
                            @selected(old('manga_id', request('manga')) == $manga->id)
                        >
                            {{ $manga->titre }}
                        </option>
                    @endforeach
                </select>

                <label class="mb-2 block text-xs font-black uppercase text-zinc-700 dark:text-zinc-300">
                    Numéro du tome
                </label>

                <input
                    type="number"
                    name="numero"
                    min="1"
                    required
                    value="{{ old('numero') }}"
                    class="w-full border-2 border-zinc-900 bg-white px-4 py-3 dark:border-zinc-600 dark:bg-zinc-900 dark:text-white"
                >

                <button
                    class="mt-6 w-full border-2 border-zinc-900 bg-red-600 px-5 py-3 font-black uppercase text-white dark:border-zinc-600"
                >
                    Ajouter à la liste
                </button>
            </form>
        </div>
    </div>
</x-app-layout>