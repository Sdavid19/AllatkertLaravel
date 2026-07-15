@extends('layout')

@section('content')
    <h1 class="text-4xl pb-10 px-10 font-semibold text-center">
        Állat szerkesztése</h1>

    <div class="px-4 md:px-10 flex justify-center">
        <div class="card w-full max-w-xl bg-base-100 shadow-md p-8">
            <form method="POST" action="{{ route('animals.update', ['animal' => $animal]) }}" enctype="multipart/form-data" class="grid gap-2">
                @csrf
                @method('PATCH')
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Állat neve</legend>
                    <input name="name" type="text" value="{{ old('name', $animal->name) }}" placeholder="Berci"
                        class="input input-bordered w-full" />
                    @error('name')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Állatfaj</legend>
                    <input name="species" type="text" value="{{ old('species', $animal->species) }}" placeholder="Gorilla"
                        class="input input-bordered w-full" />
                    @error('species')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Táplálkozás</legend>
                    <div class="flex flex-start">
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 md:gap-5 pt-2 ">
                            <label for="notPredator" class="cursor-pointer">
                                <input id="notPredator" class="radio" type="radio" name="is_predator" value="0"
                                    {{ old('is_predator', $animal->is_predator) == 0 ? 'checked' : '' }}>
                                Növényevő
                            </label>

                            <label for="predator" class="cursor-pointer">
                                <input id="predator" class="radio" type="radio" name="is_predator" value="1"
                                    {{ old('is_predator', $animal->is_predator) == 1? 'checked' : '' }}>
                                Húsevő
                            </label>
                        </div>
                    </div>
                    @error('is_predator')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror

                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Születési idő</legend>
                    <input name="born_at" type="date" value="{{ old('born_at', $animal->born_at) }}" placeholder="Nagy kifutó"
                        class="input input-bordered w-full" />
                    @error('born_at')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Kép</legend>
                    <input name="image" type="file" value="{{ old('image') }}" placeholder="Nagy kifutó"
                        class="file-input w-full" />
                    @error('image')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Kifutó</legend>
                    <select name="enclosure_id" class="select w-full">
                        <option disabled selected>Válassz kifutót</option>
                        @foreach ($enclosures as $enclosure)
                            <option value="{{ $enclosure->id }}"
                                {{ old('enclosure_id', $animal->enclosure_id ?? '') == $enclosure->id ? 'selected' : '' }}>
                                {{ $enclosure->name }}</option>
                        @endforeach
                    </select>
                    @error('enclosure_id')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                @if (session('error'))
                    <div class="text-red-500">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-center pt-4">
                    <button type="submit" class="btn btn-neutral px-10">Firssítés</button>
                </div>

            </form>
        </div>
    </div>
@endsection
