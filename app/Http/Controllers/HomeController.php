<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $duties = $user->enclosures
            ->sortBy('feeding_at')
            ->map(function ($enclosure) {
                return [
                    "enclosure" => $enclosure->name,
                    "feedingDateTime" => new Carbon($enclosure->feeding_at)
                ];
            })
            ->filter(function ($duty) {
                return $duty['feedingDateTime']->isAfter(now());
            })
            ->map(function ($duty) {
                return [
                    "enclosure" => $duty['enclosure'],
                    "feedingTime" => $duty['feedingDateTime']->format('H:i')
                ];
            })
            ->values();

        return view('index', [
            "enclosures" => Enclosure::all(),
            "animals" => Animal::all(),
            "duties" => $duties
        ]);
    }
}
