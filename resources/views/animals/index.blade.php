@extends('layout')

@section('content')
    <h1 class="text-4xl pb-3 px-10 font-semibold">Archivált állatok</h1>

    <div class="h-8 px-10 pb-10">
        @if (session('error'))
            <span class="text-red-500 text-xl">Hiba: {{ session('error') }}</span>
        @elseif(!empty(Session::all()))
            <span class="text-green-500 text-xl">
                {{ Session::has('animal-restored') ? 'Állat sikeresen visszaállítva!' : '' }}
            </span>
        @endif
    </div>

    <div class="px-10 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($animals as $animal)
            <div class="card w-full bg-base-100 shadow-md relative h-100">
                <figure>
                    @if($animal->image)
                        <img src="{{ Storage::url($animal->image) }}">
                    @else
                        <img src="https://placehold.co/800x800?text=Nincs_kép">
                    @endif
           
                </figure>
                <div class="card-body">
                    <h2 class="card-title text-2xl">{{ $animal->name }}</h2>

                    <div class="mt-2">
                        <p class="text-sm opacity-70 mb-1">Faj: {{ $animal->species }}</p>
                        <p class="text-sm opacity-70 mb-1">Archiválva lett: {{ $animal->deleted_at->format('Y. m. d.') }}</p>
                    </div>

                    <div class="card-actions justify-end">
                            <a title="Visszaállítás" href="{{ route('animals.restore.form', ['animal' => $animal]) }}"
                                class="btn btn-sm btn-neutral btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-archive-restore-icon lucide-archive-restore"><rect width="20" height="5" x="2" y="3" rx="1"/><path d="M4 8v11a2 2 0 0 0 2 2h2"/><path d="M20 8v11a2 2 0 0 1-2 2h-2"/><path d="m9 15 3-3 3 3"/><path d="M12 12v9"/></svg>
                            </a>
                    </div>
                </div>
            </div>
        @empty
            <div>
                Nincs egy állat sem archiválva!
            </div>
        @endforelse
    </div>
@endsection
