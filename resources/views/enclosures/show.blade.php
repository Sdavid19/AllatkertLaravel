@extends('layout')

@section('content')
    <h1 class="text-4xl font-bold px-6 pb-8 text-center">{{ ucfirst($enclosure->name) }} kifutó adatai</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mx-auto max-w-5xl">

        <div class="card w-full bg-base-100 shadow-md p-6 mx-auto">
            <div class="card-body text-center grid gap-4 place-items-center">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Állatok száma</h2>

                <div class="text-3xl font-extrabold">
                    {{ count($animals) }}
                </div>

                <progress class="progress progress-neutral w-full" value="{{ count($animals) }}"
                    max="{{ $enclosure->limit }}"></progress>

                <div class="text-sm text-gray-500">
                    Max. férőhely: {{ $enclosure->limit }}
                </div>
            </div>
        </div>

        <div class="card w-full bg-base-100 shadow-md p-6 mx-auto">
            <div class="card-body text-center">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Viselkedés</h2>
                @if (count($animals) === 0)
                    <div class="text-neutral mx-auto inline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-frown-icon lucide-frown"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
                    </div>
                    <p class="pt-2">Nincsenek állatok.</p>
                @elseif ($hasPredator)
                <div class="text-red-500 mx-auto inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-paw-print-icon lucide-paw-print"><circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/></svg>
                </div>
                <p class="pt-2">Ragadozó állatok!</p>
                @else
                <div class="inline text-green-500 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-vegan-icon lucide-vegan"><path d="M16 8q6 0 6-6-6 0-6 6"/><path d="M17.41 3.59a10 10 0 1 0 3 3"/><path d="M2 2a26.6 26.6 0 0 1 10 20c.9-6.82 1.5-9.5 4-14"/></svg>
                </div>
                <p class="pt-2">Növényevő állatok.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mx-auto mt-8 bg-base-100 shadow-xl rounded-box p-6 space-y-4 max-w-5xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Állatok a kifutóban 
        @if (session('error'))
             <span class="text-red-500 text-xl ml-5">Hiba: {{ session('error') }}</span>
        @elseif(!empty(Session::all()))
            <span class="text-green-500 text-xl ml-5">
                {{ Session::has('animal-created') ? 'Sikeres létrehozás!' : '' }}
                {{ Session::has('animal-updated') ? 'Sikeres frissítés!' : '' }}
                {{ Session::has('animal-deleted') ? 'Sikeres archiválás!' : '' }}
            </span>
        @endif
        </h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>Faj</th>
                        <th>Születési idő</th>
                        @can('isAdmin', \App\Models\Animal::class)
                            <th>Akciók</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @can('create', \App\Models\Enclosure::class)
                    <tr class="hover:bg-gray-100 cursor-pointer">
                        <td colspan="4">
                            <a href="{{ route('animals.create', ['enclosure_id' => $enclosure->id]) }}" class="block">
                                <div class="flex items-center gap-3">
                                    <div class="grid place-items-center w-16 h-16">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                    </div>
                                    <div>
                                        <div class="font-bold">Állat hozzáadása</div>
                                    </div>
                                </div>
                            </a>
                        </td>
                    </tr>
                    @endcan
                    @forelse ($animals as $animal)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle h-16 w-16">
                                        @if ($animal->image)
                                            <img src="{{ Storage::url($animal->image) }}">
                                        @else
                                            <img src="https://placehold.co/400x400?text=Nincs_kép">
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold">{{ $animal->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $animal->species }}</td>
                        <td>{{ $animal->born_at }}</td>
                        <td class="whitespace-nowrap w-20">
                            <div class="flex items-center justify-center gap-3">
                                @can('update', $animal)
                                    <a href="{{ route('animals.edit', ['animal' => $animal]) }}" title="szerkesztés">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pen-icon lucide-pen"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>
                                    </a>
                                @endcan 
                                @can('delete', $animal)
                                    <form class="inline" method="POST" action="{{ route('animals.delete', ['animal' => $animal]) }}">
                                        @csrf
                                        @method('DELETE')
                                            <a title="Archiválás" href="#"
                                                onclick="this.closest('form').submit()">
                                                <span class="text-red-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-archive-icon lucide-archive"><rect width="20" height="5" x="2" y="3" rx="1"/><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"/><path d="M10 12h4"/></svg>
                                                </span>
                                            </a>
                                    </form>
                                @endcan
                            </div>
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td>Nincsenek állatok a kifutóban.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
