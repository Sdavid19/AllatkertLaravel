<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    use HasFactory;

    use SoftDeletes;
       
    protected $fillable = [
        'name',
        'species',
        'born_at',
        'is_predator',
        'image',
        'enclosure_id'
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
    }

    public function enclosure()
    {
        return $this->belongsTo(Enclosure::class);
    }
}
