<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVesselRequest extends FormRequest
{
    public function rules(): array
    {
        $vesselId = $this->route('vessel')?->id;

        return [
            'boat_operator_id' => ['required', Rule::exists('boat_operators', 'id')],
            'name' => ['required', 'string', 'max:120'],
            'code' => ['nullable', 'string', 'max:20', Rule::unique('vessels', 'code')->ignore($vesselId)],
            'type' => ['required', 'string', 'max:80'],
            'capacity' => ['required', 'integer', 'min:1', 'max:1000'],
            'top_speed_knots' => ['nullable', 'integer', 'min:1', 'max:80'],
            'engine' => ['nullable', 'string', 'max:160'],
            'status' => ['required', Rule::enum(ListingStatus::class)],
            'inspected_at' => ['nullable', 'date'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:60'],
            'photos' => ['nullable', 'array', 'max:6'],
            'photos.*' => ['image', 'max:4096'],
        ];
    }
}
