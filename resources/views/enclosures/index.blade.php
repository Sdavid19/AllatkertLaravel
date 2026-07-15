@extends('layout')

@section('content')
    <h1 class="text-4xl pb-3 px-10 font-semibold">Kifutók</h1>

<div class="h-8 px-10 pb-10">
    @if (session('error'))
        <span class="text-red-500 text-xl">Hiba: {{ session('error') }}</span>
    @elseif(!empty(Session::all()))
        <span class="text-green-500 text-xl">
            {{ Session::has('enclosure-created') ? 'Kifutó sikeresen létrehozva!' : '' }}
            {{ Session::has('enclosure-updated') ? 'Kifutó sikeresen frissítve!' : '' }}
            {{ Session::has('enclosure-deleted') ? 'Kifutó sikeresen törölve!' : '' }}
        </span>
    @endif
</div>

    <div class="px-10 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($enclosures as $enclosure)
            <div class="card w-full bg-base-100 shadow-md relative h-60">
                @can('delete', $enclosure)
                    <form class="inline" method="POST" action="{{ route('enclosures.delete', ['enclosure' => $enclosure]) }}">
                        @csrf
                        @method('DELETE')
                            <a title="Törlés" class="btn btn-sm btn-error btn-outline absolute right-3 top-3" href="#"
                                onclick="this.closest('form').submit()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </a>
                    </form>
                @endcan
                <div class="card-body">

                    <h2 class="card-title text-2xl">{{ ucfirst($enclosure->name) }}</h2>
                    <div class="divider my-2"></div>

                    <div class="mt-2">
                        <p class="text-sm opacity-70 mb-1">Állatok száma: {{ count($enclosure->animals) }}</p>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium opacity-60">Limit: {{ $enclosure->limit }} </span>
                    </div>

                    <div class="card-actions justify-end mt-4">
                        <a title="Megnézem" href="{{ route('enclosures.show', ['enclosure' => $enclosure]) }}"
                            class="btn btn-sm btn-neutral">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>                        </a>
                        @can('update', $enclosure)
                            <a title="Szerkesztés" href="{{ route('enclosures.edit', ['enclosure' => $enclosure]) }}"
                                class="btn btn-sm btn-neutral btn-outline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-icon lucide-pen"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div>
                Nem vagy hozzárendelve egy kifutóhoz sem.
            </div>
        @endforelse
        @can('create', \App\Models\Enclosure::class)
            <a href="{{ route('enclosures.create') }}" class="block h-60" title="Új kifutó hozzáadása">
                <div
                    class="card w-full h-full bg-base-100 shadow-md cursor-pointer transition-transform hover:scale-[1.04] text-center">
                    <div class="card-body grid place-items-center">
                       <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                    </div>
                </div>
            </a>
        @endcan
    </div>
   <div class="mt-4">
    {{ $enclosures->links() }}
    </div >
@endsection
