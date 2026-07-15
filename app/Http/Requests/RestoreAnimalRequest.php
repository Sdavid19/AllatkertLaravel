<?php

namespace App\Http\Requests;

use App\Models\Enclosure;
use Illuminate\Foundation\Http\FormRequest;

class RestoreAnimalRequest extends FormRequest
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
            "enclosure_id" => "required|integer|exists:enclosures,id"
        ];
    }

    public function messages(): array{
        return [
            "enclosure_id.required" => "A kifutó megadása kötelező!",
            "enclosure_id.exists" => "Nincs ilyen kifutó!"
        ];
    }

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $enclosure = Enclosure::find($this->input('enclosure_id'));
        
        if (!$enclosure) {
            return;
        }

        $animal = $this->route('animal');

        if (!$animal) {
            return;
        }

        $isPredator = $animal->is_predator;

        $hasPredator = $enclosure->animals->where('is_predator', 1)->isNotEmpty();
        $hasHerbivore = $enclosure->animals->where('is_predator', 0)->isNotEmpty();

        if ($enclosure->animals->count() >= $enclosure->limit) {
            $validator->errors()->add('enclosure_id', 'A megadott kifutó tele van!');
            return;
        }

        if (!$isPredator && $hasPredator) {
            $validator->errors()->add('enclosure_id', 'Nem lehet növényevő állatot húsevőkhöz tenni!');
            return;
        }

        if ($isPredator && $hasHerbivore) {
            $validator->errors()->add('enclosure_id', 'Nem lehet húsevő állatot növényevőkhöz tenni!');
            return;
        }
    });
}
}
