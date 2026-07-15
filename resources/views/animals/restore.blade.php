@extends('layout')

@section('content')
    <h1 class="text-4xl pb-10 px-10 font-semibold text-center">
        Állat visszaállítása: {{ $animal->name }}</h1>

    <div class="px-4 md:px-10 flex justify-center">
        <div class="card w-full max-w-xl bg-base-100 shadow-md p-8">
            <form method="POST" action="{{ route('animals.restore', ['animal' => $animal]) }}" enctype="multipart/form-data" class="grid gap-2">
                @csrf
                @method('PATCH')

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Kifutó</legend>
                    <select name="enclosure_id" class="select w-full">
                        <option disabled selected>Hova kerüljön vissza?</option>
                        @foreach ($enclosures as $enclosure)
                            <option value="{{ $enclosure->id }}"
                                {{ old('enclosure_id') == $enclosure->id ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-neutral px-10">Visszaállítás</button>
                </div>

            </form>
        </div>
    </div>
@endsection
