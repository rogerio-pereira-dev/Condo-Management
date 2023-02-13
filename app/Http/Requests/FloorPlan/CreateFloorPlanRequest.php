<?php

namespace App\Http\Requests\FloorPlan;

use Illuminate\Foundation\Http\FormRequest;

class CreateFloorPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'bedrooms' => 'required|integer',
            'price' => 'required|numeric',
            'en_suite' => 'nullable|boolean',
            'has_garage' => 'nullable|boolean',
        ];
    }
}
