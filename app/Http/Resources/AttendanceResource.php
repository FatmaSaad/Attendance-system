<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'check_in_date' => Carbon::parse($this->created_at)->format('Y-m-d h:m:s'),
            'check_out_date' => $this->when($this->checkout , function () {
                return Carbon::parse($this->checkout->created_at)->format('Y-m-d h:m:s');
            }),


        ];
    }
}
