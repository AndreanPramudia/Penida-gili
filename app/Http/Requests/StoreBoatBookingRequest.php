<?php

namespace App\Http\Requests;

use App\Models\Schedule;
use Illuminate\Validation\Rule;

class StoreBoatBookingRequest extends StoreBookingRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'schedule_id' => [
                'required',
                Rule::exists('schedules', 'id')->where('boat_operator_id', $this->route('boat')->id)->where('status', 'active'),
            ],
        ];
    }

    public function schedule(): Schedule
    {
        return Schedule::query()->with(['operator', 'fromPort', 'toPort'])->findOrFail($this->integer('schedule_id'));
    }
}
