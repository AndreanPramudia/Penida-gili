<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Vessel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->filled('route')) {
            $routeId = (int) $this->input('route');

            if ($routeId > 0) {
                $merge['route_id'] = $routeId;
            }
        }

        if ($this->filled('vessel_id') && ! $this->filled('boat_operator_id')) {
            $merge['boat_operator_id'] = Vessel::query()
                ->whereKey($this->integer('vessel_id'))
                ->value('boat_operator_id');
        }

        if ($this->filled('publish')) {
            $merge['status'] = $this->input('publish') === 'draft'
                ? ListingStatus::Draft->value
                : ListingStatus::Active->value;
        }

        $this->merge($merge);
    }

    public function rules(): array
    {
        return [
            'route' => ['nullable', 'integer', Rule::exists('routes', 'id')],
            'route_id' => ['required', Rule::exists('routes', 'id')],

            'publish' => ['nullable', Rule::in(['publish', 'draft'])],

            'boat_operator_id' => [
                'required',
                Rule::exists('boat_operators', 'id'),
            ],

            'vessel_id' => [
                'required',
                Rule::exists('vessels', 'id')
                    ->where('boat_operator_id', $this->integer('boat_operator_id')),
            ],

            'departure_time' => ['required', 'date_format:H:i'],

            'arrival_time' => [
                'required',
                'date_format:H:i',
                'after:departure_time',
            ],

            'price_adult' => ['required', 'integer', 'min:0'],
            'price_child' => ['required', 'integer', 'min:0'],
            'price_foreign' => ['nullable', 'integer', 'min:0'],

            'days' => ['nullable', 'array'],
            'days.*' => [Rule::in(Schedule::DAYS)],

            'status' => [
                'required',
                Rule::enum(ListingStatus::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'route_id.required' => 'Choose a route.',
            'route_id.exists' => 'The selected route does not exist.',
            'arrival_time.after' => 'Arrival must be later than departure.',
        ];
    }

    /**
     * Validated attributes ready for the Schedule model.
     *
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        $data = collect($this->validated())
            ->except(['route', 'publish'])
            ->all();

        $days = array_values(array_unique($data['days'] ?? []));

        $data['days'] = (
            $days === []
            || count($days) === count(Schedule::DAYS)
        ) ? null : $days;

        $data['price_foreign'] = $data['price_foreign'] ?? null;

        return $data;
    }
}