<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'boat_operator_id' => ['required', Rule::exists('boat_operators', 'id')],
            'vessel_id' => ['nullable', Rule::exists('vessels', 'id')->where('boat_operator_id', $this->integer('boat_operator_id'))],
            'from_port_id' => ['required', Rule::exists('ports', 'id')],
            'to_port_id' => ['required', 'different:from_port_id', Rule::exists('ports', 'id')],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i', 'after:departure_time'],
            'price_adult' => ['required', 'integer', 'min:0'],
            'price_child' => ['required', 'integer', 'min:0'],
            'price_foreign' => ['nullable', 'integer', 'min:0'],
            'days' => ['nullable', 'array'],
            'days.*' => [Rule::in(Schedule::DAYS)],
            'status' => ['required', Rule::enum(ListingStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'to_port_id.different' => 'Arrival port must differ from the departure port.',
            'arrival_time.after' => 'Arrival must be later than departure.',
        ];
    }

    /**
     * Validated attributes ready for the model. Selecting every day is the
     * same as "daily", so it is stored as null to keep the search simple.
     *
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        $data = $this->validated();
        $days = array_values(array_unique($data['days'] ?? []));
        $data['days'] = ($days === [] || count($days) === count(Schedule::DAYS)) ? null : $days;
        $data['vessel_id'] = $data['vessel_id'] ?? null;
        $data['price_foreign'] = $data['price_foreign'] ?? null;

        return $data;
    }
}
