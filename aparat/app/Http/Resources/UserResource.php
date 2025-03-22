<?php

namespace App\Http\Resources;

use App\Helpers\JalaliDate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'email' => $this->email,
            'mobile' => $this->mobile,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'created_at' => JalaliDate::toJalaliDate($this->created_at),
            'updated_at' => JalaliDate::toJalaliDate($this->updated_at)
        ];
    }
}
