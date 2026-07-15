@extends('layout')

@section('content')
    <h1 class="text-4xl pb-10 px-10 font-semibold text-center">
        Új kifutó felvétele</h1>

    <div class="px-4 md:px-10 flex justify-center">
        <div class="card w-full max-w-xl bg-base-100 shadow-md p-8">
            <form action="{{ route('enclosures.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-6">
                @csrf
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Kifutó neve</legend>
                    <input name="name" type="text" value="{{ old('name') }}" placeholder="Nagy kifutó"
                        class="input input-bordered w-full" />
                    @error('name')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Limit</legend>
                    <input name="limit" value="{{ old('limit') }}" type="text" placeholder="5"
                        class="input input-bordered w-full" />
                    @error('limit')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Etetési idő</legend>
                    <input name="feeding_at" value="{{ old('feeding_at') }}" type="texts" placeholder="10:34"
                        class="input input-bordered w-full">
                    @error('feeding_at')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="btn btn-neutral px-10">Létrehozás</button>
                </div>
            </form>
        </div>
    </div>
@endsection
