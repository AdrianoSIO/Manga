<x-app-layout>
<x-slot name="title">Ajouter un manga recherché</x-slot>

<div class="min-h-screen bg-[#f7f3eb] text-zinc-900 dark:bg-[#111113] dark:text-zinc-100">
<div class="mx-auto max-w-2xl px-4 py-8">

<a href="{{ route('achats.index') }}" class="text-sm font-bold text-zinc-500 transition hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-500">
← Retour aux achats
</a>

<div class="mb-8 mt-6">
<span class="bg-red-600 px-2 py-1 text-xs font-black text-white">購入</span>
<h1 class="mt-3 text-3xl font-black">Ajouter des tomes recherchés</h1>
<p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
Choisis une licence existante ou crée directement une nouvelle licence.
</p>
</div>

@if ($errors->any())
<div class="mb-5 border-2 border-red-600 bg-red-50 p-4 text-red-700 dark:bg-red-950/30 dark:text-red-300">
@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach
</div>
@endif

<form method="POST" action="{{ route('achats.store') }}" class="border-2 border-zinc-900 bg-[#fffdf8] p-6 shadow-[6px_6px_0_#18181b] dark:border-zinc-600 dark:bg-[#18181b] dark:shadow-[6px_6px_0_#52525b]">
@csrf

<div>
<label for="manga_id" class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
Licence existante
</label>

<select id="manga_id" name="manga_id" class="w-full border-2 border-zinc-900 bg-white px-4 py-3 text-zinc-900 focus:border-red-600 focus:ring-red-600 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100">
<option value="">Choisir une licence</option>
@foreach ($mangas as $manga)
<option value="{{ $manga->id }}" @selected(old('manga_id', request('manga')) == $manga->id)>
{{ $manga->titre }}
</option>
@endforeach
</select>
</div>

<div class="my-6 flex items-center gap-4">
<div class="h-px flex-1 bg-zinc-300 dark:bg-zinc-700"></div>
<span class="text-xs font-black uppercase text-zinc-400">OU</span>
<div class="h-px flex-1 bg-zinc-300 dark:bg-zinc-700"></div>
</div>

<div>
<label for="nouveau_titre" class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
Nouvelle licence
</label>

<input
id="nouveau_titre"
name="nouveau_titre"
type="text"
maxlength="255"
autocomplete="off"
value="{{ old('nouveau_titre') }}"
placeholder="Ex : Umamusume Pretty Derby"
class="w-full border-2 border-zinc-900 bg-white px-4 py-3 text-zinc-900 placeholder:text-zinc-400 focus:border-red-600 focus:ring-red-600 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder:text-zinc-500"
>
</div>

<div id="genres-section" class="mt-6 hidden">
<div class="mb-4">
<p class="text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
Genres
</p>
<p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
Sélectionne au moins un genre pour cette nouvelle licence.
</p>
</div>

<div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
@foreach ($genres as $genre)
<label class="cursor-pointer">
<input
type="checkbox"
name="genres[]"
value="{{ $genre->id }}"
class="peer sr-only"
@checked(in_array($genre->id, old('genres', [])))
>
<div class="flex min-h-12 items-center justify-center border-2 border-zinc-300 bg-white px-3 py-2 text-center text-xs font-bold text-zinc-600 transition hover:border-red-400 peer-checked:border-red-600 peer-checked:bg-red-600 peer-checked:text-white dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:peer-checked:border-red-600 dark:peer-checked:bg-red-600 dark:peer-checked:text-white">
{{ $genre->nom }}
</div>
</label>
@endforeach
</div>

@error('genres')
<p class="mt-3 text-sm font-bold text-red-600 dark:text-red-400">
{{ $message }}
</p>
@enderror
</div>

<div class="mt-8">
<label for="numeros" class="mb-2 block text-xs font-black uppercase tracking-wider text-zinc-700 dark:text-zinc-300">
Tomes recherchés
</label>

<input
id="numeros"
name="numeros"
type="text"
required
autocomplete="off"
value="{{ old('numeros') }}"
placeholder="Ex : 1-5 ou 1,2,5"
class="w-full border-2 border-zinc-900 bg-white px-4 py-3 text-zinc-900 placeholder:text-zinc-400 focus:border-red-600 focus:ring-red-600 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-100 dark:placeholder:text-zinc-500"
>

<p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
Formats acceptés : <strong>1</strong>, <strong>1,2,5</strong> ou <strong>1-5</strong>.
</p>
</div>

<div class="mt-8 border-t border-zinc-200 pt-6 dark:border-zinc-700">
<button type="submit" class="w-full border-2 border-zinc-900 bg-red-600 px-5 py-3 font-black uppercase text-white transition hover:bg-red-700 dark:border-zinc-600">
Ajouter à la liste
</button>
</div>

</form>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mangaSelect = document.getElementById('manga_id');
    const nouveauTitre = document.getElementById('nouveau_titre');
    const genresSection = document.getElementById('genres-section');

    function updateForm() {
        const nouvelleLicence = nouveauTitre.value.trim() !== '';

        genresSection.classList.toggle('hidden', !nouvelleLicence);

        if (nouvelleLicence) {
            mangaSelect.value = '';
            mangaSelect.disabled = true;
        } else {
            mangaSelect.disabled = false;
        }

        if (mangaSelect.value !== '') {
            nouveauTitre.value = '';
            genresSection.classList.add('hidden');
        }
    }

    nouveauTitre.addEventListener('input', updateForm);

    mangaSelect.addEventListener('change', () => {
        if (mangaSelect.value !== '') {
            nouveauTitre.value = '';
            genresSection.classList.add('hidden');
        }

        updateForm();
    });

    updateForm();
});
</script>

</x-app-layout>