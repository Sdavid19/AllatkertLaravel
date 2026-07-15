<?php

namespace App\Http\Requests;

use App\Models\Enclosure;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|min:2",
            "species" => "required|string|min:2",
            "born_at" => "required|date|date_format:Y-m-d|before_or_equal:today",
            "image" => "nullable|file|image",
            "is_predator" => "required|integer|in:0,1",
            "enclosure_id" => "required|integer|exists:enclosures,id",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "A név megadása kötelező!",
            "name.min" => "A névnek legalább :min karakter hosszúnak kell lennie!",
            "species.required" => "A faj megadása kötelező!",
            "species.min" => "A névnek legalább :min karakter hosszúnak kell lennie!",
            "is_predator.required" => "A táplálkozási forma megadása kötelező!",
            "born_at.required" => "A születési idő megadása kötelező!",
            "born_at.date" => "A születési időnek dátumnak kell lennie!",
            "born_at.before_or_equal" => "Múltbeli dátumot adjon meg!",
            "born_at.date_format" => "A születési idő formátuma: 2021-03-12 legyen!",
            "image.image" => "A feltöltött fájl formátuma csak kép lehet (PNG, JPG vagy WEBP)!",
            "enclosure_id.required" => "A kifutó megadása kötelező!",
            "enclosure_id.exists" => "Nincs ilyen kifutó!"
        ];
    }

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $enclosure = Enclosure::with('animals')->find($this->input('enclosure_id'));
        if (!$enclosure) {
            return;
        }

        $animalCount = $enclosure->animals->count();
        $hasPredator = $enclosure->animals->where('is_predator', 1)->isNotEmpty();
        $hasHerbivore = $enclosure->animals->where('is_predator', 0)->isNotEmpty();
        $isPredator = $this->input('is_predator');

        if ($animalCount >= $enclosure->limit) {
            $validator->errors()->add('enclosure_id', 'A megadott kifutó tele van!');
            return;
        }

        if (($hasPredator && !$isPredator) || ($hasHerbivore && $isPredator)) {
            $validator->errors()->add('enclosure_id', 'Nem lehet egy kifutóban egyszerre növényevő és húsevő állat!');
            return;
        }
    });
}

}
