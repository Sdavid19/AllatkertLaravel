@extends('layout')

@section('content')
    <h1 class="text-4xl pb-10 px-10 font-semibold text-center">Kifutó szerkesztése</h1>

    <div class="px-4 md:px-10 flex justify-center">
        <div class="card w-full max-w-xl bg-base-100 shadow-md p-8">
            <form action="{{ route('enclosures.update', ['enclosure' => $enclosure]) }}" enctype="multipart/form-data"
                method="POST" class="grid gap-6">
                @csrf
                @method('PATCH')
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Kifutó neve</legend>
                    <input name="name" value="{{ old('name', $enclosure->name) }}" type="text"
                        class="input input-bordered w-full" />
                    @error('name')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Limit</legend>
                    <input name="limit" value="{{ old('limit', $enclosure->limit) }}" type="text"
                        class="input input-bordered w-full" />
                    @error('limit')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Etetési idő</legend>
                    <input name="feeding_at" value="{{ old('feeding_at', $enclosure->feeding_at) }}" type="text"
                        class="input input-bordered w-full">
                    @error('feeding_at')
                        <span class="text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </fieldset>

                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Gondozók</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-35 overflow-y-auto p-2">
                        @foreach ($users as $user)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                    {{ in_array($user->id, $enclosureUsers) ? 'checked' : '' }}
                                    class="checkbox checkbox-sm" />
                                <span>{{ $user->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                @if (session('error'))
                    <div class="text-red-500">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-center pt-4">
                    <button type="submit" class="btn btn-neutral px-10">Mentés</button>
                </div>
            </form>
        </div>
    </div>
@endsection
