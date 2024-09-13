<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckOutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->checkIn->user->status->status(),
            'check_in_date' => $this->checkIn->created_at,
            'check_out_date' => $this->created_at,
            'attendance_hours'=>hoursToTime(differenceInHours($this->checkIn->created_at,$this->created_at))

        ];
    }
}
