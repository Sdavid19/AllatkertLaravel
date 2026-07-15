<?php

namespace App\Http\Requests;

use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateEnclosureRequest extends FormRequest
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
        $enclosure = $this->route('enclosure');

        if ($enclosure) {
            $enclosure->loadCount('animals');
        }

        return [
            "name" => "required|string|min:2",
            "limit" => [
                "required",
                "integer",
                "min:1",
                "max:20",
                function ($attribute, $value, $fail) use ($enclosure) {
                    if ($enclosure && $value < $enclosure->animals_count) {
                        $fail('A kifutóba több állat van, mint a megadott limit!');
                    }
                }
            ],
            'feeding_at' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "A név megadása kötelező!",
            "name.min" => "A névnek legalább :min karakter hosszúnak kell lennie!",
            "limit.required" => "A limit megadása kötelező!",
            "limit.integer" => "A limitnek egész számnak kell lennie!",
            "limit.min" => "A limitnek pozitív egész számnak kell lennie!",
            "limit.max" => "A limit maximum értéke :max lehet!",
            "feeding_at.required" => "Az etetési idő megadása kötelező!",
            "feeding_at.regex" => "Az etetési időt óra:perc (pl. 06:54) formátumban kell megadni!"
        ];
    }

}
