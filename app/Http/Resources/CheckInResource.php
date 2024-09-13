<?php

namespace App\Http\Resources;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckInResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => Auth::user()->status->status(),
            'check_in_date' => $this->created_at,
            'check_out_date' => $this->when($this->checkout , function () {
                return $this->checkout->created_at;
            }),


        ];
    }
}
