<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vadaspark</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-neutral-200">
<nav class="navbar bg-neutral text-white p-2">
    <div class="flex-1">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-2xl">Vadaspark</a>
    </div>
    <div class="flex-none navbar-start">
        <ul class="menu menu-horizontal px-1">
            <li tabindex="0" class="mx-2">
                <details>
                    <summary class="text-lg hover:text-neutral-400">Kifutók</summary>
                    <ul class="p-2 bg-neutral">
                        <li><a href="{{ route('enclosures.index') }}">Listázás</a></li>
                        @can('create', \App\Models\Enclosure::class)
                            <li><a href="{{ route('enclosures.create') }}">Létrehozás</a></li>
                        @endcan
                    </ul>
                </details>
            </li>
            @can('isAdmin', \App\Models\Enclosure::class)
            <li tabindex="0" class="mx-2">
                <details>
                    <summary class="text-lg hover:text-neutral-400">Állatok</summary>
                    <ul class="p-2 bg-neutral">
                            <li><a href="{{ route('animals.index') }}">Archiváltak</a></li>

                        @can('create', \App\Models\Animal::class)
                            <li><a href="{{ route('animals.create') }}">Létrehozás</a></li>
                        @endcan
                    </ul>
                </details>
            </li>
            @endcan
        </ul>
    </div>
    @auth
        <div class="navbar-end">
            <span class="mx-5">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-error">Kijelentkezés</button>
            </form>
        </div>
    @endauth
</nav>

    <div class="p-5">
        @yield('content')
    </div>
</body>

</html>
