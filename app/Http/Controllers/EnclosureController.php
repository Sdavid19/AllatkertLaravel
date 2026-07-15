<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateEnclosureRequest;
use App\Models\Enclosure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class EnclosureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $query = $user->admin
            ? Enclosure::query()
            : $user->enclosures();

        $enclosures = $query
            ->with('animals')
            ->orderByRaw('LOWER(name)')
            ->paginate(5);

        return view('enclosures.index', [
            'enclosures' => $enclosures,
        ]);
    }   


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Enclosure::class);

        return view('enclosures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrUpdateEnclosureRequest $request)
    {
        Gate::authorize('create', Enclosure::class);

        $validated = $request->validated();
        Enclosure::create($validated);

        Session::flash('enclosure-created');
        return redirect()->route('enclosures.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enclosure $enclosure)
    {
        Gate::authorize('view', $enclosure);

        $animals = $enclosure->animals()
            ->orderByRaw('Lower(species)')
            ->orderBy('born_at')
            ->get()
            ->map(function ($animal) {
                $animal->born_at = (new Carbon($animal->born_at))->format('Y. m. d.');
                return $animal;
            });

        $hasPredator = $animals->contains('is_predator', 1);

        return view('enclosures.show', [
            "enclosure" => $enclosure,
            "animals" => $animals,
            "hasPredator" => $hasPredator
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enclosure $enclosure)
    {
        Gate::authorize('update', $enclosure);

        $users = User::all();

        return view('enclosures.edit', [
            "enclosure" => $enclosure,
            "enclosureUsers" => $enclosure->users()->pluck('id')->toArray(),
            "users" => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOrUpdateEnclosureRequest $request, Enclosure $enclosure)
    {
        Gate::authorize('update', $enclosure);

        $validated = $request->validated();

        $userIds = $request->input('user_ids', []);

        $enclosure->update($validated);

        $enclosure->users()->sync($userIds);

        Session::flash('enclosure-updated');
        return redirect()->route('enclosures.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enclosure $enclosure)
    {
        Gate::authorize('delete', $enclosure);

        if ($enclosure->animals()->exists()) {
            return back()->with('error', 'Csak üres kifutót lehet törölni!');
        }

        $enclosure->users()->detach();
        
        $enclosure->delete();

        Session::flash('enclosure-deleted');

        return redirect()->route('enclosures.index');
    }
}
