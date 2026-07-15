@extends('layout')

@section('content')
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center m-8">
            <h1 class="text-3xl md:text-4xl font-bold">Üdvözöllek
                @auth
                    {{ Auth::user()->name }}!
                @endauth
            </h1>
        </div>

        <ul class="bg-base-100 rounded-box shadow-lg p-4 md:col-span-2 mb-12">
            <li class="pb-4 text-xs opacity-60 tracking-wide font-semibold text-gray-700">Teendők listája</li>

            @forelse ($duties as $duty)
                <li class="flex items-center space-x-4 border-b border-gray-200 py-3 cursor-pointer">
                    <div class="text-3xl font-semibold opacity-80 tabular-nums">{{ $duty['feedingTime'] }}</div>
                    <div class="flex-grow">
                        <div class="font-semibold text-lg">Etetés</div>
                        <div class="text-xs font-semibold text-gray-500">Kifutó: {{ $duty['enclosure'] }} </div>
                    </div>
                </li>
            @empty
                <li class="flex items-center space-x-4 border-b border-gray-200 py-3 cursor-pointer">
                    <div class="flex-grow">
                        <div class="font-semibold text-lg">Nincs teendőd.</div>
                    </div>
                </li>
            @endforelse
        </ul>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
            <div class="card bg-base-100 shadow-xl w-full min-h-[250px]">
                <div class="card-body text-center">
                    <h2 class="text-xl font-semibold">Kifutók száma</h2>
                    <p class="text-5xl font-bold">{{ count($enclosures) }}</p>
                    <p>Modern kifutó gondoskodik az állatok jólétéről.</p>
                    <a class="btn btn-neutral" href="{{ route('enclosures.index') }}">Megnézem</a>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl w-full min-h-[250px]">
                <div class="card-body text-center">
                    <h2 class="text-xl font-semibold">Állatok száma</h2>
                    <p class="text-5xl font-bold">{{ count($animals) }}</p>
                    <p>Változatos, gondosan tartott állat van állatkerünkben.</p>
                    @can('create', App\Models\Animal::class)
                        <a class="btn btn-neutral" href="{{ route('animals.create') }}">Új hozzáadása</a>
                    @else
                         <span class="btn btn-neutral btn-disabled">Új hozzáadása</span>
                    @endcan
                </div>
            </div>

        </div>
    </div>
@endsection
