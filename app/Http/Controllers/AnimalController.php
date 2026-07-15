<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateAnimalRequest;
use App\Http\Requests\RestoreAnimalRequest;
use App\Models\Animal;
use App\Models\Enclosure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $animals = Animal::onlyTrashed()->orderBy('deleted_at', 'desc')->get();

        return view('animals.index', [
            'animals' => $animals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Animal::class);

        $enclosureId = $request->get('enclosure_id');
        $enclosures = Enclosure::all();

        return view('animals.create', [
            'enclosures' => $enclosures,
            'selectedEnclosureId' => $enclosureId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrUpdateAnimalRequest $request)
    {
        Gate::authorize('create', Animal::class);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $filename = Str::uuid() . '.' . $request->file('image')->extension();
            Storage::disk('public') -> put($filename, $request -> file('image') -> get());
            $validated['image'] = $filename;
        } else
            $validated['image'] = null;

        Animal::create($validated);

        Session::flash('animal-created');

        return redirect()->route('enclosures.show', $validated['enclosure_id']);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        Gate::authorize('update', $animal);

        $enclosures = Enclosure::all();

        $animal->born_at = (new Carbon($animal->born_at))->format('Y-m-d');
        
        return view('animals.edit', [
            'enclosures' => $enclosures,
            'animal' => $animal
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOrUpdateAnimalRequest $request, Animal $animal)
    {
        Gate::authorize('update', $animal);

        $validated = $request->validated();

        if ($request->has('image')) {
            
            Storage::disk('public')->delete($animal->image);
            $filename = Str::uuid() . '.' . $request->file('image')->extension();
            Storage::disk('public') -> put($filename, $request -> file('image') -> get());           
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $animal->image;
        }

        $animal->update($validated);

        Session::flash('animal-updated');

        return redirect()->route('enclosures.show', $validated['enclosure_id']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        Gate::authorize('delete', $animal);

        $enclosure = Enclosure::find($animal->enclosure_id);

        $animal->enclosure_id = null;

        $animal->save();

        $animal->delete();

        Session::flash('animal-deleted');

        return redirect()->route('enclosures.show', ['enclosure' => $enclosure]);
    }

    public function showRestoreForm(Animal $animal){

         Gate::authorize('restore', $animal);
        
         return view('animals.restore', [
            'animal' => $animal,
            'enclosures' => Enclosure::all()
        ]);
    }

    public function restore(RestoreAnimalRequest $request, Animal $animal)
    {
        Gate::authorize('restore', $animal);

        $validated = $request->validated();

        $animal->enclosure_id = $validated['enclosure_id'];
        $animal->save();

        $animal->restore();

        Session::flash('animal-restored');
        return redirect()->route('animals.index');
    }
}
